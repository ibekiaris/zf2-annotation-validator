<?php
/**
 * Include that in you global or local configuration file
 * Check the cache_dir option to match your cache folder map
 */
return [
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
                'cache_dir' => dirname(dirname(__DIR__)) . '/data/cache',
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
];