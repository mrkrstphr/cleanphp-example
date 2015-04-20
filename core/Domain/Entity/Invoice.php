<?php

namespace CleanPhp\Invoicer\Domain\Entity;

use DateTime;

/**
 * Class Invoice
 * @package CleanPhp\Invoicer\Domain\Entity
 */
class Invoice extends AbstractEntity
{
    /**
     * @var Order
     */
    protected $order;

    /**
     * @var \DateTime
     */
    protected $invoiceDate;

    /**
     * @var float
     */
    protected $total;

    /**
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param Order $order
     * @return $this
     */
    public function setOrder(Order $order)
    {
        $this->order = $order;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getInvoiceDate()
    {
        return $this->invoiceDate;
    }

    /**
     * @param DateTime $invoiceDate
     * @return $this
     */
    public function setInvoiceDate(DateTime $invoiceDate)
    {
        $this->invoiceDate = $invoiceDate;
        return $this;
    }

    /**
     * @return float
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param float $total
     * @return $this
     */
    public function setTotal($total)
    {
        $this->total = $total;
        return $this;
    }
}
