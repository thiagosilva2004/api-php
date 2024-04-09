<?php

namespace App\presentation\languages;

class LanguageActual
{
    public static Languages $languageDefault = Languages::PT_BR;

    public static function get(): Languages
    {
        // buscar dados do header Accept-Language
        return self::$languageDefault;
    }
}