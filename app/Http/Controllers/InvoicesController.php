<?php

namespace App\Http\Controllers;

use CleanPhp\Invoicer\Domain\Repository\InvoiceRepositoryInterface;
use CleanPhp\Invoicer\Domain\Repository\OrderRepositoryInterface;
use CleanPhp\Invoicer\Domain\Service\InvoicingService;

/**
 * Class InvoicesController
 * @package Application\Controller
 */
class InvoicesController extends Controller
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
     * @return \Illuminate\View\View
     */
    public function indexAction()
    {
        $invoices = $this->invoiceRepository->getAll();

        return view('invoices/index', ['invoices' => $invoices]);
    }
}
