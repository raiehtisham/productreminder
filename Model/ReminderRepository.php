<?php

declare(strict_types=1);

namespace Rai\ProductReminder\Model;

use Magento\Framework\DataObject;
use Magento\Framework\Exception\AlreadyExistsException;
use Rai\ProductReminder\Api\Data\ReminderInterface;
use Rai\ProductReminder\Api\ReminderRepositoryInterface;
use Rai\ProductReminder\Model\ReminderFactory;
use Rai\ProductReminder\Model\ResourceModel\Reminder as ReminderResource;
use Rai\ProductReminder\Model\ResourceModel\Reminder\CollectionFactory;
use Magento\Framework\Exception\LocalizedException;

class ReminderRepository implements ReminderRepositoryInterface
{
    /**
     * @param ReminderFactory $reminderFactory
     * @param ReminderResource $reminderResource
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        private ReminderFactory $reminderFactory,
        private ReminderResource $reminderResource,
        private CollectionFactory $collectionFactory
    ) {}

    /**
     * @param $customerId
     * @param $productId
     * @param $reminderDate
     * @return string[]
     * @throws AlreadyExistsException
     * @throws LocalizedException
     */
    public function setReminder($customerId, $productId, $reminderDate): array
    {
        $now = date('Y-m-d');
        if ($reminderDate <= $now) {
            throw new LocalizedException(__('Reminder date must be in the future.'));
        }

        $reminder = $this->reminderFactory->create();
        $reminder->setCustomerId($customerId)
            ->setProductId($productId)
            ->setReminderDate($reminderDate)
            ->setStatus('Pending');

        $this->reminderResource->save($reminder);
        return ['message' => 'Reminder successfully saved.'];
    }

    /**
     * @param $customerId
     * @return DataObject[]
     */
    public function getReminders($customerId)
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('customer_id', $customerId);

        return $collection->getItems();
    }

    /**
     * @param int $id
     * @return true
     * @throws LocalizedException
     */
    public function deleteReminder(int $id)
    {
        $reminder = $this->reminderFactory->create();
        $this->reminderResource->load($reminder, $id);
        if (!$reminder->getId()) {
            throw new LocalizedException(__('Reminder not found.'));
        }
        $this->reminderResource->delete($reminder);
        return true;
    }
}
