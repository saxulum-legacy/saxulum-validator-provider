<?php

namespace Saxulum\Tests\Validator\Provider;

use Pimple\Container;
use Saxulum\Tests\Validator\Fixtures\AnnotationObject;
use Saxulum\Tests\Validator\Fixtures\DefaultObject;
use Saxulum\Tests\Validator\Fixtures\StaticMethodObject;
use Saxulum\Validator\Provider\SaxulumValidatorProvider;
use Silex\Provider\ValidatorServiceProvider;
use Symfony\Component\Validator\Validator;

class SaxulumValidatorProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testAnnotation()
    {
        $container = $this->getContainer();

        /** @var Validator $validator */
        $validator = $container['validator'];

        $annotationObject = new AnnotationObject();
        $annotationObject->setValue(1);

        $violations = $validator->validate($annotationObject);
        $this->assertCount(0, $violations);

        $annotationObject = new AnnotationObject();
        $annotationObject->setValue(-1);

        $violations = $validator->validate($annotationObject);
        $this->assertCount(1, $violations);
        $this->assertEquals('min', $violations[0]->getMessage());

        $annotationObject = new AnnotationObject();
        $annotationObject->setValue(12);

        $violations = $validator->validate($annotationObject);
        $this->assertCount(1, $violations);
        $this->assertEquals('max', $violations[0]->getMessage());
    }

    public function testStaticMethod()
    {
        $container = $this->getContainer();

        /** @var Validator $validator */
        $validator = $container['validator'];

        $staticMethodObject = new StaticMethodObject();
        $staticMethodObject->setValue(1);

        $violations = $validator->validate($staticMethodObject);
        $this->assertCount(0, $violations);

        $staticMethodObject = new AnnotationObject();
        $staticMethodObject->setValue(-1);

        $violations = $validator->validate($staticMethodObject);
        $this->assertCount(1, $violations);
        $this->assertEquals('min', $violations[0]->getMessage());

        $staticMethodObject = new AnnotationObject();
        $staticMethodObject->setValue(12);

        $violations = $validator->validate($staticMethodObject);
        $this->assertCount(1, $violations);
        $this->assertEquals('max', $violations[0]->getMessage());
    }

    public function testXml()
    {
        $container = $this->getContainer();

        $container['validator.loader.xml.files'] = $container->extend('validator.loader.xml.files', function ($files) {
            $files[] = __DIR__ . '/../Fixtures/test.xml';

            return $files;
        });

        /** @var Validator $validator */
        $validator = $container['validator'];

        $staticMethodObject = new DefaultObject();
        $staticMethodObject->setValue(1);

        $violations = $validator->validate($staticMethodObject);
        $this->assertCount(0, $violations);

        $staticMethodObject = new AnnotationObject();
        $staticMethodObject->setValue(-1);

        $violations = $validator->validate($staticMethodObject);
        $this->assertCount(1, $violations);
        $this->assertEquals('min', $violations[0]->getMessage());

        $staticMethodObject = new AnnotationObject();
        $staticMethodObject->setValue(12);

        $violations = $validator->validate($staticMethodObject);
        $this->assertCount(1, $violations);
        $this->assertEquals('max', $violations[0]->getMessage());
    }

    public function testYaml()
    {
        $container = $this->getContainer();

        $container['validator.loader.yaml.files'] = $container->extend('validator.loader.yaml.files', function ($files) {
            $files[] = __DIR__ . '/../Fixtures/test.yml';

            return $files;
        });

        /** @var Validator $validator */
        $validator = $container['validator'];

        $staticMethodObject = new DefaultObject();
        $staticMethodObject->setValue(1);

        $violations = $validator->validate($staticMethodObject);
        $this->assertCount(0, $violations);

        $staticMethodObject = new AnnotationObject();
        $staticMethodObject->setValue(-1);

        $violations = $validator->validate($staticMethodObject);
        $this->assertCount(1, $violations);
        $this->assertEquals('min', $violations[0]->getMessage());

        $staticMethodObject = new AnnotationObject();
        $staticMethodObject->setValue(12);

        $violations = $validator->validate($staticMethodObject);
        $this->assertCount(1, $violations);
        $this->assertEquals('max', $violations[0]->getMessage());
    }

    protected function getContainer()
    {
        $container = new Container();
        $container['debug'] = true;

        $container->register(new ValidatorServiceProvider());
        $container->register(new SaxulumValidatorProvider());

        return $container;
    }
}
