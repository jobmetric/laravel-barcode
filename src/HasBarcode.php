<?php

namespace JobMetric\Barcode;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use JobMetric\Barcode\Enums\TableBarcodeFieldTypeEnum;
use JobMetric\Barcode\Events\BarcodeForgetEvent;
use JobMetric\Barcode\Events\BarcodeStoredEvent;
use JobMetric\Barcode\Events\BarcodeUpdateEvent;
use JobMetric\Barcode\Exceptions\BarcodeNotFoundException;
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
     * search for barcode
     *
     * @param string $value
     * @param string|null $type
     *
     * @return AnonymousResourceCollection
     * @throws Throwable
     */
    public function searchBarcode(string $value, string $type = null): AnonymousResourceCollection
    {
        if ($type) {
            if (!in_array($type, TableBarcodeFieldTypeEnum::values())) {
                throw new BarcodeTypeNotFoundException($type);
            }

            $barcode = $this->barcode()->where('type', $type)->where('value', 'like, %' . $value . '%')->get();
        } else {
            $barcode = $this->barcode()->where('value', 'like, %' . $value . '%')->get();
        }

        if (!$barcode) {
            throw new BarcodeNotFoundException($type);
        }

        return BarcodeResource::collection($barcode);
    }

    /**
     * get barcodes
     *
     * @param string|null $type
     *
     * @return AnonymousResourceCollection
     */
    public function getBarcode(string $type = null): AnonymousResourceCollection
    {
        if ($type) {
            $barcodes = $this->barcode()->where('type', $type)->get();
        } else {
            $barcodes = $this->barcode()->get();
        }

        return BarcodeResource::collection($barcodes);
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
        if (!in_array($type, TableBarcodeFieldTypeEnum::values())) {
            throw new BarcodeTypeNotFoundException($type);
        }

        /**
         * @var Barcode $barcode
         */
        $barcode = $this->barcode()->where('type', $type)->first();

        $mode = $barcode ? 'updated' : 'created';
        $status = $barcode ? 200 : 201;

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
            'status' => $status
        ];
    }

    /**
     * has barcode
     *
     * @param string|null $type
     *
     * @return bool
     */
    public function hasBarcode(string $type = null): bool
    {
        if ($type) {
            return $this->barcode()->where('type', $type)->exists();
        }

        return $this->barcode()->exists();
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
        if (!in_array($type, TableBarcodeFieldTypeEnum::values())) {
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
                'message' => trans('package-core::base.validation.errors'),
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
                'message' => trans('package-core::base.validation.errors'),
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
}
