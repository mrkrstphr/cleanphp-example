<?php

namespace App\Http\Controllers;

use CleanPhp\Invoicer\Domain\Entity\Customer;
use CleanPhp\Invoicer\Domain\Repository\CustomerRepositoryInterface;
use CleanPhp\Invoicer\Service\InputFilter\CustomerInputFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Zend\Stdlib\Hydrator\HydratorInterface;

/**
 * Class CustomersController
 * @package App\Http\Controllers
 */
class CustomersController extends Controller
{
    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * @var CustomerInputFilter
     */
    protected $inputFilter;

    /**
     * @var HydratorInterface
     */
    protected $hydrator;

    /**
     * @param CustomerRepositoryInterface $customerRepository
     * @param CustomerInputFilter $inputFilter
     * @param HydratorInterface $hydrator
     */
    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        CustomerInputFilter $inputFilter,
        HydratorInterface $hydrator
    ) {
        $this->customerRepository = $customerRepository;
        $this->inputFilter = $inputFilter;
        $this->hydrator = $hydrator;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function indexAction()
    {
        $customers = $this->customerRepository->getAll();

        return view('customers/index', ['customers' => $customers]);
    }

    /**
     * @param Request $request
     * @param string $id
     * @return RedirectResponse|\Illuminate\View\View
     */
    public function newOrEditAction(Request $request, $id = '')
    {
        $viewModel = [];

        $customer = $id ? $this->customerRepository->getById($id) : new Customer();

        if ($request->getMethod() == 'POST') {
            $this->inputFilter->setData($request->request->all());

            if ($this->inputFilter->isValid()) {
                $this->hydrator->hydrate(
                    $this->inputFilter->getValues(),
                    $customer
                );

                $this->customerRepository
                    ->begin()
                    ->persist($customer)
                    ->commit();

                Session::flash('success', 'Customer Saved');

                return new RedirectResponse('/customers/edit/' . $customer->getId());
            } else {
                $this->hydrator->hydrate(
                    $request->request->all(),
                    $customer
                );
                $viewModel['error'] = $this->inputFilter->getMessages();
            }
        }

        $viewModel['customer'] = $customer;

        return view('customers/new-or-edit', $viewModel);
    }
}
