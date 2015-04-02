<?php

namespace CleanPhp\Invoicer\Persistence\Doctrine\Repository;

use CleanPhp\Invoicer\Domain\Repository\OrderRepositoryInterface;
use Doctrine\ORM\Query\Expr\Join;

/**
 * Class OrderRepository
 * @package CleanPhp\Invoicer\Persistence\Doctrine\Repository
 */
class OrderRepository extends AbstractDoctrineRepository implements OrderRepositoryInterface
{
    /**
     * @var string
     */
    protected $entityClass = 'CleanPhp\Invoicer\Domain\Entity\Order';

    /**
     * @return array
     */
    public function getUninvoicedOrders()
    {
        $builder = $this->entityManager->createQueryBuilder()
            ->select('o')
            ->from($this->entityClass, 'o')
            ->leftJoin(
                'CleanPhp\Invoicer\Domain\Entity\Invoice',
                'i',
                Join::WITH,
                'i.order = o'
            )
            ->where('i.id IS NULL');

        return $builder->getQuery()->getResult();
    }
}
