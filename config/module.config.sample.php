<?php

return [
    'validator_annotation' => 'VLD',
    'validation_cache_enabled' => false,
    // Validation Aliases
    'validation_classes_aliases' => [
        'RequiredString' => [
            'validation_class' => '\Zend\Validator\Regex',
            'validation_options' => [
                'pattern' => '/^[\p{L}0-9\s\.\-]+$/u',
            ],
        ],
    ],
    // Cache Options
    'validation_cache_adapter' => [
        'adapter' => [
            'name' => 'filesystem',
            'options' => [
                'cache_dir' => dirname(dirname(dirname(__DIR__))) . '/data/cache',
                'namespace' => 'annotation_validator',
                'dirPermission' => 0775,
                'filePermission' => 0664,
            ],
        ],
        'plugins' => [
            'exception_handler' => ['throw_exceptions' => true],
            'Serializer',
        ],
    ],
    'service_manager' => [
        'factories' => [
            'ValidatorCacheAdapter' => 'AnnotationValidator\Factory\AnnotationsValidatorCacheAdapterFactory',
        ],
    ],
];