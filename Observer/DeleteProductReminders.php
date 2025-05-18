<?php

declare(strict_types=1);

namespace Rai\ProductReminder\Observer;

use Exception;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Rai\ProductReminder\Model\ResourceModel\Reminder\CollectionFactory;
use Rai\ProductReminder\Model\ResourceModel\Reminder;

class DeleteProductReminders implements ObserverInterface
{
    /**
     * @param CollectionFactory $collectionFactory
     * @param Reminder $reminderResource
     */
    public function __construct(
        private CollectionFactory $collectionFactory,
        private Reminder $reminderResource
    ) {}

    /**
     * @param Observer $observer
     * @return void
     * @throws Exception
     */
    public function execute(Observer $observer)
    {
        $product = $observer->getEvent()->getProduct();
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('product_id', $product->getId());

        foreach ($collection as $reminder) {
            $this->reminderResource->delete($reminder);
        }
    }
}
