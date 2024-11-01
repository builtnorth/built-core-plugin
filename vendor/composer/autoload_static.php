<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit27103aa4442c6f0f9167b991f1a04366
{
    public static $prefixLengthsPsr4 = array (
        'e' => 
        array (
            'enshrined\\svgSanitize\\' => 22,
        ),
        'W' => 
        array (
            'WPBaseline\\' => 11,
        ),
        'C' => 
        array (
            'Composer\\Installers\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'enshrined\\svgSanitize\\' => 
        array (
            0 => __DIR__ . '/..' . '/enshrined/svg-sanitize/src',
        ),
        'WPBaseline\\' => 
        array (
            0 => __DIR__ . '/..' . '/builtnorth/wp-baseline/inc',
        ),
        'Composer\\Installers\\' => 
        array (
            0 => __DIR__ . '/..' . '/composer/installers/src/Composer/Installers',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit27103aa4442c6f0f9167b991f1a04366::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit27103aa4442c6f0f9167b991f1a04366::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit27103aa4442c6f0f9167b991f1a04366::$classMap;

        }, null, ClassLoader::class);
    }
}