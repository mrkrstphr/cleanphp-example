<?php

namespace CleanPhp\Invoicer\Persistence\Hydrator\Strategy;

use DateTime;
use Zend\Stdlib\Hydrator\Strategy\DefaultStrategy;

/**
 * Class DateStrategy
 * @package CleanPhp\Invoicer\Persistence\Hydrator\Strategy
 */
class DateStrategy extends DefaultStrategy
{
    /**
     * @param mixed $value
     * @return DateTime|mixed
     */
    public function hydrate($value)
    {
        if (is_string($value)) {
            $value = new DateTime($value);
        }

        return $value;
    }

    /**
     * @param mixed $value
     * @return mixed|string
     */
    public function extract($value)
    {
        if ($value instanceof DateTime) {
            $value = $value->format('Y-m-d');
        }

        return $value;
    }
}
