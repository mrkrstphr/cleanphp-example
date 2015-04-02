<?php

namespace CleanPhp\Invoicer\Persistence\Doctrine\Repository;

use CleanPhp\Invoicer\Domain\Repository\CustomerRepositoryInterface;

/**
 * Class CustomerRepository
 * @package CleanPhp\Invoicer\Persistence\Doctrine\Repository
 */
class CustomerRepository extends AbstractDoctrineRepository implements CustomerRepositoryInterface
{
    /**
     * @var string
     */
    protected $entityClass = 'CleanPhp\Invoicer\Domain\Entity\Customer';
}
