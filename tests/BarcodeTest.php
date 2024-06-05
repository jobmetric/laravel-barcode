<?php

namespace tests;

use App\Models\Product;
use JobMetric\Barcode\Http\Resources\BarcodeResource;
use Tests\BaseDatabaseTestCase as BaseTestCase;
use Throwable;

class BarcodeTest extends BaseTestCase
{
    /**
     * @throws Throwable
     */
    public function testStore(): void
    {
        // store product
        /** @var Product $product */
        $product = Product::create([
            'status' => true,
        ]);

        $barcode = $product->storeBarcode('ean13', '1234567890128');

        $this->assertIsArray($barcode);
        $this->assertTrue($barcode['ok']);
        $this->assertEquals(201, $barcode['status']);
        $this->assertInstanceOf(BarcodeResource::class, $barcode['data']);
        $this->assertDatabaseHas('barcodes', [
            'barcodeable_id' => $product->id,
            'barcodeable_type' => Product::class,
            'type' => 'ean13',
            'value' => '1234567890128',
        ]);

        $barcode = $product->storeBarcode('ean13', '1234567890129');

        $this->assertIsArray($barcode);
        $this->assertTrue($barcode['ok']);
        $this->assertEquals(200, $barcode['status']);
        $this->assertInstanceOf(BarcodeResource::class, $barcode['data']);
        $this->assertDatabaseHas('barcodes', [
            'barcodeable_id' => $product->id,
            'barcodeable_type' => Product::class,
            'type' => 'ean13',
            'value' => '1234567890129',
        ]);
    }

    /**
     * @throws Throwable
     */
    public function testGet(): void
    {
        // store product
        /** @var Product $product */
        $product = Product::create([
            'status' => true,
        ]);

        $barcode = $product->storeBarcode('ean13', '1234567890128');

        $this->assertIsArray($barcode);
        $this->assertTrue($barcode['ok']);
        $this->assertEquals(201, $barcode['status']);
        $this->assertInstanceOf(BarcodeResource::class, $barcode['data']);
        $this->assertDatabaseHas('barcodes', [
            'barcodeable_id' => $product->id,
            'barcodeable_type' => Product::class,
            'type' => 'ean13',
            'value' => '1234567890128',
        ]);

        $barcodes = $product->getBarcode('ean13');

        $this->assertCount(1, $barcodes);
        $this->assertInstanceOf(BarcodeResource::class, $barcodes[0]);
        $this->assertEquals('ean13', $barcodes[0]->type);
        $this->assertEquals('1234567890128', $barcodes[0]->value);
    }

    /**
     * @throws Throwable
     */
    public function testForget(): void
    {
        // store product
        /** @var Product $product */
        $product = Product::create([
            'status' => true,
        ]);

        $barcode = $product->storeBarcode('ean13', '1234567890128');

        $this->assertIsArray($barcode);
        $this->assertTrue($barcode['ok']);
        $this->assertEquals(201, $barcode['status']);
        $this->assertInstanceOf(BarcodeResource::class, $barcode['data']);
        $this->assertDatabaseHas('barcodes', [
            'barcodeable_id' => $product->id,
            'barcodeable_type' => Product::class,
            'type' => 'ean13',
            'value' => '1234567890128',
        ]);

        $barcode = $product->forgetBarcode('ean13');

        $this->assertIsArray($barcode);
        $this->assertTrue($barcode['ok']);
        $this->assertEquals(200, $barcode['status']);
        $this->assertInstanceOf(BarcodeResource::class, $barcode['data']);
        $this->assertDatabaseMissing('barcodes', [
            'barcodeable_id' => $product->id,
            'barcodeable_type' => Product::class,
            'type' => 'ean13',
            'value' => '1234567890128',
        ]);
    }

    /**
     * @throws Throwable
     */
    public function testForgetAll(): void
    {
        // store product
        /** @var Product $product */
        $product = Product::create([
            'status' => true,
        ]);

        $barcode = $product->storeBarcode('ean13', '1234567890128');

        $this->assertIsArray($barcode);
        $this->assertTrue($barcode['ok']);
        $this->assertEquals(201, $barcode['status']);
        $this->assertInstanceOf(BarcodeResource::class, $barcode['data']);
        $this->assertDatabaseHas('barcodes', [
            'barcodeable_id' => $product->id,
            'barcodeable_type' => Product::class,
            'type' => 'ean13',
            'value' => '1234567890128',
        ]);

        $barcode = $product->storeBarcode('ean8', '12345678');

        $this->assertIsArray($barcode);
        $this->assertTrue($barcode['ok']);
        $this->assertEquals(201, $barcode['status']);
        $this->assertInstanceOf(BarcodeResource::class, $barcode['data']);
        $this->assertDatabaseHas('barcodes', [
            'barcodeable_id' => $product->id,
            'barcodeable_type' => Product::class,
            'type' => 'ean8',
            'value' => '12345678',
        ]);

        $barcode = $product->forgetAllBarcodes();

        $this->assertIsArray($barcode);
        $this->assertTrue($barcode['ok']);
        $this->assertEquals(200, $barcode['status']);
        $this->assertDatabaseMissing('barcodes', [
            'barcodeable_id' => $product->id,
            'barcodeable_type' => Product::class,
        ]);
    }
}
