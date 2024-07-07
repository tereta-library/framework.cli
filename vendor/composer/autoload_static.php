<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9cb584ddac3e64a6df75f38ae1176127
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Tereta\\FrameworkCli\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Tereta\\FrameworkCli\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9cb584ddac3e64a6df75f38ae1176127::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9cb584ddac3e64a6df75f38ae1176127::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit9cb584ddac3e64a6df75f38ae1176127::$classMap;

        }, null, ClassLoader::class);
    }
}
