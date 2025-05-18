<?php

declare(strict_types=1);

namespace Rai\ProductReminder\Model;

use Magento\Framework\Model\AbstractModel;
use Rai\ProductReminder\Api\Data\ReminderInterface;

class Reminder extends AbstractModel implements ReminderInterface
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(\Rai\ProductReminder\Model\ResourceModel\Reminder::class);
    }

    /**
     * Get reminder ID
     * @return int|mixed|null
     */
    public function getId()
    {
        return $this->_getData('id');
    }

    /**
     * Set reminder ID
     *
     * @param $id
     * @return Reminder
     */
    public function setId($id)
    {
        return $this->setData('id', $id);
    }

    /**
     * Get customer ID
     *
     * @return int|mixed|null
     */
    public function getCustomerId()
    {
        return $this->_getData('customer_id');
    }

    /**
     * Set customer ID
     *
     * @param $customerId
     * @return Reminder
     */
    public function setCustomerId($customerId)
    {
        return $this->setData('customer_id', $customerId);
    }

    /**
     * Get product ID
     *
     * @return int|mixed|null
     */
    public function getProductId()
    {
        return $this->_getData('product_id');
    }

    /**
     * Set product ID
     *
     * @param $productId
     * @return Reminder
     */
    public function setProductId($productId)
    {
        return $this->setData('product_id', $productId);
    }

    /**
     * Get reminder date
     *
     * @return string|null
     */
    public function getReminderDate()
    {
        return $this->_getData('reminder_date');
    }

    /**
     * Set reminder date
     *
     * @param $date
     * @return Reminder
     */
    public function setReminderDate($date)
    {
        return $this->setData('reminder_date', $date);
    }

    /**
     * Get reminder status
     *
     * @return mixed|string|null
     */
    public function getStatus()
    {
        return $this->_getData('status');
    }

    /**
     * Set reminder status
     *
     * @param int $status
     * @return Reminder
     */
    public function setStatus($status)
    {
        return $this->setData('status', $status);
    }
}
