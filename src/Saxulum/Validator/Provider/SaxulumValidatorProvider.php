<?php

namespace Saxulum\Validator\Provider;

use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Validator\Mapping\Factory\LazyLoadingMetadataFactory;
use Symfony\Component\Validator\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Validator\Mapping\Loader\LoaderChain;
use Symfony\Component\Validator\Mapping\Loader\StaticMethodLoader;
use Symfony\Component\Validator\Mapping\Loader\XmlFilesLoader;
use Symfony\Component\Validator\Mapping\Loader\YamlFilesLoader;

class SaxulumValidatorProvider
{
    public function register(\Pimple $container)
    {
        $container['validator.loader.xml.files'] = $container->share(function () {
            return array();
        });

        $container['validator.loader.yaml.files'] = $container->share(function () {
            return array();
        });

        $container['validator.loader.annotation'] = $container->share(function () {
            return new AnnotationLoader(new AnnotationReader());
        });

        $container['validator.loader.staticmethod'] = $container->share(function () {
            return new StaticMethodLoader();
        });

        $container['validator.loader.xml'] = $container->share(function () use ($container) {
            $files = $container['validator.loader.xml.files'];
            if ($files) {
                return new XmlFilesLoader($files);
            }

            return null;
        });

        $container['validator.loader.yaml'] = $container->share(function () use ($container) {
            $files = $container['validator.loader.yaml.files'];
            if ($files) {
                return new YamlFilesLoader($files);
            }

            return null;
        });

        $container['validator.loaders'] = $container->share(function () use ($container) {
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
        });

        $container['validator.mapping.class_metadata_factory'] = $container->share(function () use ($container) {
            $loaders = $container['validator.loaders'];

            return new LazyLoadingMetadataFactory(
                new LoaderChain($loaders)
            );
        });
    }
}
