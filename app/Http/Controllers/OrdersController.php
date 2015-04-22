<?php

namespace App\Http\Controllers;

use CleanPhp\Invoicer\Domain\Entity\Order;
use CleanPhp\Invoicer\Domain\Repository\CustomerRepositoryInterface;
use CleanPhp\Invoicer\Domain\Repository\OrderRepositoryInterface;
use CleanPhp\Invoicer\Persistence\Hydrator\OrderHydrator;
use CleanPhp\Invoicer\Service\InputFilter\OrderInputFilter;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;

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

    /**
     * @param Request $request
     * @return \Illuminate\View\View|RedirectResponse
     */
    public function newAction(Request $request)
    {
        $viewModel = [];
        $order = new Order();

        if ($request->getMethod() == 'POST') {
            $this->inputFilter
                ->setData($request->request->all());

            if ($this->inputFilter->isValid()) {
                $order = $this->hydrator->hydrate(
                    $this->inputFilter->getValues(),
                    $order
                );

                $this->orderRepository
                    ->begin()
                    ->persist($order)
                    ->commit();

                Session::flash('success', 'Order Saved');
                return new RedirectResponse('/orders/view/' . $order->getId());
            } else {
                $this->hydrator->hydrate(
                    $request->request->all(),
                    $order
                );
                $viewModel['error'] = $this->inputFilter->getMessages();
            }
        }

        $viewModel['customers'] = $this->customerRepository->getAll();
        $viewModel['order'] = $order;

        return view('orders/new', $viewModel);
    }
}
