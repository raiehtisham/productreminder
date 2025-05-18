<?php

declare(strict_types=1);

namespace Rai\ProductReminder\Api;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Phrase;
use Rai\ProductReminder\Api\Data\ReminderInterface;

interface ReminderRepositoryInterface
{
    /**
     * Set reminder
     *
     * @param int $customerId
     * @param int $productId
     * @param string $reminderDate
     * @return string[]
     * @throws LocalizedException
     */
    public function setReminder(int $customerId, int $productId, string $reminderDate);

    /**
     * Get reminders for a customer
     *
     * @param int $customerId
     * @return ReminderInterface[]
     */
    public function getReminders(int $customerId);


    /**
     * Delete a reminder by ID
     * @param int $id
     * @return bool
     */
    public function deleteReminder(int $id);
}
