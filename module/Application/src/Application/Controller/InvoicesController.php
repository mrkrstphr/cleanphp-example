<?php

namespace Application\Controller;

use CleanPhp\Invoicer\Domain\Repository\InvoiceRepositoryInterface;
use CleanPhp\Invoicer\Domain\Repository\OrderRepositoryInterface;
use CleanPhp\Invoicer\Domain\Service\InvoicingService;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * Class InvoicesController
 * @package Application\Controller
 */
class InvoicesController extends AbstractActionController
{
    /**
     * @var InvoiceRepositoryInterface
     */
    protected $invoiceRepository;

    /**
     * @var OrderRepositoryInterface
     */
    protected $orderRepository;

    /**
     * @var InvoicingService
     */
    protected $invoicing;

    /**
     * @param InvoiceRepositoryInterface $invoices
     * @param OrderRepositoryInterface $orders
     * @param InvoicingService $invoicing
     */
    public function __construct(
        InvoiceRepositoryInterface $invoices,
        OrderRepositoryInterface $orders,
        InvoicingService $invoicing
    ) {
        $this->invoiceRepository = $invoices;
        $this->orderRepository = $orders;
        $this->invoicing = $invoicing;
    }

    /**
     * @return array
     */
    public function indexAction()
    {
        $invoices = $this->invoiceRepository->getAll();

        return [
            'invoices' => $invoices
        ];
    }

    /**
     * @return array
     */
    public function newAction()
    {
        return [
            'orders' => $this->orderRepository->getUninvoicedOrders()
        ];
    }

    /**
     * @return array
     */
    public function generateAction()
    {
        $invoices = $this->invoicing->generateInvoices();

        $this->invoiceRepository->begin();

        foreach ($invoices as $invoice) {
            $this->invoiceRepository->persist($invoice);
        }

        $this->invoiceRepository->commit();

        return [
            'invoices' => $invoices
        ];
    }
}
