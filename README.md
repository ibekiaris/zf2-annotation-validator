Description
------------

Annotation validator is a ZF2 module used to validate Doctrine Entities
during their lifecycle call backs (events).

By using Annotation Validator in your projects you can enhance productivity.
At the same time, Junior developers who are involved in your project 
don't have to be concerned about validation since it takes place in entities.  
You can also be sure that your persistence layer is more protected 
against code vulnerabilities.

At the moment data is validated just before flush, against the idea of using an ORM
where entities must be valid after their "construction". 

However this module solved a lot of real life problems for me and I think that 
this is what matters when sharing code.

Installation
------------

1) With composer:
 
```
composer require ibekiaris/zf2-annotation-validator
```

2) Directly in you ZF2 project:

Just copy module files into "module" directory


In any case, after including code, add the following lines in application.config.php

```
'modules' => array(
        'Application',
        'AnnotationValidator'
    ),

```

Finally add "module.config.sample.php" lines into your global or local project configuration file.
You have to change of course 'validation_classes_aliases' according your needs.


Documentation
-------------

Use AnnotationValidator\DoctrineValidatorTrait into you entities.

```
use AnnotationValidator\DoctrineValidatorTrait

/**
 * This is a simple Entity Class
 *
 *
 * @ORM\Entity
 * @ORM\Table(name="clients")
 * @ORM\HasLifecycleCallbacks
 *
 * @author     Ioannis Bekiaris <bekiarisgiannis85@gmail.com>
 * @copyright  2015 - 2016 Ioannis Bekiaris
 */
class Client
{
    use DoctrineValidatorTrait;
    
    /**
     * @ORM\Column(name="title", type="string")
     *
     * @VLD {"type":"RequiredString"}
     * @var string
     */
    private $name;
    
}

```

Use @VLD annotation to validate $name property. 


e.g module.config.php

```
return [
    'validation_classes_aliases' => [
        'RequiredString' => [
            'validation_class' => '\Zend\Validator\Regex',
            'validation_options' => [
                'pattern' => '/^[\p{L}0-9\s\.\-]+$/u',
            ],
        ],
        'HostName' => [
            'validation_class' => '\Zend\Validator\Hostname',
            'validation_options' => [
                'allow' => \Zend\Validator\Hostname::ALLOW_ALL,
            ],
        ],
        'LonLat' => [
            'validation_class' => '\Zend\Validator\Regex',
            'validation_options' => [
                'pattern' => '/^[A-Z0-9\s\.]{0,10}$/',
             ],
        ],
    ],
    
```

NOTICES
-------------

Use "NotRequired" as suffix or prefix in validation types(aliases) to accept null as values:

e.g

```
/**
 * @ORM\Column(name="facebook_account_url", type="string", nullable=true)
 *
 * @VLD {"type":"UriNotRequired"}
 * @var string
 */
protected $facebookAccountUrl;

```

### LICENSE

The files in this archive are released under license.
You can find a copy of this license in [LICENSE.txt](LICENSE.txt).
