<?php

namespace Aselsan\Codeigniter4NikParser\Exceptions;

use RuntimeException;

final class ParserException extends RuntimeException
{
    public static function forNikNotSupported(): static
    {
        return new self(lang('NikParser.nikNotSupported'));
    }
}
