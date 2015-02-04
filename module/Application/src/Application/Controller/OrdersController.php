<?php

namespace Application\Controller;

use CleanPhp\Invoicer\Domain\Entity\Order;
use CleanPhp\Invoicer\Domain\Repository\CustomerRepositoryInterface;
use CleanPhp\Invoicer\Domain\Repository\OrderRepositoryInterface;
use CleanPhp\Invoicer\Service\InputFilter\OrderInputFilter;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\View\Model\ViewModel;

/**
 * Class OrdersController
 * @package Application\Controller
 */
class OrdersController extends AbstractActionController
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
     * @var HydratorInterface
     */
    protected $hydrator;

    /**
     * @param OrderRepositoryInterface $orderRepository
     * @param CustomerRepositoryInterface $customerRepository
     * @param OrderInputFilter $inputFilter
     * @param HydratorInterface $hydrator
     */
    public function __construct(
        OrderRepositoryInterface $orderRepository,
        CustomerRepositoryInterface $customerRepository,
        OrderInputFilter $inputFilter,
        HydratorInterface $hydrator
    ) {
        $this->orderRepository = $orderRepository;
        $this->customerRepository = $customerRepository;
        $this->inputFilter = $inputFilter;
        $this->hydrator = $hydrator;
    }

    /**
     * @return array
     */
    public function indexAction()
    {
        return [
            'orders' => $this->orderRepository->getAll()
        ];
    }

    /**
     * @return array
     */
    public function viewAction()
    {
        $id = $this->params()->fromRoute('id');
        $order = $this->orderRepository->getById($id);

        if (!$order) {
            $this->getResponse()->setStatusCode(404);
            return null;
        }

        return [
            'order' => $order
        ];
    }

    /**
     * @return ViewModel
     */
    public function newAction()
    {
        $viewModel = new ViewModel();
        $order = new Order();

        if ($this->getRequest()->isPost()) {
            $this->inputFilter
                ->setData($this->params()->fromPost());

            if ($this->inputFilter->isValid()) {
                $order = $this->hydrator->hydrate(
                    $this->inputFilter->getValues(),
                    $order
                );

                $this->orderRepository
                    ->begin()
                    ->persist($order)
                    ->commit();

                $this->flashMessenger()->addSuccessMessage('Order Created');
                $this->redirect()->toUrl('/orders/view/' . $order->getId());
            } else {
                $this->hydrator->hydrate(
                    $this->params()->fromPost(),
                    $order
                );
                $viewModel->setVariable(
                    'errors',
                    $this->inputFilter->getMessages()
                );
            }
        }

        $viewModel->setVariable(
            'customers',
            $this->customerRepository->getAll()
        );
        $viewModel->setVariable('order', $order);

        return $viewModel;
    }
}
