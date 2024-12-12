<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitbacf0b6d4cc4d534f7ed6e8db44f0f1c
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInitbacf0b6d4cc4d534f7ed6e8db44f0f1c', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitbacf0b6d4cc4d534f7ed6e8db44f0f1c', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitbacf0b6d4cc4d534f7ed6e8db44f0f1c::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
