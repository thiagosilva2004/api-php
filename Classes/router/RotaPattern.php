<?php

    namespace router;

    class RotaPattern{
        public static function getPatterns():array{
            return [
                'numeric' => '[0-9]+',
                'alpha' => '[a-z]+',
                'any' => '[a-z0-9\-]+'
            ];
        }
    }