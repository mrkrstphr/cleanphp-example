<?php

namespace Application\Controller;

use CleanPhp\Invoicer\Domain\Repository\CustomerRepositoryInterface;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * Class CustomersController
 * @package Application\Controller
 */
class CustomersController extends AbstractActionController
{
    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * @param CustomerRepositoryInterface $customers
     */
    public function __construct(CustomerRepositoryInterface $customers)
    {
        $this->customerRepository = $customers;
    }

    /**
     * @return array
     */
    public function indexAction()
    {
        return [
            'customers' => $this->customerRepository->getAll()
        ];
    }
}
