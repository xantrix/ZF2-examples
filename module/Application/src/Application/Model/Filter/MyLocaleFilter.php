<?php
namespace Application\Model\Filter;

use Doctrine\ODM\MongoDB\Mapping\ClassMetaData;
use Doctrine\ODM\MongoDB\Query\Filter\BsonFilter;

class MyLocaleFilter extends BsonFilter
{
    public function addFilterCriteria(ClassMetadata $targetDocument)
    {
        // Check if the entity implements the LocalAware interface
        if ( ! $targetDocument->reflClass->implementsInterface('LocaleAware')) {
            return array();
        }

        return array('locale' => $this->getParameter('locale'));
    }
}