<?php

namespace CleanPhp\Invoicer\Persistence\Zend\DataTable;

use CleanPhp\Invoicer\Domain\Repository\OrderRepositoryInterface;

/**
 * Class OrderTable
 * @package CleanPhp\Invoicer\Persistence\Zend\DataTable
 */
class OrderTable extends AbstractDataTable implements OrderRepositoryInterface
{
    /**
     * @return array
     */
    public function getUninvoicedOrders()
    {
        return $this->gateway->select('id NOT IN(SELECT order_id FROM invoices)');
    }
}
