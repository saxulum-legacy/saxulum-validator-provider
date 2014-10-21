# saxulum-validator-provider

**works with plain silex-php**

[![Build Status](https://api.travis-ci.org/saxulum/saxulum-validator-provider.png?branch=master)](https://travis-ci.org/saxulum/saxulum-validator-provider)
[![Total Downloads](https://poser.pugx.org/saxulum/saxulum-validator-provider/downloads.png)](https://packagist.org/packages/saxulum/saxulum-validator-provider)
[![Latest Stable Version](https://poser.pugx.org/saxulum/saxulum-validator-provider/v/stable.png)](https://packagist.org/packages/saxulum/saxulum-validator-provider)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/saxulum/saxulum-validator-provider/badges/quality-score.png?s=4529e17d24e0d36aa71782cf39b37e56dd423a8b)](https://scrutinizer-ci.com/g/saxulum/saxulum-validator-provider/)

## Features

* Register validators

## Requirements

* php >=5.3
* symfony/validator >=2.3

#### Annotation

* doctrine/annotations ~1.0

#### Yaml

* symfony/yaml >=2.3


## Installation

Through [Composer](http://getcomposer.org) as [saxulum/saxulum-validator-provider][1].

``` {.php}
use Silex\Provider\ValidatorServiceProvider;
use Saxulum\Validator\Silex\Provider\ValidatorProvider;

$app->register(new ValidatorServiceProvider());
$app->register(new ValidatorProvider());
```

#### Annotation

``` {.php}
\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader(array($loader, 'loadClass'));
```

#### XML

Register xml files.

``` {.php}
$app['validator.loader.xml.files'] = $app->share(
    $app->extend('validator.loader.xml.files', function ($files) {
        $files[] = __DIR__ . '/../../Fixtures/test.xml';
        return $files;
    })
);
```

#### YAML

Register yml files.

``` {.php}
$app['validator.loader.yaml.files'] = $app->share(
    $app->extend('validator.loader.yaml.files', function ($files) {
        $files[] = __DIR__ . '/../../Fixtures/test.yaml';
        return $files;
    })
);
```

### Usage

``` {.php}
$app['validator']->validate($object);
```

[1]: https://packagist.org/packages/saxulum/saxulum-validator-provider