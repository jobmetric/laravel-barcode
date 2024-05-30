<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use JobMetric\Barcode\Enums\TableBarcodeFieldTypeEnum;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(config('barcode.tables.barcode'), function (Blueprint $table) {
            $table->id();

            $table->morphs('barcodeable');

            $table->string('type')->index();
            /**
             * value: custom , EAN_B, EAN_8 , qrcode
             * use: @extends TableBarcodeFieldTypeEnum
             */

            $table->string('value')->index();
            $table->dateTime('created_at')->nullable();
        });

        cache()->forget('barcode');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(config('barcode.tables.barcode'));

        cache()->forget('barcode');
    }
};
