<?php

namespace MLocati\IDNA\CodepointConverter;

use MLocati\IDNA\Exception\InvalidCodepoint;
use MLocati\IDNA\Exception\InvalidCharacter;

/**
 * Convert an Unicode Code Point to/from an character in UTF-8 encoding.
 */
class Utf8 extends CodepointConverter
{
    /**
     * {@inheritdoc}
     *
     * @see CodepointConverter::getMinBytesPerCharacter()
     */
    protected function getMinBytesPerCharacter()
    {
        return 1;
    }

    /**
     * {@inheritdoc}
     *
     * @see CodepointConverter::getMaxBytesPerCharacter()
     */
    protected function getMaxBytesPerCharacter()
    {
        return 4;
    }

    /**
     * {@inheritdoc}
     *
     * @see CodepointConverter::codepointToCharacterDo()
     */
    protected function codepointToCharacterDo($codepoint)
    {
        $result = null;
        if ($codepoint >= static::MIN_CODEPOINT) {
            if ($codepoint <= 0x7F) {
                $result = chr($codepoint);
            } elseif ($codepoint <= 0x7FF) {
                $result = chr(($codepoint >> 6) + 0xC0).chr(($codepoint & 0x3F) + 0x80);
            } elseif ($codepoint <= 0xFFFF) {
                $result = chr(($codepoint >> 12) + 0xE0).chr((($codepoint >> 6) & 0x3F) + 0x80).chr(($codepoint & 0x3F) + 0x80);
            } elseif ($codepoint <= static::MAX_CODEPOINT) {
                $result = chr(($codepoint >> 18) + 0xF0).chr((($codepoint >> 12) & 0x3F) + 0x80).chr((($codepoint >> 6) & 0x3F) + 0x80).chr(($codepoint & 0x3F) + 0x80);
            }
        }
        if ($result === null) {
            throw new InvalidCodepoint($codepoint);
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     *
     * @see CodepointConverter::characterToCodepointDo()
     */
    protected function characterToCodepointDo($character)
    {
        $result = null;
        switch (true) {
            case isset($character[4]):
                break;
            case isset($character[3]):
                $b0 = ord($character[0]);
                if ($b0 >= 0xF0) {
                    $b1 = ord($character[1]);
                    $b2 = ord($character[2]);
                    $b3 = ord($character[3]);
                    if ($b1 >= 0x80 && $b2 >= 0x80 && $b3 >= 0x80) {
                        $c = (($b0 - 0xF0) << 18) + (($b1 - 0x80) << 12) + (($b2 - 0x80) << 6) + ($b3 - 0x80);
                        if ($c <= static::MAX_CODEPOINT) {
                            $result = $c;
                        }
                    }
                }
                break;
            case isset($character[2]):
                $b0 = ord($character[0]);
                if ($b0 >= 0xE0 && $b0 < 0xF0) {
                    $b1 = ord($character[1]);
                    $b2 = ord($character[2]);
                    if ($b1 >= 0x80 && $b2 >= 0x80) {
                        $result = (($b0 - 0xE0) << 12) + (($b1 - 0x80) << 6) + ($b2 - 0x80);
                    }
                }
                break;
            case isset($character[1]):
                $b0 = ord($character[0]);
                if ($b0 >= 0x80 && $b0 < 0xE0) {
                    $b1 = ord($character[1]);
                    if ($b1 >= 0x80) {
                        $result = (($b0 - 0xC0) << 6) + ($b1 - 0x80);
                    }
                }
                break;
            case isset($character[0]):
                $b0 = ord($character[0]);
                if ($b0 < 0x80) {
                    $result = $b0;
                }
                break;
        }

        if ($result === null) {
            throw new InvalidCharacter($character);
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     *
     * @see CodepointConverter::stringToCharacters()
     */
    public function stringToCharacters($string)
    {
        $string = (string) $string;
        if ($string === '') {
            $result = [];
        } else {
            $result = false;
            if (function_exists('preg_split')) {
                $chars = @preg_split('//u', (string) $string, null, PREG_SPLIT_NO_EMPTY);
                if ($chars !== false) {
                    $result = $chars;
                }
            }
            if ($result === false) {
                $result = parent::stringToCharacters($string);
            }
        }

        return $result;
    }
}
