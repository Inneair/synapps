<?php

namespace Inneair\Synapps\System;

/**
 * This class encapsulates PHP runtime information. It provides high-level interface to read/write PHP configuration
 * settings, and access architecture details (such as 64 bits support, compiled modules, ...).
 */
class PhpRuntime
{
    /**
     * Prevents unwanted instantiation.
     * @codeCoverageIgnore
     */
    private function __construct()
    {
    }

    /**
     * Tells whether PHP interpreter is a 64 bits one.
     *
     * @return bool <code>true</code> if this PHP's interpreter was compiled for 64 bits support, <code>false</code>
     * otherwise.
     */
    public static function is64bits()
    {
        return (PHP_INT_SIZE === 8);
    }
}
