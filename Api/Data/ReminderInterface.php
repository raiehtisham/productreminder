<?php

declare(strict_types=1);

namespace Rai\ProductReminder\Api\Data;

interface ReminderInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @param $id
     * @return int
     */
    public function setId($id);

    /**
     * @return int
     */
    public function getCustomerId();

    /**
     * @param $customerId
     * @return int
     */
    public function setCustomerId($customerId);

    /**
     * @return int
     */
    public function getProductId();

    /**
     * @param $productId
     * @return int
     */
    public function setProductId($productId);

    /**
     * @return string
     */
    public function getReminderDate();

    /**
     * @param $date
     * @return string
     */
    public function setReminderDate($date);

    /**
     * @return string
     */
    public function getStatus();

    /**
     * @param $status
     * @return string
     */
    public function setStatus($status);
}
