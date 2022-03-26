<?php

require 'vendor/autoload.php';

use GraphQL\GraphQL;
use GraphQL\Server\ServerConfig;
use GraphQL\Server\StandardServer;
use GraphQL\Type\Schema;
use GraphQL\Utils\BuildSchema;

$contents = file_get_contents('schema.graphql');
$schema = BuildSchema::build($contents);

$debug = true;

$rootResolver = [
    'greetings' => function($root, $args, $context, $info) {
        return trim(
            sprintf(
            'Hello %s %s',
            $args['input']['firstName'],
            $args['input']['lastName'] ?? ''
            )
        );
    }
];

$config = ServerConfig::create()
    ->setSchema($schema)
    ->setRootValue($rootResolver)
    ->setDebugFlag($debug)
;

// @link https://webonyx.github.io/graphql-php/executing-queries/#using-server
$server = new StandardServer($config);
$server->handleRequest();

