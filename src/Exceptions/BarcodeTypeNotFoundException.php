<?php

namespace JobMetric\Barcode\Exceptions;

use Exception;
use Throwable;

class BarcodeTypeNotFoundException extends Exception
{
    public function __construct(string $type, int $code = 400, ?Throwable $previous = null)
    {
        parent::__construct("Barcode type '$type' not found!", $code, $previous);
    }
}
