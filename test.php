<?php


echo '<pre>';
// Login to COMET test
$url = 'http://localhost/myddleware/web/api/v1_0/';

include_once 'myddlewareApi.php';

$myddlewareApi = new myddlewareApi($url);
$login = $myddlewareApi->login('admin', 'Recette?1');
print_r($login);

$function = 'synchro';
// $function = 'read_record';
// $function = 'mass_action';
// $function = 'rerun_error';
// $function = 'delete_record';
// $function = 'statistics';

if ($login['success']) {
	
	switch ($function) {
		case 'synchro':
			$parameters = array('rule' => '5e5e5535564c0');
			break;
		case 'read_record':
			$parameters = array(
								'rule' => '5e5e5535564c0',
								'filterQuery' => 'id',
								'filterValues' => '4x60'
							);
			break;
		case 'mass_action':
			$parameters = array(
								'action' => 'restore',
								'dataType' => 'rule',
								'ids' => '5e5e5535564c0',
								'forceAll' => 'Y'
							);
			break;
		case 'rerun_error':
			$parameters = array(
								'limit' => 10,
								'attempt' => 5
							);
			break;
		case 'delete_record':
			$parameters = array(
								'rule' => '5e5e5535564c0',
								'recordId' => '4x65',
								'reference' => '2020-03-09 12:14:36',
								'lastname' => 'lastname01',
								'email' => 'test@test.test',
								'firstname' => 'firstname01'
							);
			break;
		case 'statistics':
			$parameters = '';
			break;
		default:
		   echo 'Function '.$function.' unknown.';
		   die();
		}
	
	$result = $myddlewareApi->call($function,$parameters);
	print_r($result);
	
}

