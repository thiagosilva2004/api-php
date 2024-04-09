<?php

namespace App\infrastructure\database\types;

enum DatabaseParamsSelectType
{
    case STRING_EQUALS;
    case EQUALS;
}