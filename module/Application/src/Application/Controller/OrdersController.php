<?php

namespace Application\Controller;

use CleanPhp\Invoicer\Domain\Repository\OrderRepositoryInterface;
use Zend\Mvc\Controller\AbstractActionController;

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
     * @param OrderRepositoryInterface $orders
     */
    public function __construct(OrderRepositoryInterface $orders)
    {
        $this->orderRepository = $orders;
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
}
