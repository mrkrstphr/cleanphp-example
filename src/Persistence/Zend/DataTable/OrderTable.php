<?php

namespace CleanPhp\Invoicer\Persistence\Zend\DataTable;

use CleanPhp\Invoicer\Domain\Repository\OrderRepositoryInterface;

/**
 * Class OrderTable
 * @package CleanPhp\Invoicer\Persistence\Zend\DataTable
 */
class OrderTable extends AbstractDataTable
    implements OrderRepositoryInterface
{
    /**
     * @return array
     */
    public function getUninvoicedOrders()
    {
        return [];
    }
}
