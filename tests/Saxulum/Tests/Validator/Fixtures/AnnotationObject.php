<?php

namespace Saxulum\Tests\Validator\Fixtures;

use Symfony\Component\Validator\Constraints as Assert;

class AnnotationObject extends DefaultObject
{
    /**
     * @var int
     * @Assert\Range(
     *      min=0,
     *      max=10,
     *      minMessage="min",
     *      maxMessage="max",
     *      invalidMessage="invalid"
     * )
     */
    protected $value;
}
