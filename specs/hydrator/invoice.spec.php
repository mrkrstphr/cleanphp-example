<?php

use CleanPhp\Invoicer\Domain\Entity\Invoice;
use CleanPhp\Invoicer\Persistence\Hydrator\InvoiceHydrator;
use Zend\Stdlib\Hydrator\ClassMethods;

describe('Hydrator\InvoiceHydrator', function () {
    beforeEach(function () {
        $this->hydrator = new InvoiceHydrator(new ClassMethods());
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
    });
});
