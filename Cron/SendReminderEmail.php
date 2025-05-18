<?php

declare(strict_types=1);

namespace Rai\ProductReminder\Cron;

use Rai\ProductReminder\Model\ResourceModel\Reminder\CollectionFactory;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Psr\Log\LoggerInterface;

class SendReminderEmail
{
    /**
     * @param CollectionFactory $collectionFactory
     * @param CustomerRepositoryInterface $customerRepository
     * @param ProductRepositoryInterface $productRepository
     * @param TransportBuilder $transportBuilder
     * @param StoreManagerInterface $storeManager
     * @param LoggerInterface $logger
     * @param DateTime $dateTime
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        private CollectionFactory $collectionFactory,
        private CustomerRepositoryInterface $customerRepository,
        private ProductRepositoryInterface $productRepository,
        private TransportBuilder $transportBuilder,
        private StoreManagerInterface $storeManager,
        private LoggerInterface $logger,
        private DateTime $dateTime,
        private ScopeConfigInterface $scopeConfig
    ) {}

    /**
     * @return void
     */
    public function execute()
    {
        $this->logger->info('=== Product Reminder Cron STARTED ===');
        $collection = $this->collectionFactory->create();
        $today = $this->dateTime->date('Y-m-d');
        $nextWeek = date('Y-m-d', strtotime('+7 days'));
        $collection->addFieldToFilter('reminder_date', ['in' => [$today, $nextWeek]]);
        $collection->addFieldToFilter('status', 'Pending');

        foreach ($collection as $reminder) {
            try {
                $this->logger->info('Processing Reminder ID: ' . $reminder->getId() . ', Date: ' . $reminder->getReminderDate());
                $reminderDate = $reminder->getReminderDate();
                $today = $this->dateTime->date('Y-m-d');
                $nextWeek = date('Y-m-d', strtotime('+7 days'));
                if ($reminderDate == $today) {
                    $templateId = 'product_reminder_email_template';
                    $markAsSent = true;
                } elseif ($reminderDate == $nextWeek) {
                    $templateId = 'product_upcoming_reminder_email_template';
                    $markAsSent = false;
                } else {
                    continue;
                }

                $customer = $this->customerRepository->getById($reminder->getCustomerId());
                $product = $this->productRepository->getById($reminder->getProductId());
                $emailSender = $this->scopeConfig->getValue('product_reminder/product_reminder_group/email_sender', ScopeInterface::SCOPE_STORE);
                $from = ['email' => $emailSender ?? 'no-reply@example.com', 'name' => 'Product Reminder'];
                $defaultMessage = $this->scopeConfig->getValue('product_reminder/product_reminder_group/default_message', ScopeInterface::SCOPE_STORE);

                $transport = $this->transportBuilder
                    ->setTemplateIdentifier($templateId)
                    ->setTemplateOptions([
                        'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                        'store' => $this->storeManager->getStore()->getId()
                    ])->setTemplateVars([
                        'customer_name' => $customer->getFirstname() ?? 'Customer',
                        'product_name'  => $product->getName() ?? 'Product',
                        'product_url'   => $product->getProductUrl() ?? '#',
                        'message'   => $defaultMessage,
                    ])
                    ->setFromByScope($from, $this->storeManager->getStore()->getId())
                    ->addTo($customer->getEmail(), $customer->getFirstname())
                    ->getTransport();
                $transport->sendMessage();

                if ($markAsSent) {
                    $reminder->setStatus('Sent')->save();
                    $this->logger->info('Reminder marked as Sent');
                }
            } catch (\Exception $e) {
                $this->logger->error('Reminder Cron Error: ' . $e->getMessage());
            }
        }
    }
}
