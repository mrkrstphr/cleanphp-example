<?php

namespace CleanPhp\Invoicer\Persistence\Doctrine\Repository;

use RuntimeException;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class RepositoryFactory
 * @package CleanPhp\Invoicer\Persistence\Doctrine\Repository
 */
class RepositoryFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $sl
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $sl)
    {
        $class = func_get_arg(2);
        $class = 'CleanPhp\Invoicer\Persistence\Doctrine\Repository\\' . $class;

        if (class_exists($class, true)) {
            return new $class(
                $sl->get('Doctrine\ORM\EntityManager')
            );
        }

        throw new RuntimeException('Unknown Repository requested: ' . $class);
    }
}
