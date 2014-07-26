<?php

require_once 'taleo/Api.php';

$Taleo = new RyanSechrest\Taleo\Api(
	'COMPANYCODE',
	'username',
	'password',
	'https://tbe.taleo.net/MANAGER/dispatcher/api/v1/serviceUrl'
);

$Taleo->login();

$entities = $Taleo->get_entities();

$Taleo->debug($entities);

$Taleo->logout();

// EOF
