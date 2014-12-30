<?php

namespace CleanPhp\Invoicer\Persistence\Zend\TableGateway;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Stdlib\Hydrator\HydratorInterface;

/**
 * Class TableGatewayFactory
 * @package CleanPhp\Invoicer\Persistence\Zend\TableGateway
 */
class TableGatewayFactory
{
    /**
     * @param Adapter $dbAdapter
     * @param HydratorInterface $hydrator
     * @param object $object
     * @param string $table
     * @return TableGateway
     */
    public function createGateway(
        Adapter $dbAdapter,
        HydratorInterface $hydrator,
        $object,
        $table
    ) {
        $resultSet = new HydratingResultSet($hydrator, $object);
        return new TableGateway($table, $dbAdapter, null, $resultSet);
    }
}
