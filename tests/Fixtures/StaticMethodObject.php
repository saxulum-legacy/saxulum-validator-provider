<?php

namespace Saxulum\Tests\Validator\Fixtures;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class StaticMethodObject extends DefaultObject
{
    /**
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('value', new Assert\Range(array(
            'min' => 0,
            'max' => 10,
            'minMessage' => 'min',
            'maxMessage' => 'max',
            'invalidMessage' => 'invalid'
        )));
    }
}
