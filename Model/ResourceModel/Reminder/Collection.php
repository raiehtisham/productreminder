<?php

declare(strict_types=1);

namespace Rai\ProductReminder\Model\ResourceModel\Reminder;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Rai\ProductReminder\Model\Reminder as Model;
use Rai\ProductReminder\Model\ResourceModel\Reminder as ResourceModel;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
