<?php

return [
    'service_manager' => [
        'factories' => [
            'ValidatorCacheAdapter' => 'AnnotationValidator\Factory\AnnotationsValidatorCacheAdapterFactory',
        ],
    ],
];