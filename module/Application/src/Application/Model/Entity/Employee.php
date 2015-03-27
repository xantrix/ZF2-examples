<?php
namespace Application\Model\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Application\Model\Entity\Manager;
use DateTime;

/** @ODM\Document */
class Employee extends BaseEmployee
{
    /** @ODM\ReferenceOne(targetDocument="Manager") */
    private $manager;

    public function getManager() { return $this->manager; }
    public function setManager(Manager $manager) { $this->manager = $manager; }
}