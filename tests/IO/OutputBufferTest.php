<?php

namespace Inneair\Synapps\Test\IO;

use Exception;
use Inneair\Synapps\Exception\OutputBufferingException;
use Inneair\Synapps\IO\OutputBuffer;
use Inneair\Synapps\Test\AbstractSynappsTest;

/**
 * Class containing test suite for the output buffer class.
 */
class OutputBufferTest extends AbstractSynappsTest
{
    /**
     * Content in an output buffer
     * @var string
     */
    const CONTENT = 'content';

    /**
     * Opens and cleans an output buffer.
     */
    public function testClean()
    {
        $outputBuffer = new OutputBuffer();
        try {
            echo static::CONTENT;
            $this->assertEquals(static::CONTENT, $outputBuffer->get());
            $outputBuffer->clean();
            $this->assertEmpty($outputBuffer->get());
            $outputBuffer->close();
        } catch (Exception $e) {
            $outputBuffer->close();
            throw $e;
        }

        $hasException = false;
        try {
            $outputBuffer->clean();
        } catch (OutputBufferingException $e) {
            $hasException = true;
        }
        $this->assertException($hasException);
    }

    /**
     * Opens and flushes an output buffer.
     */
    public function testFlush()
    {
        // This trash buffer catches all outputs, to prevent echoing on the standard output, and polluating reports.
        $trashOutputBuffer = new OutputBuffer();
        try {
            $outputBuffer = new OutputBuffer();
            echo static::CONTENT;
            $outputBuffer->flush();
            $outputBuffer->close();
            $trashOutputBuffer->close();
        } catch (Exception $e) {
            if (isset($outputBuffer)) {
                $outputBuffer->close();
            }
            $trashOutputBuffer->close();
            throw $e;
        }

        $hasException = false;
        try {
            $outputBuffer->flush();
        } catch (OutputBufferingException $e) {
            $hasException = true;
        }
        $this->assertException($hasException);
    }

    /**
     * Opens and flushes a nested buffer.
     */
    public function testNestedBuffer()
    {
        $rootOutputBuffer = new OutputBuffer();
        try {
            $childOutputBuffer = new OutputBuffer();
            echo static::CONTENT;
            $this->assertEquals(static::CONTENT, $childOutputBuffer->get());
            $childOutputBuffer->close();
            $this->assertEmpty($rootOutputBuffer->get());
            $rootOutputBuffer->close();
        } catch (Exception $e) {
            if (isset($childOutputBuffer)) {
                $childOutputBuffer->close();
            }
            $this->assertEmpty($rootOutputBuffer->get());
            $rootOutputBuffer->close();
            throw $e;
        }
    }

    /**
     * Opens an output buffer, and gets its length.
     */
    public function testGetLength()
    {
        $outputBuffer = new OutputBuffer();
        try {
            $this->assertEquals(0, $outputBuffer->getLength());
            echo static::CONTENT;
            $this->assertEquals(mb_strlen(static::CONTENT), $outputBuffer->getLength());
            $outputBuffer->close();
        } catch (Exception $e) {
            $outputBuffer->close();
            throw $e;
        }

        $hasException = false;
        try {
            $outputBuffer->getLength();
        } catch (OutputBufferingException $e) {
            $hasException = true;
        }
        $this->assertException($hasException);
    }

    /**
     * Opens an output buffer, and gets its level.
     */
    public function testGetLevel()
    {
        $currentLevel = ob_get_level();
        $outputBuffer = new OutputBuffer();
        try {
            $this->assertEquals($currentLevel + 1, $outputBuffer->getLevel());
            $outputBuffer->close();
        } catch (Exception $e) {
            $outputBuffer->close();
            throw $e;
        }

        $hasException = false;
        try {
            $outputBuffer->getLevel();
        } catch (OutputBufferingException $e) {
            $hasException = true;
        }
        $this->assertException($hasException);
    }

    /**
     * Opens an output buffer, and gets its status.
     */
    public function testGetStatus()
    {
        $outputBuffer = new OutputBuffer();
        try {
            $status = $outputBuffer->getStatus();
            $this->assertTrue(is_array($status));
            $this->assertContainsOnly('string', array_keys($status));
            $outputBuffer->close();
        } catch (Exception $e) {
            $outputBuffer->close();
            throw $e;
        }

        $hasException = false;
        try {
            $outputBuffer->getStatus();
        } catch (OutputBufferingException $e) {
            $hasException = true;
        }
        $this->assertException($hasException);
    }

    /**
     * Opens and closes an output buffer.
     */
    public function testOpenAndClose()
    {
        $outputBuffer = new OutputBuffer();
        $outputBuffer->close();

        $hasException = false;
        try {
            $outputBuffer->close();
        } catch (OutputBufferingException $e) {
            $hasException = true;
        }
        $this->assertException($hasException);
    }

    /**
     * Opens an output buffer with an invalid callback.
     */
    public function testOpenWithInvalidCallback()
    {
        $hasException = false;
        try {
            new OutputBuffer(array());
        } catch (OutputBufferingException $e) {
            $hasException = true;
        }
        $this->assertException($hasException);
    }
}
