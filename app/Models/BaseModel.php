<?php

namespace App\Models;

use Core\App;
use Psr\Container\ContainerInterface;

abstract class BaseModel
{
	private static $instances = [ ];

	public static function getInstance()
	{
		if(!isset(self::$instances[static::class]))
		{
			$container = App::getInstance()->getContainer();
			self::$instances[static::class] = new static($container);
		}

		return self::$instances[static::class];
	}

	protected $db;

	function __construct(ContainerInterface $container)
	{
		$this->db = $container->get('db');
	}

	public static function currentTimestamp()
	{
		return static::timestamp();
	}

	public static function timestamp($date = 'now')
	{
		return date('Y-m-d H:i:s', strtotime($date));
	}
}