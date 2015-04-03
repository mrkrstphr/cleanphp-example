<?php

use CleanPhp\Invoicer\Domain\Entity\Customer;
use CleanPhp\Invoicer\Domain\Entity\Order;
use CleanPhp\Invoicer\Persistence\Hydrator\OrderHydrator;
use Zend\Stdlib\Hydrator\ClassMethods;

describe('Persistence\Hydrator\OrderHydrator', function () {
    beforeEach(function() {
        $this->repository = $this->getProphet()->prophesize(
            'CleanPhp\Invoicer\Domain\Repository\CustomerRepositoryInterface'
        );
        $this->hydrator = new OrderHydrator(
            new ClassMethods(),
            $this->repository->reveal()
        );
    });

    describe('->hydrate()', function () {
        it('should perform basic hydration of attributes', function () {
            $data = [
                'id' => 100,
                'order_number' => '20150101-019',
                'description' => 'simple order',
                'total' => 5000
            ];

            $order = new Order();
            $this->hydrator->hydrate($data, $order);

            expect($order->getId())->to->equal(100);
            expect($order->getOrderNumber())->to->equal('20150101-019');
            expect($order->getDescription())->to->equal('simple order');
            expect($order->getTotal())->to->equal(5000);
        });

        it('should hydrate the embedded customer data', function () {
            $data = ['customer' => ['id' => 20]];
            $order = new Order();

            $this->repository->getById(20)->willReturn((new Customer())->setId(20));
            $this->hydrator->hydrate($data, $order);

            assert(
                $data['customer']['id'] === $order->getCustomer()->getId(),
                'id does not match'
            );
        });

        it('should unset a null "customer"', function () {
            $data = ['customer' => null];
            $order = new Order();

            $this->hydrator->hydrate($data, $order);
            expect($order->getCustomer())->to->be->null();
        });
    });

    describe('->extract()', function () {
        it('should extract the customer object', function () {
            $order = new Order();
            $order->setCustomer((new Customer())->setId(14));

            $data = $this->hydrator->extract($order);

            assert(
                $order->getCustomer()->getId() === $data['customer_id'],
                'customer_id is not correct'
            );
        });
    });
});
