Description
------------

Annotation validator is a ZF2 package used to validate Doctrine Entities
during their lifecycle call backs (events).

By using Annotation Validator into your projects you can reduce production time.
At the same time, Junior developers that are involved into you project 
don't have to care about validation (validation happens in one and only place) 
and so you can be sure that your persistence layer is more protected 
against code vulnerabilities.

At the moment data validated just before flush. This is against the idea of using an ORM (such as Doctrine)
where entities must be valid after construction. However this package solved a lot of real life problems
for me and I think this is what matters when sharing code.

Installation
------------

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

As we see in the previous example I am using @VLD annotation for validate $name property. 

Feel free to select the validation annotation in module configuration. 
Validation Type is also declared into module's configuration

e.g module.config.php

```
return [
    'validator_annotation' => 'VLD',
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