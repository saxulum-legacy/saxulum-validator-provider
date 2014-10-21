<?php

namespace Saxulum\Tests\Validator\Silex\Provider;

use Saxulum\Tests\Validator\Fixtures\AnnotationObject;
use Saxulum\Tests\Validator\Fixtures\DefaultObject;
use Saxulum\Tests\Validator\Fixtures\StaticMethodObject;
use Saxulum\Validator\Silex\Provider\SaxulumValidatorProvider;
use Silex\Application;
use Silex\Provider\ValidatorServiceProvider;
use Symfony\Component\Validator\Validator;

class SaxulumValidatorProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testAnnotation()
    {
        $app = $this->getApp();

        /** @var Validator $validator */
        $validator = $app['validator'];

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
        $app = $this->getApp();

        /** @var Validator $validator */
        $validator = $app['validator'];

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
        $app = $this->getApp();

        $app['validator.loader.xml.files'] = $app->share(
            $app->extend('validator.loader.xml.files', function ($files) {
                $files[] = __DIR__ . '/../../Fixtures/test.xml';

                return $files;
            })
        );

        /** @var Validator $validator */
        $validator = $app['validator'];

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
        $app = $this->getApp();

        $app['validator.loader.yaml.files'] = $app->share(
            $app->extend('validator.loader.yaml.files', function ($files) {
                $files[] = __DIR__ . '/../../Fixtures/test.yml';

                return $files;
            })
        );

        /** @var Validator $validator */
        $validator = $app['validator'];

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

    protected function getApp()
    {
        $app = new Application();
        $app['debug'] = true;

        $app->register(new ValidatorServiceProvider());
        $app->register(new SaxulumValidatorProvider());

        return $app;
    }
}
