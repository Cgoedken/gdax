<?php
/**
 * Created by PhpStorm.
 * User: cgoedken
 * Date: 1/7/18
 * Time: 8:28 PM
 */

namespace gdax\auth;
use Curl\Curl;

class auth
{
	protected $sandbox = 'https://api-public.sandbox.gdax.com';
	protected $live = 'https://api.gdax.com';

	protected $key;
	protected $secret;
	protected $passphrase;
	protected $timeStamp;
	protected $sign;

	public function _constructor()
	{
		$this->setKey('5774f89b9f434008fb8ca5ceb0592609');
		$this->setSecret('i1ZJ93T+tuVT9wLTEY3EVGkb0HiZrxXHqp9yIeW4p2C7ahACD8q+RS90jAjCDPCcFb9vjngL0Q+FLDfB5bHl8g==');
		$this->setPass('jsl00iqkwx');
	}
	public function initialize($key, $secret, $passphrase)
	{
		$this->setKey($key);
		$this->setSecret($secret);
		$this->setPass($passphrase);
	}

	public function getKey()
	{
		return $this->key;
	}
	public function getSecret()
	{
		return $this->secret;
	}
	public function getPass()
	{
		return $this->passphrase;
	}
	public function getTimeStamp()
	{
		return $this->timeStamp;
	}
	public function getSign()
	{
		return $this->sign;
	}
	public function getHeaders()
	{
		return [
			'CB-ACCESS-KEY' =>  $this->getKey(),
			'CB-ACCESS-SIGN'  =>  $this->getSign(),
			'CB-ACCESS-TIMESTAMP' =>  $this->getTimeStamp(),
			'CA-ACCESS-PASSPHRASE' =>  $this->getPass()
		];
	}
	public function getSignArray()
	{
		return [
			'signature' => $this->getSign(),
			'key' => $this->getKey(),
			'passPhrase'  =>  $this->getPass(),
			'timestamp' =>  $this->getTimeStamp()
		];
	}

	public function setTimeStamp()
	{
		$this->timeStamp = time();
		return $this;
	}
	public function setKey($key)
	{
		$this->key = $key;
		return $this;
	}
	public function setSecret($secret)
	{
	$this->secret = $secret;
	return $this;
	}
	public function setPass($passphrase)
	{
		$this->passphrase = $passphrase;
		return $this;
	}
	public function setSign($hmac)
	{
		$this->sign = $hmac;
		return $this;
	}

	private function makeSign($path = '', $body = '', $method = 'GET')
	{
		$this->setTimeStamp();

		$hold = $this->getTimeStamp() . $method . '/' . implode('/', $path);

		if(!empty($body))
		{
			switch($method)
			{
				case POSI:
					$hold .= json_encode($body);
					break;

				case GET;
					$hold .= '?' . http_build_query($body);
					break;
			}
		}

		$hmac = hash_hmac('sha256',$hold, base64_decode($this->setSecret()),true);

		$this->setSign(base64_encode($hmac));
	}
	public function makeHeaders($path = '', $body = '', $method = 'GET')
	{
		$this->makeSign($path, $body, $method);

		return $this->getHeaders();
	}

	public function getAccounts()
	{
		$path = $this->sandbox . '/accounts';
		$headers = $this->makeHeaders($path);

		$this->curl = new curl;
		$this->curl->setHeader("Content-Type", "application/json");
		foreach ($headers as $name => $value)
		{
			$this->curl->setHeader($name, $value);
		}

		$this->curl->get($path);
		$response = json_decode($this->curl->response);

		return $response;
	}

	public function showAccounts()
	{
		$accounts = $this->getAccounts();

		return $accounts;
	}

}

