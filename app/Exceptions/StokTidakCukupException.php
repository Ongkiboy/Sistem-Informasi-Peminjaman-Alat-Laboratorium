<?php

namespace App\Exceptions;

use Exception;

class StokTidakCukupException extends Exception
{
    public function __construct(string $message = 'Stok alat tidak mencukupi.')
    {
        parent::__construct($message);
    }
}