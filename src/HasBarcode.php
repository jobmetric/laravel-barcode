<?php

namespace JobMetric\Barcode;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use JobMetric\Barcode\Enums\TableBarcodeFieldTypeEnum;
use JobMetric\Barcode\Events\BarcodeForgetEvent;
use JobMetric\Barcode\Events\BarcodeStoredEvent;
use JobMetric\Barcode\Events\BarcodeUpdateEvent;
use JobMetric\Barcode\Exceptions\BarcodeTypeNotFoundException;
use JobMetric\Barcode\Http\Resources\BarcodeResource;
use JobMetric\Barcode\Models\Barcode;
use Throwable;

/**
 * @method morphOne(string $class, string $string)
 * @method morphMany(string $class, string $string)
 * @property Barcode barcode
 */
trait HasBarcode
{
    /**
     * Get the barcodes
     *
     * @return MorphMany
     */
    public function barcodes(): MorphMany
    {
        return $this->morphMany(Barcode::class, 'barcodeable');
    }

    /**
     * Get the barcode
     *
     * @return MorphOne
     */
    public function barcode(): MorphOne
    {
        return $this->morphOne(Barcode::class, 'barcodeable');
    }

    /**
     * Store the barcode
     *
     * @param string $type
     * @param string $value
     *
     * @return array
     * @throws Throwable
     */
    public function storeBarcode(string $type, string $value): array
    {
        if (!in_array($type, TableBarcodeFieldTypeEnum::array())) {
            throw new BarcodeTypeNotFoundException($type);
        }

        /**
         * @var Barcode $barcode
         */
        $barcode = $this->barcode()->where('type', $type)->first();

        $mode = $barcode ? 'updated' : 'created';
        if ($barcode) {
            $barcode->update([
                'value' => $value,
            ]);

            event(new BarcodeUpdateEvent($barcode));
        } else {
            $barcode = $this->barcode()->create([
                'type' => $type,
                'value' => $value,
            ]);

            event(new BarcodeStoredEvent($barcode));
        }

        return [
            'ok' => true,
            'message' => trans('barcode::base.messages.' . $mode),
            'data' => BarcodeResource::make($barcode),
            'mode' => $mode,
            'status' => 200
        ];
    }

    /**
     * forget the barcode
     *
     * @param string $type
     *
     * @return array
     * @throws Throwable
     */
    public function forgetBarcode(string $type): array
    {
        if (!in_array($type, TableBarcodeFieldTypeEnum::array())) {
            throw new BarcodeTypeNotFoundException($type);
        }

        /**
         * @var Barcode $barcode
         */
        $barcode = $this->barcode()->where('type', $type)->first();

        if ($barcode) {
            event(new BarcodeForgetEvent($barcode));

            $data = BarcodeResource::make($barcode);

            $barcode->delete();

            return [
                'ok' => true,
                'message' => trans('barcode::base.messages.deleted'),
                'data' => $data,
                'status' => 200
            ];
        } else {
            return [
                'ok' => false,
                'message' => trans('barcode::base.validation.errors'),
                'errors' => [
                    trans('barcode::base.validation.barcode_not_found')
                ],
                'status' => 404
            ];
        }
    }

    /**
     * forget all barcodes
     *
     * @return array
     */
    public function forgetAllBarcodes(): array
    {
        $barcodes = $this->barcodes()->get();

        if ($barcodes->isEmpty()) {
            return [
                'ok' => false,
                'message' => trans('barcode::base.validation.errors'),
                'errors' => [
                    trans('barcode::base.validation.barcode_not_found')
                ],
                'status' => 404
            ];
        } else {
            $data = BarcodeResource::collection($barcodes);

            $barcodes->each(function (Barcode $barcode) {
                event(new BarcodeForgetEvent($barcode));

                $barcode->delete();
            });

            return [
                'ok' => true,
                'message' => trans('barcode::base.messages.all_deleted'),
                'data' => $data,
                'status' => 200
            ];
        }
    }

    /**
     * get the barcode type custom
     */
    public function getBarcodeTypeCustom(): ?string
    {
        /**
         * @var Barcode $barcode
         */
        $barcode = $this->barcode()->where('type', TableBarcodeFieldTypeEnum::CUSTOM())->first();

        return $barcode?->value;
    }

    /**
     * get the barcode type ean_b
     */
    public function getBarcodeTypeEanB(): ?string
    {
        /**
         * @var Barcode $barcode
         */
        $barcode = $this->barcode()->where('type', TableBarcodeFieldTypeEnum::EAN_B())->first();

        return $barcode?->value;
    }

    /**
     * get the barcode type ean_8
     */
    public function getBarcodeTypeEan8(): ?string
    {
        /**
         * @var Barcode $barcode
         */
        $barcode = $this->barcode()->where('type', TableBarcodeFieldTypeEnum::EAN_8())->first();

        return $barcode?->value;
    }

    /**
     * get the barcode type qrcode
     */
    public function getBarcodeTypeQrcode(): ?string
    {
        /**
         * @var Barcode $barcode
         */
        $barcode = $this->barcode()->where('type', TableBarcodeFieldTypeEnum::QRCODE())->first();

        return $barcode?->value;
    }
}
