<?php

namespace App\Http\Controllers;

use CleanPhp\Invoicer\Domain\Repository\CustomerRepositoryInterface;
use CleanPhp\Invoicer\Domain\Repository\OrderRepositoryInterface;
use CleanPhp\Invoicer\Persistence\Hydrator\OrderHydrator;
use CleanPhp\Invoicer\Service\InputFilter\OrderInputFilter;
use Illuminate\Http\Response;

/**
 * Class OrdersController
 * @package Application\Controller
 */
class OrdersController extends Controller
{
    /**
     * @var OrderRepositoryInterface
     */
    protected $orderRepository;

    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * @var OrderInputFilter
     */
    protected $inputFilter;

    /**
     * @var OrderHydrator
     */
    protected $hydrator;

    /**
     * @var \Symfony\Component\HttpFoundation\Session\Session
     */
    protected $session;

    /**
     * @param OrderRepositoryInterface $orderRepository
     * @param CustomerRepositoryInterface $customerRepository
     * @param OrderInputFilter $inputFilter
     * @param OrderHydrator $hydrator
     */
    public function __construct(
        OrderRepositoryInterface $orderRepository,
        CustomerRepositoryInterface $customerRepository,
        OrderInputFilter $inputFilter,
        OrderHydrator $hydrator
    ) {
        $this->orderRepository = $orderRepository;
        $this->customerRepository = $customerRepository;
        $this->inputFilter = $inputFilter;
        $this->hydrator = $hydrator;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function indexAction()
    {
        $orders = $this->orderRepository->getAll();

        return view('orders/index', ['orders' => $orders]);
    }

    /**
     * @param int $id
     * @return Response|\Illuminate\View\View
     */
    public function viewAction($id)
    {
        $order = $this->orderRepository->getById($id);

        if (!$order) {
            return new Response('', 404);
        }

        return view('orders/view', ['order' => $order]);
    }
}
