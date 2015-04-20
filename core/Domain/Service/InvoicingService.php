<?php

namespace CleanPhp\Invoicer\Domain\Service;

use CleanPhp\Invoicer\Domain\Factory\InvoiceFactory;
use CleanPhp\Invoicer\Domain\Repository\OrderRepositoryInterface;

/**
 * Class InvoicingService
 * @package CleanPhp\Invoicer\Domain\Service
 */
class InvoicingService
{
    /**
     * @var OrderRepositoryInterface
     */
    protected $orderRepository;

    /**
     * @var InvoiceFactory
     */
    protected $invoiceFactory;

    /**
     * @param OrderRepositoryInterface $orderRepository
     * @param InvoiceFactory $invoiceFactory
     */
    public function __construct(
        OrderRepositoryInterface $orderRepository,
        InvoiceFactory $invoiceFactory
    ) {
        $this->orderRepository = $orderRepository;
        $this->invoiceFactory = $invoiceFactory;
    }

    /**
     * @return array
     */
    public function generateInvoices()
    {
        $orders = $this->orderRepository->getUninvoicedOrders();

        $invoices = [];

        foreach ($orders as $order) {
            $invoices[] = $this->invoiceFactory->createFromOrder($order);
        }

        return $invoices;
    }
}
