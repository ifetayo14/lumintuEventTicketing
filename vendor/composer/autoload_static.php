<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticIniteb0e6d744faf65a5855cf19c24d6f72f
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticIniteb0e6d744faf65a5855cf19c24d6f72f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticIniteb0e6d744faf65a5855cf19c24d6f72f::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticIniteb0e6d744faf65a5855cf19c24d6f72f::$classMap;

        }, null, ClassLoader::class);
    }
}