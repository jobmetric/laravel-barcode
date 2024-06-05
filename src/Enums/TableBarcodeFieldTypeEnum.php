<?php

namespace JobMetric\Barcode\Enums;

use JobMetric\PackageCore\Enums\EnumToArray;

/**
 * @method static CUSTOM()
 * @method static CODE128()
 * @method static CODE39()
 * @method static CODE93()
 * @method static CODABAR()
 * @method static EAN13()
 * @method static EAN8()
 * @method static UPC()
 * @method static UPCEXT()
 * @method static ISBN()
 * @method static DATAMATRIX()
 * @method static PDF417()
 * @method static QRCODE()
 * @method static ITF14()
 * @method static INTERLEAVED2OF5()
 * @method static POSTNET()
 * @method static MSI()
 * @method static PHARMACODE()
 * @method static MAXICODE()
 * @method static AZTEC()
 * @method static CODE11()
 * @method static CODE128A()
 * @method static CODE128B()
 * @method static CODE128C()
 * @method static CODE39EXTENDED()
 * @method static CODE39MOD43()
 * @method static CODE93EXTENDED()
 * @method static GS1_128()
 * @method static GS1_128COMPOSITE()
 * @method static GS1_CC()
 * @method static GS1DATAMATRIX()
 * @method static GS1DATAMATRIXRECTANGULAR()
 * @method static GS1QRCODE()
 */
enum TableBarcodeFieldTypeEnum : string {
    use EnumToArray;

    case CODE128 = "code128";
    case CODE39 = "code39";
    case CODE93 = "code93";
    case CODABAR = "codabar";
    case EAN13 = "ean13";
    case EAN8 = "ean8";
    case UPC = "upc";
    case UPCEXT = "upcext";
    case ISBN = "isbn";
    case DATAMATRIX = "datamatrix";
    case PDF417 = "pdf417";
    case QRCODE = "qrcode";
    case ITF14 = "itf14";
    case INTERLEAVED2OF5 = "interleaved2of5";
    case POSTNET = "postnet";
    case MSI = "msi";
    case PHARMACODE = "pharmacode";
    case MAXICODE = "maxicode";
    case AZTEC = "aztec";
    case CODE11 = "code11";
    case CODE128A = "code128a";
    case CODE128B = "code128b";
    case CODE128C = "code128c";
    case CODE39EXTENDED = "code39extended";
    case CODE39MOD43 = "code39mod43";
    case CODE93EXTENDED = "code93extended";
    case GS1_128 = "gs1_128";
    case GS1_128COMPOSITE = "gs1_128composite";
    case GS1_CC = "gs1_cc";
    case GS1DATAMATRIX = "gs1datamatrix";
    case GS1DATAMATRIXRECTANGULAR = "gs1datamatrixrectangular";
    case GS1QRCODE = "gs1qrcode";
}
