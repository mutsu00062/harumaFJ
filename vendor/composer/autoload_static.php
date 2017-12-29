<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc1e158d6aa6259887130a77a1973d6d5
{
    public static $prefixLengthsPsr4 = array (
        'L' => 
        array (
            'LINE\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'LINE\\' => 
        array (
            0 => __DIR__ . '/..' . '/linecorp/line-bot-sdk/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc1e158d6aa6259887130a77a1973d6d5::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc1e158d6aa6259887130a77a1973d6d5::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
