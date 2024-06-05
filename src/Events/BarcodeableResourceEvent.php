<?php

namespace JobMetric\Barcode\Events;

use JobMetric\Barcode\Models\Barcode;

class BarcodeableResourceEvent
{
    /**
     * The barcodeable model instance.
     *
     * @var mixed
     */
    public mixed $barcodeable;

    /**
     * The resource to be filled by the listener.
     *
     * @var mixed|null
     */
    public mixed $resource;

    /**
     * Create a new event instance.
     *
     * @param mixed $barcodeable
     */
    public function __construct(mixed $barcodeable)
    {
        $this->barcodeable = $barcodeable;
        $this->resource = null;
    }
}
