<?php

declare(strict_types=1);

namespace Rai\ProductReminder\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Reminder extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('product_reminder', 'id');
    }
}
