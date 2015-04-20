<?php

namespace CleanPhp\Invoicer\Domain\Entity;

/**
 * Class AbstractEntity
 * @package CleanPhp\Invoicer\Domain\Entity
 */
abstract class AbstractEntity
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
}
