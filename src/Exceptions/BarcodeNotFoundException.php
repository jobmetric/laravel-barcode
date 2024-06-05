<?php

namespace JobMetric\Barcode\Exceptions;

use Exception;
use Throwable;

class BarcodeNotFoundException extends Exception
{
    public function __construct(int $code = 400, ?Throwable $previous = null)
    {
        parent::__construct('Barcode not found', $code, $previous);
    }
}
