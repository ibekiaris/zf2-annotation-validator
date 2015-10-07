<?php

return [
    'validator_annotation' => 'VLD',
    'service_manager' => [
        'factories' => [
            'ValidatorCacheAdapter' => 'AnnotationValidator\Factory\AnnotationsValidatorCacheAdapterFactory',
        ],
    ],
];