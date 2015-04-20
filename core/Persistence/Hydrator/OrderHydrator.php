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
        $data = $this->wrappedHydrator->extract($object);

        if (array_key_exists('customer', $data) &&
            !empty($data['customer'])) {

            $data['customer_id'] = $data['customer']->getId();
            unset($data['customer']);
        }

        return $data;
    }

    /**
     * @param array $data
     * @param Order $order
     * @return Order
     */
    public function hydrate(array $data, $order) {
        if (isset($data['customer']) && isset($data['customer']['id'])) {
            if (empty($data['customer']['id'])) {
                unset($data['customer']);
            } else {
                $data['customer'] = $this->customerRepository->getById(
                    $data['customer']['id']
                );
            }
        }

        return $this->wrappedHydrator->hydrate(
            $data,
            $order
        );
    }
}
