<?php

namespace Authenticate\Facades;

use Illuminate\Support\Facades\Facade;

abstract class BaseFacade extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return static::class;
    }
    
    /**
     * Changes the default driver of the facade.
     *
     * @param \Closure|string $name
     *
     * @return string
     */
    public static function shouldProxyTo($class)
    {
        static::$app->singleton(self::getFacadeAccessor(), $class);

        return static::class;
    }
}
