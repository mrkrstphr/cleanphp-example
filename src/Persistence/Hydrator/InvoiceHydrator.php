<?php

namespace CleanPhp\Invoicer\Persistence\Hydrator;

use CleanPhp\Invoicer\Persistence\Hydrator\Strategy\DateStrategy;
use CleanPhp\Invoicer\Domain\Entity\Order;
use CleanPhp\Invoicer\Domain\Repository\OrderRepositoryInterface;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Stdlib\Hydrator\HydratorInterface;

/**
 * Class InvoiceHydrator
 * @package CleanPhp\Invoicer\Persistence\Hydrator
 */
class InvoiceHydrator implements HydratorInterface
{
    /**
     * @var ClassMethods
     */
    protected $wrappedHydrator;

    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;

    /**
     * @param HydratorInterface $wrappedHydrator
     * @param OrderRepositoryInterface $orderRepository
     */
    public function __construct(HydratorInterface $wrappedHydrator, OrderRepositoryInterface $orderRepository)
    {
        $this->wrappedHydrator = $wrappedHydrator;
        $this->wrappedHydrator->addStrategy(
            'invoice_date',
            new DateStrategy()
        );
        $this->orderRepository = $orderRepository;
    }

    /**
     * @param object $object
     * @return array
     */
    public function extract($object)
    {
        $data = $this->wrappedHydrator->extract($object);

        if (array_key_exists('order', $data) &&
            !empty($data['order'])) {

            $data['order_id'] = $data['order']->getId();
            unset($data['order']);
        }

        return $data;
    }

    /**
     * @param array $data
     * @param object $invoice
     * @return object
     */
    public function hydrate(array $data, $invoice)
    {
        $order = null;

        if (isset($data['order'])) {
            $order = $this->wrappedHydrator->hydrate(
                $data['order'],
                new Order()
            );
            unset($data['order']);
        }

        if (isset($data['order_id'])) {
            $order = $this->orderRepository->getById($data['order_id']);
        }

        $invoice = $this->wrappedHydrator->hydrate($data, $invoice);

        if ($order) {
            $invoice->setOrder($order);
        }

        return $invoice;
    }
}
