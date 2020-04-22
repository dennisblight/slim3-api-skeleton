<?php

use Core\Support\Arr;
use Slim\Http\Stream;

if(!function_exists('load_app_file'))
{
    function load_app_file($folder, $path)
    {
        $path = normalize_path($path);
        $file = join(DIRECTORY_SEPARATOR, [APPPATH, $folder, $path.'.php']);
        if(file_exists($file))
        {
            return require $file;
        }
    }
}

if(!function_exists('load_setting'))
{
    function load_setting($key)
    {
        $dotPosition = strpos($key, '.');
        $name = $dotPosition === false ? $key : substr($key, 0, $dotPosition);
        $setting = load_app_file('settings', $name);
        
        if(empty($setting)) return [];

        $key = substr($key, $dotPosition + 1);

        if($key)
        {
            return $setting;
        }
        else
        {
            return Arr::get($setting, $key);
        }
    }
}

if(!function_exists('load_helper'))
{
    function load_helper($path)
    {
        load_app_file('helpers', $path);
    }
}

if(!function_exists('load_dependency'))
{
    function load_dependency($container, $path)
    {
        $path = normalize_path($path);
        $file = join(DIRECTORY_SEPARATOR, [APPPATH, 'dependencies', $path.'.php']);
        if(file_exists($file))
        {
            return include $file;
        }
    }
}

if(!function_exists('storage_file'))
{
    function storage_file($path)
    {
        $file = storage_path($path);
        if(file_exists($file))
        {
            return file_get_contents($file);
        }
    }
}

if(!function_exists('load_route'))
{
    function load_route($app, $path)
    {
        $path = normalize_path($path);
        $file = join(DIRECTORY_SEPARATOR, [APPPATH, 'routes', $path.'.php']);
        if(file_exists($file))
        {
            return include $file;
        }
    }
}

if(!function_exists('read_file_stream'))
{
    function read_file_stream($path): Stream
    {
        $resource = \fopen($path, 'r+');
        return new Stream($resource);
    }
}

if(!function_exists('storage_path'))
{
    function storage_path($path)
    {
        $path = normalize_path($path);
        return join(DIRECTORY_SEPARATOR, [BASEPATH, 'storage', $path]);
    }
}

if(!function_exists('normalize_path'))
{
    function normalize_path($path, $trimSeparator = true)
    {
        $path = str_replace(
            ['/', '\\'],
            [DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR],
            $path
        );

        return $trimSeparator ? trim($path, DIRECTORY_SEPARATOR) : $path;
    }
}