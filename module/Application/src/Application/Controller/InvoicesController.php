<?php

namespace Application\Controller;

use CleanPhp\Invoicer\Domain\Repository\InvoiceRepositoryInterface;
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
     * @param InvoiceRepositoryInterface $invoices
     */
    public function __construct(InvoiceRepositoryInterface $invoices)
    {
        $this->invoiceRepository = $invoices;
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
}
