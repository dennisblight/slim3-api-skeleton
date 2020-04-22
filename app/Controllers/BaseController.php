<?php

namespace App\Controllers;

use Psr\Container\ContainerInterface;

abstract class BaseController
{
	protected $container;

	function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}

	public function getContainer()
	{
		return $this->container;
	}
}