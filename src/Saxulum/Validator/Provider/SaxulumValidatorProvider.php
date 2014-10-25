<?php

namespace Saxulum\Validator\Provider;

use Doctrine\Common\Annotations\AnnotationReader;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\Validator\Mapping\Factory\LazyLoadingMetadataFactory;
use Symfony\Component\Validator\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Validator\Mapping\Loader\LoaderChain;
use Symfony\Component\Validator\Mapping\Loader\StaticMethodLoader;
use Symfony\Component\Validator\Mapping\Loader\XmlFilesLoader;
use Symfony\Component\Validator\Mapping\Loader\YamlFilesLoader;

class SaxulumValidatorProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container['validator.loader.xml.files'] = function () {
            return array();
        };

        $container['validator.loader.yaml.files'] = function () {
            return array();
        };

        $container['validator.loader.annotation'] = function () {
            if (class_exists('Doctrine\Common\Annotations\AnnotationReader')) {
                return new AnnotationLoader(new AnnotationReader());
            }

            return null;
        };

        $container['validator.loader.staticmethod'] = function () {
            return new StaticMethodLoader();
        };

        $container['validator.loader.xml'] = function () use ($container) {
            $files = $container['validator.loader.xml.files'];
            if ($files) {
                return new XmlFilesLoader($files);
            }

            return null;
        };

        $container['validator.loader.yaml'] = function () use ($container) {
            $files = $container['validator.loader.yaml.files'];
            if ($files) {
                return new YamlFilesLoader($files);
            }

            return null;
        };

        $container['validator.loaders'] = function () use ($container) {
            $loaders = array();

            $annotationLoader = $container['validator.loader.annotation'];

            if (null !== $annotationLoader) {
                $loaders[] = $annotationLoader;
            }

            $staticMethodLoader = $container['validator.loader.staticmethod'];

            if (null !== $staticMethodLoader) {
                $loaders[] = $staticMethodLoader;
            }

            $xmlLoader = $container['validator.loader.xml'];

            if (null !== $xmlLoader) {
                $loaders[] = $xmlLoader;
            }

            $yamlLoader = $container['validator.loader.yaml'];

            if (null !== $yamlLoader) {
                $loaders[] = $yamlLoader;
            }

            return $loaders;
        };

        $container['validator.mapping.class_metadata_factory'] = function () use ($container) {
            $loaders = $container['validator.loaders'];

            return new LazyLoadingMetadataFactory(
                new LoaderChain($loaders)
            );
        };
    }
}
