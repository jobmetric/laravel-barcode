<?php

namespace JobMetric\Barcode\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use JobMetric\Barcode\Enums\TableBarcodeFieldTypeEnum;
use JobMetric\Barcode\Models\Barcode;

/**
 * @extends Factory<Barcode>
 */
class BarcodeFactory extends Factory
{
    protected $model = Barcode::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'barcodeable_type' => null,
            'barcodeable_id' => null,
            'type' => TableBarcodeFieldTypeEnum::EAN13(),
            'value' => $this->faker->ean13,
        ];
    }

    /**
     * set barcodeable
     *
     * @param string $barcodeable_type
     * @param int $barcodeable_id
     *
     * @return static
     */
    public function setBarcodeable(string $barcodeable_type, int $barcodeable_id): static
    {
        return $this->state(fn(array $attributes) => [
            'barcodeable_type' => $barcodeable_type,
            'barcodeable_id' => $barcodeable_id
        ]);
    }

    /**
     * set type
     *
     * @param string $type
     *
     * @return static
     */
    public function setType(string $type): static
    {
        return $this->state(fn(array $attributes) => [
            'type' => $type
        ]);
    }

    /**
     * set value
     *
     * @param string $value
     *
     * @return static
     */
    public function setValue(string $value): static
    {
        return $this->state(fn(array $attributes) => [
            'value' => $value
        ]);
    }
}
