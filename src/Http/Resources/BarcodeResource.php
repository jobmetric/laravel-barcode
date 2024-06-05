<?php

namespace JobMetric\Barcode\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed barcodeable_type
 * @property mixed barcodeable_id
 * @property mixed type
 * @property mixed value
 * @property mixed created_at
 */
class BarcodeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'barcodeable_type' => $this->barcodeable_type,
            'barcodeable_id' => $this->barcodeable_id,
            'type' => $this->type,
            'value' => $this->value,
            'created_at' => $this->created_at,
        ];
    }
}
