<?php

namespace JobMetric\Barcode\Events;

use JobMetric\Barcode\Models\Barcode;

class BarcodeUpdateEvent
{
    public Barcode $barcode;

    /**
     * Create a new event instance.
     */
    public function __construct(Barcode $barcode)
    {
        $this->barcode = $barcode;
    }
}
