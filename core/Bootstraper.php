<?php
namespace Core;

use Slim\App;
use Core\Support\Facade;
use Core\Psr\ClassAutoloader;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class Bootstraper
{
	protected $app;

	protected $config;

	public function boot()
	{
		$this->setEnvironment();
		$this->loadCore();

		$this->config = load_setting('loader');
		$this->initializeApp();

		// $this->registerAutoloadClass();
		$this->registerHelpers();
		$this->registerDependencies();
		$this->registerMiddlewares();
		$this->registerRoutes();

		Facade::setFacadeContainer($this->app->getContainer());
	}

	public function setEnvironment()
	{
		define('APPPATH', join(DIRECTORY_SEPARATOR, [BASEPATH, 'app']));
		define('ENVIRONMENT', isset($_SERVER['ENV']) ? $_SERVER['ENV'] : 'production');
		
		$base_url = @$_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
		$base_url .= '://'.$_SERVER['HTTP_HOST'];
		$base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

		define('BASE_URL', $base_url);

		switch (ENVIRONMENT)
		{
			case 'development':
				error_reporting(-1);
				ini_set('display_errors', 1);
				break;
			case 'testing':
			case 'production':
				ini_set('display_errors', 0);
				break;
			default:
				header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
				echo 'The application environment is not set correctly.';
				exit(1); // EXIT_ERROR
		}

		date_default_timezone_set('Asia/Jakarta');
	}

	public function runApp()
	{
		$this->app->run();
	}

	protected function loadCore()
	{
		$requiredFiles = [
			'/psr/ClassAutoloader',
			'/support/Arr',
			'/support/helpers',
		];

		foreach($requiredFiles as $path)
		{
			$file = str_replace('/', DIRECTORY_SEPARATOR, __DIR__ . $path . '.php');
			require_once $file;
		}
	}

	protected function initializeApp()
	{
		$setting = load_setting('setting');
		$this->app = new App(['settings' => $setting]);
	}

	protected function registerAutoloadClass()
	{
		$classAutoloader = new ClassAutoloader();
		$classAutoloader->register();

		$coreClasses = [
			'Core\Support' => '/support',
			'Core\Middleware' => '/middlewares',
			'Core\Facades' => '/facades',
		];

		foreach($coreClasses as $namespace => $path)
		{
			$classAutoloader->addNamespace($namespace, __DIR__ .$path);
		}

		foreach(load_setting('classLoader') as $namespace => $directory)
		{
			$path = DIRECTORY_SEPARATOR . \trim($directory, '/\\');
			$classAutoloader->addNamespace($namespace, APPPATH . $path);
		}
	}

	protected function registerHelpers()
	{
		if(isset($this->config['helpers']))
		{
			foreach($this->config['helpers'] as $helper)
			{
				load_helper($helper);
			}
		}
	}

	protected function registerDependencies()
	{
		if(isset($this->config['dependencies']))
		{
			foreach($this->config['dependencies'] as $key => $handler)
			{
				$container = $this->app->getContainer();
	
				if(is_object($handler) && is_string($key))
				{
					$container[$key] = $handler;
				}
				
				if(is_string($handler) && !is_callable($handler))
				{
					if(class_exists($handler))
					{
						$handler = new $handler();
					}
					else
					{
						$handler = load_dependency($container, $handler);
					}
				}
	
				if(is_callable($handler))
				{
					if(is_string($key))
						$container[$key] = $handler;
					else
						$handler($container);
				}
			}
		}
	}

	protected function registerRoutes()
	{
		if(isset($this->config['routes']))
		{
			foreach($this->config['routes'] as $route)
			{
				load_route($this->app, $route);
			}
		}
	}

	protected function registerMiddlewares()
	{
		if(isset($this->config['middlewares']))
		{
			foreach($this->config['middlewares'] as $path => $setting)
			{
				if(is_numeric($path))
				{
					$path = $setting;
					$setting = null;
				}
				
				if(is_callable($path))
				{
					$this->app->add($path);
				}
				elseif(class_exists($path))
				{
					$middleware = new $path($setting);
					$this->app->add(new $path($setting));
				}
				else
				{
					$callable = load_app_file('Middleware', $path);
					if(is_callable($callable))
					{
						$this->app->add($callable);
					}
				}
			}
		}
	}
}