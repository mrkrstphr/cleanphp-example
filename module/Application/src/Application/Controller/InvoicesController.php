<?php

namespace Application\Controller;

use CleanPhp\Invoicer\Domain\Repository\InvoiceRepositoryInterface;
use CleanPhp\Invoicer\Domain\Repository\OrderRepositoryInterface;
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
     * @param InvoiceRepositoryInterface $invoices
     * @param OrderRepositoryInterface $orders
     */
    public function __construct(InvoiceRepositoryInterface $invoices, OrderRepositoryInterface $orders)
    {
        $this->invoiceRepository = $invoices;
        $this->orderRepository = $orders;
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
}
