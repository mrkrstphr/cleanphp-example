<?php

namespace CleanPhp\Invoicer\Domain\Factory;

use CleanPhp\Invoicer\Domain\Entity\Invoice;
use CleanPhp\Invoicer\Domain\Entity\Order;

/**
 * Class InvoiceFactory
 * @package CleanPhp\Invoicer\Domain\Factory
 */
class InvoiceFactory
{
    /**
     * @param Order $order
     * @return Invoice
     */
    public function createFromOrder(Order $order)
    {
        $invoice = new Invoice();
        $invoice->setOrder($order);
        $invoice->setInvoiceDate(new \DateTime());
        $invoice->setTotal($order->getTotal());

        return $invoice;
    }
}
