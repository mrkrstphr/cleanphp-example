<?php

namespace CleanPhp\Invoicer\Persistence\Doctrine\Repository;

use CleanPhp\Invoicer\Domain\Repository\InvoiceRepositoryInterface;

/**
 * Class InvoiceRepository
 * @package CleanPhp\Invoicer\Persistence\Doctrine\Repository
 */
class InvoiceRepository extends AbstractDoctrineRepository implements InvoiceRepositoryInterface
{
    /**
     * @var string
     */
    protected $entityClass = 'CleanPhp\Invoicer\Domain\Entity\Invoice';
}
