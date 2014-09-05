<?php

namespace Inneair\Synapps\Test;

use Exception;

/**
 * Base class for all PHPUnit tests in the Synapps library, and providing methods to access the data directory.
 */
abstract class AbstractSynappsTest extends AbstractTest
{
    /**
     * Absolute path of the data directory.
     * @var string
     */
    private $dataPath;
    /**
     * Absolute path prefix of the data directory, ending with a directory separator.
     * @var string
     */
    private $dataPathPrefix;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        $this->dataPath = __DIR__ . '/../data';
        $this->dataPathPrefix = $this->dataPath . DIRECTORY_SEPARATOR;

        // Go on with the setup
        parent::setUp();
    }

    /**
     * Gets the absolute path to the data directory, at the library's root.
     *
     * @return string Path.
     */
    protected function getDataPath()
    {
        return $this->dataPath;
    }

    /**
     * Gets the absolute path to the data directory, at the library's root, for use as a path prefix. The prefix ends
     * with a directory separator, so as it can be used immediately.
     *
     * @return string Path ending with a directory separator, useful to prefix a file name.
     */
    protected function getDataPathPrefix()
    {
        return $this->dataPathPrefix;
    }
}
