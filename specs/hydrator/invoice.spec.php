<?php

use CleanPhp\Invoicer\Domain\Entity\Invoice;
use CleanPhp\Invoicer\Persistence\Hydrator\InvoiceHydrator;
use CleanPhp\Invoicer\Domain\Entity\Order;
use Zend\Stdlib\Hydrator\ClassMethods;

describe('Hydrator\InvoiceHydrator', function () {
    beforeEach(function () {
        $this->repository = $this->getProphet()
            ->prophesize('CleanPhp\Invoicer\Domain\Repository\OrderRepositoryInterface');
        $this->hydrator = new InvoiceHydrator(
            new ClassMethods(),
            $this->repository->reveal()
        );
    });

    describe('->extract()', function () {
        it('should perform simple extraction on the object', function () {
            $invoice = new Invoice();
            $invoice->setTotal(300.14);

            $data = $this->hydrator->extract($invoice);

            expect($data['total'])->to->equal($invoice->getTotal());
        });

        it('should extract a DateTime object to a string', function () {
            $invoiceDate = new \DateTime();
            $invoice = new Invoice();
            $invoice->setInvoiceDate($invoiceDate);

            $data = $this->hydrator->extract($invoice);

            expect($data['invoice_date'])->to->equal(
                $invoice->getInvoiceDate()->format('Y-m-d')
            );
        });

        it('should extract the order object', function () {
            $invoice = new Invoice();
            $invoice->setOrder((new Order())->setId(14));

            $data = $this->hydrator->extract($invoice);

            expect($data['order_id'])->to->equal($invoice->getOrder()->getId());
        });
    });

    describe('->hydrate()', function () {
        it('should perform simple hydration on the object', function () {
            $data = ['total' => 300.14];
            $invoice = $this->hydrator->hydrate($data, new Invoice());

            expect($invoice->getTotal())->to->equal($data['total']);
        });

        it('should hydrate a DateTime object', function () {
            $data = ['invoice_date' => '2014-12-13'];
            $invoice = $this->hydrator->hydrate($data, new Invoice());

            expect($invoice->getInvoiceDate()->format('Y-m-d'))->to->equal($data['invoice_date']);
        });

        it('should hydrate an Order entity on the Invoice', function () {
            $data = ['order_id' => 500];

            $order = (new Order())->setId(500);
            $invoice = new Invoice();

            $this->repository->getById(500)
                ->shouldBeCalled()
                ->willReturn($order);

            $this->hydrator->hydrate($data, $invoice);

            expect($invoice->getOrder())->to->equal($order);

            $this->getProphet()->checkPredictions();
        });

        it('should hydrate the embedded order data', function () {
            $data = ['order' => ['id' => 20]];
            $invoice = new Invoice();

            $this->hydrator->hydrate($data, $invoice);

            expect($invoice->getOrder()->getId())->to->equal($data['order']['id']);
        });
    });
});
