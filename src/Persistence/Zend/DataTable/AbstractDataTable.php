<?php

namespace CleanPhp\Invoicer\Persistence\Zend\DataTable;

use CleanPhp\Invoicer\Domain\Entity\AbstractEntity;
use CleanPhp\Invoicer\Domain\Repository\RepositoryInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Stdlib\Hydrator\HydratorInterface;

/**
 * Class AbstractDataTable
 * @package CleanPhp\Invoicer\Persistence\Zend\DataTable
 */
abstract class AbstractDataTable implements RepositoryInterface
{
    /**
     * @var TableGateway
     */
    protected $gateway;

    /**
     * @var HydratorInterface
     */
    protected $hydrator;

    /**
     * @param TableGateway $gateway
     * @param HydratorInterface $hydrator
     */
    public function __construct(TableGateway $gateway, HydratorInterface $hydrator)
    {
        $this->gateway = $gateway;
        $this->hydrator = $hydrator;
    }

    /**
     * @param int $id
     * @return array|\ArrayObject|bool|null
     */
    public function getById($id)
    {
        $result = $this->gateway
            ->select(['id' => intval($id)])
            ->current();

        return $result ? $result : false;
    }

    /**
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function getAll()
    {
        $resultSet = $this->gateway->select();
        return $resultSet;
    }

    /**
     * @param AbstractEntity $entity
     * @return $this
     */
    public function persist(AbstractEntity $entity)
    {
        $data = $this->hydrator->extract($entity);

        if ($this->hasIdentity($entity)) {
            $this->gateway->update($data, ['id' => $entity->getId()]);
        } else {
            $this->gateway->insert($data);
            $entity->setId($this->gateway->getLastInsertValue());
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function begin()
    {
        $this->gateway->getAdapter()->getDriver()->getConnection()->beginTransaction();
        return $this;
    }

    /**
     * @return $this
     */
    public function commit()
    {
        $this->gateway->getAdapter()->getDriver()->getConnection()->commit();
        return $this;
    }

    /**
     * @param AbstractEntity $entity
     * @return bool
     */
    protected function hasIdentity(AbstractEntity $entity)
    {
        return !empty($entity->getId());
    }
}
