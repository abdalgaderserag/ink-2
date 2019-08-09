<?php

namespace App\Admin;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Admin extends model
{
    /**
     * dynamic  change the class name
     * @see setClass()
     * @var string $class
    **/
    public static $class = '';

    public static function setClass($class)
    {
        static::$class = $class;
    }

    /**
     * Boot all of the bootable traits on the model.
     *
     * @return void
     */
    protected static function bootTraits()
    {
        $class = static::class;

        $booted = [];

        static::$traitInitializers[$class] = [];

        foreach (class_uses_recursive($class) as $trait) {
            $method = 'boot'.static::$class;

            if (method_exists($class, $method) && ! in_array($method, $booted)) {
                forward_static_call([$class, $method]);

                $booted[] = $method;
            }

            if (method_exists($class, $method = 'initialize'.static::$class)) {
                static::$traitInitializers[$class][] = $method;

                static::$traitInitializers[$class] = array_unique(
                    static::$traitInitializers[$class]
                );
            }
        }
    }

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return isset($this->table)
            ? $this->table
            : Str::snake(Str::pluralStudly(static::$class));
    }

    /**
     * Get the default foreign key name for the model.
     *
     * @return string
     */
    public function getForeignKey()
    {
        return Str::snake(static::$class).'_'.$this->getKeyName();
    }
}