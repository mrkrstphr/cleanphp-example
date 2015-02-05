<?php

namespace CleanPhp\Invoicer\Persistence\Hydrator;

use CleanPhp\Invoicer\Persistence\Hydrator\Strategy\DateStrategy;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Stdlib\Hydrator\HydratorInterface;

/**
 * Class InvoiceHydrator
 * @package CleanPhp\Invoicer\Persistence\Hydrator
 */
class InvoiceHydrator implements HydratorInterface
{
    /**
     * @var ClassMethods
     */
    protected $wrappedHydrator;

    /**
     * @param ClassMethods $wrappedHydrator
     */
    public function __construct(ClassMethods $wrappedHydrator)
    {
        $this->wrappedHydrator = $wrappedHydrator;
        $this->wrappedHydrator->addStrategy(
            'invoice_date',
            new DateStrategy()
        );
    }

    /**
     * @param object $object
     * @return array
     */
    public function extract($object)
    {
        return $this->wrappedHydrator->extract($object);
    }

    /**
     * @param array $data
     * @param object $object
     * @return object
     */
    public function hydrate(array $data, $object)
    {
        return $this->wrappedHydrator->hydrate($data, $object);
    }
}
