<?php

namespace Application\Model\Entity;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\Document */
class Employee extends BaseEmployee
{
    /** @ODM\ReferenceOne(targetDocument="Manager") */
    private $manager;

    public function getManager()
    {
        return $this->manager;
    }

    public function setManager(Manager $manager)
    {
        $this->manager = $manager;
    }
}
