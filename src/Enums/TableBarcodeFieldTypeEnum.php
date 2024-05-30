<?php

namespace JobMetric\Barcode\Enums;

use JobMetric\PackageCore\Enums\EnumToArray;

/**
 * @method static CUSTOM()
 * @method static EAN_B()
 * @method static EAN_8()
 * @method static QRCODE()
 */
enum TableBarcodeFieldTypeEnum : string {
    use EnumToArray;

    case CUSTOM = "custom";
    case EAN_B = "ean_b";
    case EAN_8 = "ean_8";
    case QRCODE = "qrcode";
}
