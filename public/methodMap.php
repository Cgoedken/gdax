<?php
/**
 * Created by PhpStorm.
 * User: cgoedken
 * Date: 1/17/18
 * Time: 9:51 AM
 */

use gdax\auth;
use Curl\Curl;

if(isset($_GET['method']))
{
	switch($_GET['method']){

		case 'getAccounts':
			$auth = new gdax\auth\auth;
			$accounts = $auth->showAccounts();


		default:
			break;
	}

}