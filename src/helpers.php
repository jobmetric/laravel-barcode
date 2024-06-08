<?php

use Illuminate\Database\Eloquent\Model;
use JobMetric\Barcode\Exceptions\ModelBarcodeTraiteNotFoundException;

if (!function_exists('storeBarcode')) {
    /**
     * save the barcode
     *
     * @param Model $model
     * @param string $type
     * @param string $value
     *
     * @return array
     * @throws Throwable
     */
    function storeBarcode(Model $model, string $type, string $value): array
    {
        if (!in_array('JobMetric\Barcode\HasBarcode', class_uses($model))) {
            throw new ModelBarcodeTraiteNotFoundException(get_class($model));
        }

        return $model->storeBarcode($type, $value);
    }
}

if (!function_exists('forgetBarcode')) {
    /**
     * forget the barcode
     *
     * @param Model $model
     * @param string $type
     *
     * @return array
     * @throws Throwable
     */
    function forgetBarcode(Model $model, string $type): array
    {
        if (!in_array('JobMetric\Barcode\HasBarcode', class_uses($model))) {
            throw new ModelBarcodeTraiteNotFoundException(get_class($model));
        }

        return $model->removeBarcode($type);
    }
}

if (!function_exists('forgetAllBarcode')) {
    /**
     * forget all barcodes
     *
     * @param Model $model
     *
     * @return array
     * @throws Throwable
     */
    function forgetAllBarcode(Model $model): array
    {
        if (!in_array('JobMetric\Barcode\HasBarcode', class_uses($model))) {
            throw new ModelBarcodeTraiteNotFoundException(get_class($model));
        }

        return $model->removeAllBarcodes();
    }
}
