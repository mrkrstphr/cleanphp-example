<?php

namespace CleanPhp\Invoicer\Persistence\Hydrator;

use CleanPhp\Invoicer\Domain\Entity\Order;
use CleanPhp\Invoicer\Domain\Repository\CustomerRepositoryInterface;
use Zend\Stdlib\Hydrator\HydratorInterface;

/**
 * Class OrderHydrator
 * @package CleanPhp\Invoicer\Persistence\Hydrator
 */
class OrderHydrator implements HydratorInterface
{
    /**
     * @var HydratorInterface
     */
    protected $wrappedHydrator;

    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * @param HydratorInterface $wrappedHydrator
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(
        HydratorInterface $wrappedHydrator,
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->wrappedHydrator = $wrappedHydrator;
        $this->customerRepository = $customerRepository;
    }

    /**
     * @param object $object
     * @return array
     */
    public function extract($object)
    {
        return $this->wrappedHydrator->extract($object);
    }

    /**
     * @param array $data
     * @param Order $order
     * @return Order
     */
    public function hydrate(array $data, $order) {
        $this->wrappedHydrator->hydrate($data, $order);

        if (isset($data['customer_id'])) {
            $order->setCustomer(
                $this->customerRepository->getById($data['customer_id'])
            );
        }

        return $order;
    }
}
