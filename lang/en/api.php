<?php

return [

    'responses' => [
        'created' => 'Resource created successfully.',
        'accepted' => 'Request accepted successfully.',
        'updated' => 'Resource updated successfully.',
        'deleted' => 'Resource deleted successfully.',
        'retrieved' => 'Resource retrieved successfully.',
        'listed' => 'Resources retrieved successfully.',
    ],

    'errors' => [

        'validation' => [
            'title' => 'Validation Failed',
            'detail' => 'One or more validation errors occurred.',
        ],

        'not_found' => [
            'title' => 'Resource Not Found',
            'detail' => 'The requested resource could not be found.',
        ],

        'unauthorized' => [
            'title' => 'Unauthorized',
            'detail' => 'Authentication is required.',
        ],

        'forbidden' => [
            'title' => 'Forbidden',
            'detail' => 'You do not have permission to access this resource.',
        ],

        'conflict' => [
            'title' => 'Conflict',
            'detail' => 'The request conflicts with the current state of the resource.',
        ],

        'internal_server_error' => [
            'title' => 'Internal Server Error',
            'detail' => 'An unexpected error occurred.',
        ],

        'too_many_requests' => [
            'title' => 'Too Many Requests',
            'detail' => 'Rate limit exceeded.',
        ],

        'unprocessable_entity' => [
            'title' => 'Unprocessable Entity',
            'detail' => 'The request could not be processed.',
        ],

        'unsupported_media_type' => [
            'title' => 'Unsupported Media Type',
            'detail' => 'The provided media type is not supported.',
        ],

        'service_unavailable' => [
            'title' => 'Service Unavailable',
            'detail' => 'The service is temporarily unavailable.',
        ],
    ],

];
