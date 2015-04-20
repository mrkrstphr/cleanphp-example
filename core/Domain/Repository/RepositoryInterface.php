<?php

namespace CleanPhp\Invoicer\Domain\Repository;

use CleanPhp\Invoicer\Domain\Entity\AbstractEntity;

/**
 * Interface RepositoryInterface
 * @package CleanPhp\Invoicer\Domain\Repository
 */
interface RepositoryInterface
{
    /**
     * @param int $id
     * @return mixed
     */
    public function getById($id);

    /**
     * @return array
     */
    public function getAll();

    /**
     * @param AbstractEntity $entity
     * @return $this
     */
    public function persist(AbstractEntity $entity);

    /**
     * @return $this
     */
    public function begin();

    /**
     * @return $this
     */
    public function commit();
}
