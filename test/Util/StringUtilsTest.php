<?php

namespace Inneair\Synapps\Test\Util;

use Inneair\Synapps\Test\AbstractSynappsTest;
use Inneair\Synapps\Util\StringUtils;

/**
 * Class containing test suite for string utilities.
 */
class StringUtilsTest extends AbstractSynappsTest
{
    /**
     * An input string.
     * @var string
     */
    const TEST_STRING = 'test';

    /**
     * Compares different strings.
     */
    public function testCompareDifferentStrings()
    {
        $this->assertFalse(StringUtils::equals(self::TEST_STRING, mb_strtoupper(self::TEST_STRING)));
    }

    /**
     * Compares strings with case insensitivity.
     */
    public function testCompareStringsIgnoreCase()
    {
        $this->assertTrue(StringUtils::equals(self::TEST_STRING, mb_strtoupper(self::TEST_STRING), true));
    }

    /**
     * Compares same strings.
     */
    public function testCompareSameStrings()
    {
        $this->assertTrue(StringUtils::equals(self::TEST_STRING, self::TEST_STRING));
    }

    /**
     * Gets the default string for an array.
     */
    public function testDefaultStringForArray()
    {
        $this->assertEquals(
            StringUtils::OPEN_SQUARE_BRACKET . StringUtils::CLOSE_SQUARE_BRACKET,
            StringUtils::defaultString(array())
        );
    }

    /**
     * Gets the default string for an array, with special quotes.
     */
    public function testDefaultStringForArrayWithQuotes()
    {
        $this->assertEquals(
            self::TEST_STRING . self::TEST_STRING,
            StringUtils::defaultString(array(), StringUtils::NULL_STR, self::TEST_STRING)
        );
    }

    /**
     * Gets the default string for an integer.
     */
    public function testDefaultStringForInteger()
    {
        $this->assertEquals(0, StringUtils::defaultString(0));
    }

    /**
     * Gets the default string for <code>null</code>.
     */
    public function testDefaultStringForNull()
    {
        $this->assertEquals(StringUtils::NULL_STR, StringUtils::defaultString(null));
    }

    /**
     * Gets the default string for a string.
     */
    public function testDefaultStringForString()
    {
        $this->assertEquals(
            StringUtils::QUOTE . self::TEST_STRING . StringUtils::QUOTE,
            StringUtils::defaultString(self::TEST_STRING)
        );
    }

    /**
     * Gets the default string for a string, with special quotes.
     */
    public function testDefaultStringForStringWithQuotes()
    {
        $this->assertEquals(
            self::TEST_STRING . self::TEST_STRING . self::TEST_STRING,
            StringUtils::defaultString(self::TEST_STRING, StringUtils::NULL_STR, self::TEST_STRING)
        );
    }

    /**
     * Implodes an array with a special glue.
     */
    public function testImplodeArrayWithGlue()
    {
        $this->assertEquals(
            StringUtils::QUOTE . self::TEST_STRING . StringUtils::QUOTE . StringUtils::ARRAY_VALUES_SEPARATOR
                . StringUtils::QUOTE . self::TEST_STRING . StringUtils::QUOTE,
            StringUtils::implodeRecursively(
                array(self::TEST_STRING, self::TEST_STRING),
                StringUtils::ARRAY_VALUES_SEPARATOR
            )
        );
    }

    /**
     * Implodes an array with an inner empty array.
     */
    public function testImplodeArrayWithInnerArray()
    {
        $this->assertEquals(
            StringUtils::OPEN_SQUARE_BRACKET . StringUtils::CLOSE_SQUARE_BRACKET,
            StringUtils::implodeRecursively(array(array()))
        );
    }

    /**
     * Implodes an array with an inner empty array, and special quotes.
     */
    public function testImplodeArrayWithInnerArrayAndQuotes()
    {
        $this->assertEquals(
            StringUtils::QUOTE . StringUtils::QUOTE,
            StringUtils::implodeRecursively(array(array()), StringUtils::EMPTY_STR, StringUtils::QUOTE)
        );
    }

    /**
     * Implodes an array and shows its keys.
     */
    public function testImplodeArrayWithKeys()
    {
        $this->assertEquals(
            StringUtils::QUOTE . self::TEST_STRING . StringUtils::QUOTE . '=' . StringUtils::QUOTE . self::TEST_STRING
                . StringUtils::QUOTE,
            StringUtils::implodeRecursively(
                array(self::TEST_STRING => self::TEST_STRING),
                StringUtils::EMPTY_STR,
                null,
                true
            )
        );
    }

    /**
     * Implodes an array with an inner <code>null</code> value.
     */
    public function testImplodeArrayWithNull()
    {
        $this->assertEquals(StringUtils::NULL_STR, StringUtils::implodeRecursively(array(null)));
    }

    /**
     * Implodes an empty array.
     */
    public function testImplodeEmptyArray()
    {
        $this->assertEquals(StringUtils::EMPTY_STR, StringUtils::implodeRecursively(array()));
    }
}
