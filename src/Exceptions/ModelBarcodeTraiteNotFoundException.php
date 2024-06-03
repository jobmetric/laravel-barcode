<?php

namespace JobMetric\Barcode\Exceptions;

use Exception;
use Throwable;

class ModelBarcodeTraiteNotFoundException extends Exception
{
    public function __construct(string $model, int $code = 400, ?Throwable $previous = null)
    {
        parent::__construct("The model {$model} must use the JobMetric\Barcode\HasBarcode trait.", $code, $previous);
    }
}
