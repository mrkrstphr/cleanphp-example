<?php

namespace App\Http\Controllers;

use CleanPhp\Invoicer\Domain\Repository\InvoiceRepositoryInterface;
use CleanPhp\Invoicer\Domain\Repository\OrderRepositoryInterface;
use CleanPhp\Invoicer\Domain\Service\InvoicingService;
use Illuminate\Http\Response;

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

    /**
     * @param $id
     * @return Response|\Illuminate\View\View
     */
    public function viewAction($id)
    {
        $invoice = $this->invoiceRepository->getById($id);

        if (!$invoice) {
            return new Response('', 404);
        }

        return view('invoices/view', [
            'invoice' => $invoice,
            'order' => $invoice->getOrder()
        ]);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function newAction()
    {
        return view('invoices/new', [
            'orders' => $this->orderRepository->getUninvoicedOrders()
        ]);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function generateAction()
    {
        $invoices = $this->invoicing->generateInvoices();

        $this->invoiceRepository->begin();

        foreach ($invoices as $invoice) {
            $this->invoiceRepository->persist($invoice);
        }

        $this->invoiceRepository->commit();

        return view('invoices/generate', ['invoices' => $invoices]);
    }
}
