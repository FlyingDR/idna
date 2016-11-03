<?php

namespace MLocati\IDNA\CodepointConverter;

use MLocati\IDNA\Exception\InvalidCharacter;
use MLocati\IDNA\Exception\InvalidCodepoint;

/**
 * Convert an Unicode Code Point to/from an character in US-ASCII encoding.
 */
class CP850 extends CodepointConverter
{
    /**
     * Map from extended characters to Unicode code points.
     *
     * @var array
     */
    protected static $extendedMap = [
        0x80 => 0x00C7, // Ç
        0x81 => 0x00FC, // ü
        0x82 => 0x00E9, // é
        0x83 => 0x00E2, // â
        0x84 => 0x00E4, // ä
        0x85 => 0x00E0, // à
        0x86 => 0x00E5, // å
        0x87 => 0x00E7, // ç
        0x88 => 0x00EA, // ê
        0x89 => 0x00EB, // ë
        0x8A => 0x00E8, // è
        0x8B => 0x00EF, // ï
        0x8C => 0x00EE, // î
        0x8D => 0x00EC, // ì
        0x8E => 0x00C4, // Ä
        0x8F => 0x00C5, // Å
        0x90 => 0x00C9, // É
        0x91 => 0x00E6, // æ
        0x92 => 0x00C6, // Æ
        0x93 => 0x00F4, // ô
        0x94 => 0x00F6, // ö
        0x95 => 0x00F2, // ò
        0x96 => 0x00FB, // û
        0x97 => 0x00F9, // ù
        0x98 => 0x00FF, // ÿ
        0x99 => 0x00D6, // Ö
        0x9A => 0x00DC, // Ü
        0x9B => 0x00F8, // ø
        0x9C => 0x00A3, // £
        0x9D => 0x00D8, // Ø
        0x9E => 0x00D7, // ×
        0x9F => 0x0192, // ƒ
        0xA0 => 0x00E1, // á
        0xA1 => 0x00ED, // í
        0xA2 => 0x00F3, // ó
        0xA3 => 0x00FA, // ú
        0xA4 => 0x00F1, // ñ
        0xA5 => 0x00D1, // Ñ
        0xA6 => 0x00AA, // ª
        0xA7 => 0x00BA, // º
        0xA8 => 0x00BF, // ¿
        0xA9 => 0x00AE, // ®
        0xAA => 0x00AC, // ¬
        0xAB => 0x00BD, // ½
        0xAC => 0x00BC, // ¼
        0xAD => 0x00A1, // ¡
        0xAE => 0x00AB, // «
        0xAF => 0x00BB, // »
        0xB0 => 0x2591, // ░
        0xB1 => 0x2592, // ▒
        0xB2 => 0x2593, // ▓
        0xB3 => 0x2502, // │
        0xB4 => 0x2524, // ┤
        0xB5 => 0x00C1, // Á
        0xB6 => 0x00C2, // Â
        0xB7 => 0x00C0, // À
        0xB8 => 0x00A9, // ©
        0xB9 => 0x2563, // ╣
        0xBA => 0x2551, // ║
        0xBB => 0x2557, // ╗
        0xBC => 0x255D, // ╝
        0xBD => 0x00A2, // ¢
        0xBE => 0x00A5, // ¥
        0xBF => 0x2510, // ┐
        0xC0 => 0x2514, // └
        0xC1 => 0x2534, // ┴
        0xC2 => 0x252C, // ┬
        0xC3 => 0x251C, // ├
        0xC4 => 0x2500, // ─
        0xC5 => 0x253C, // ┼
        0xC6 => 0x00E3, // ã
        0xC7 => 0x00C3, // Ã
        0xC8 => 0x255A, // ╚
        0xC9 => 0x2554, // ╔
        0xCA => 0x2569, // ╩
        0xCB => 0x2566, // ╦
        0xCC => 0x2560, // ╠
        0xCD => 0x2550, // ═
        0xCE => 0x256C, // ╬
        0xCF => 0x00A4, // ¤
        0xD0 => 0x00F0, // ð
        0xD1 => 0x00D0, // Ð
        0xD2 => 0x00CA, // Ê
        0xD3 => 0x00CB, // Ë
        0xD4 => 0x00C8, // È
        0xD5 => 0x0131, // ı
        0xD6 => 0x00CD, // Í
        0xD7 => 0x00CE, // Î
        0xD8 => 0x00CF, // Ï
        0xD9 => 0x2518, // ┘
        0xDA => 0x250C, // ┌
        0xDB => 0x2588, // █
        0xDC => 0x2584, // ▄
        0xDD => 0x00A6, // ¦
        0xDE => 0x00CC, // Ì
        0xDF => 0x2580, // ▀
        0xE0 => 0x00D3, // Ó
        0xE1 => 0x00DF, // ß
        0xE2 => 0x00D4, // Ô
        0xE3 => 0x00D2, // Ò
        0xE4 => 0x00F5, // õ
        0xE5 => 0x00D5, // Õ
        0xE6 => 0x00B5, // µ
        0xE7 => 0x00FE, // þ
        0xE8 => 0x00DE, // Þ
        0xE9 => 0x00DA, // Ú
        0xEA => 0x00DB, // Û
        0xEB => 0x00D9, // Ù
        0xEC => 0x00FD, // ý
        0xED => 0x00DD, // Ý
        0xEE => 0x00AF, // ¯
        0xEF => 0x00B4, // ´
        0xF0 => 0x00AD, // SHY
        0xF1 => 0x00B1, // ±
        0xF2 => 0x2017, // ‗
        0xF3 => 0x00BE, // ¾
        0xF4 => 0x00B6, // ¶
        0xF5 => 0x00A7, // §
        0xF6 => 0x00F7, // ÷
        0xF7 => 0x00B8, // ¸
        0xF8 => 0x00B0, // °
        0xF9 => 0x00A8, // ¨
        0xFA => 0x00B7, // ·
        0xFB => 0x00B9, // ¹
        0xFC => 0x00B3, // ³
        0xFD => 0x00B2, // ²
        0xFE => 0x25A0, // ■
        0xFF => 0x00A0, // NBSP
    ];

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
        return 1;
    }

    /**
     * {@inheritdoc}
     *
     * @see CodepointConverter::codepointToCharacterDo()
     */
    protected function codepointToCharacterDo($codepoint)
    {
        $result = null;
        if ($codepoint <= 0x7F) {
            $result = chr($codepoint);
        } else {
            $p = array_search($codepoint, static::$extendedMap);
            if ($p !== false) {
                $result = chr($p);
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
        if (!isset($character[1])) {
            $byte = ord($character[0]);
            if ($byte <= 0x7F) {
                $result = $byte;
            } else {
                $result = static::$extendedMap[$byte];
            }
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
        $result = ($string === '') ? [] : str_split($string);

        return $result;
    }
}
