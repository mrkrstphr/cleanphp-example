<?php

namespace CleanPhp\Invoicer\Persistence\Doctrine\Repository;

use CleanPhp\Invoicer\Domain\Entity\AbstractEntity;
use CleanPhp\Invoicer\Domain\Repository\RepositoryInterface;
use Doctrine\ORM\EntityManager;

/**
 * Class AbstractDoctrineRepository
 * @package CleanPhp\Invoicer\Persistence\Doctrine\Repository
 */
abstract class AbstractDoctrineRepository implements RepositoryInterface
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var string
     */
    protected $entityClass;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        if (empty($this->entityClass)) {
            throw new \RuntimeException(
                get_class($this) . '::$entityClass is not defined'
            );
        }

        $this->entityManager = $em;
    }

    /**
     * @param int $id
     * @return object
     */
    public function getById($id)
    {
        return $this->entityManager->find($this->entityClass, $id);
    }

    /**
     * @return array
     */
    public function getAll()
    {
        return $this->entityManager->getRepository($this->entityClass)
            ->findAll();
    }

    /**
     * @param array $conditions
     * @param array $order
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getBy(
        $conditions = [],
        $order = [],
        $limit = null,
        $offset = null
    ) {
        $repository = $this->entityManager->getRepository(
            $this->entityClass
        );

        $results = $repository->findBy(
            $conditions,
            $order,
            $limit,
            $offset
        );

        return $results;
    }

    /**
     * @param AbstractEntity $entity
     * @return $this
     */
    public function persist(AbstractEntity $entity)
    {
        $this->entityManager->persist($entity);
        return $this;
    }

    /**
     * @return $this
     */
    public function begin()
    {
        $this->entityManager->beginTransaction();
        return $this;
    }

    /**
     * @return $this
     */
    public function commit()
    {
        $this->entityManager->flush();
        $this->entityManager->commit();
        return $this;
    }
}
