<?php
require("../../vendor/autoload.php");

$openapi = \OpenApi\Generator::scan([$_SERVER['DOCUMENT_ROOT'].'/api-test/models']);

header('Content-Type: application/x-json');
echo $openapi->toJSON();


