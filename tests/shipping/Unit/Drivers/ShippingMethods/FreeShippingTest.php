<?php

uses(\Lunar\Tests\Shipping\TestCase::class);

use Lunar\DataTypes\ShippingOption;
use Lunar\Models\Currency;
use Lunar\Models\TaxClass;
use Lunar\Shipping\DataTransferObjects\ShippingOptionRequest;
use Lunar\Shipping\Drivers\ShippingMethods\FreeShipping;
use Lunar\Shipping\Models\ShippingMethod;
use Lunar\Shipping\Models\ShippingZone;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);
uses(\Lunar\Tests\Shipping\TestUtils::class);

test('can get free shipping', function () {
    $currency = Currency::factory()->create([
        'default' => true,
    ]);

    TaxClass::factory()->create([
        'default' => true,
    ]);

    $shippingZone = ShippingZone::factory()->create([
        'type' => 'countries',
    ]);

    $shippingMethod = ShippingMethod::factory()->create([
        'driver' => 'free-shipping',
        'data' => [
            'minimum_spend' => [
                "{$currency->code}" => 500,
            ],
        ],
    ]);

    $shippingRate = \Lunar\Shipping\Models\ShippingRate::factory()
        ->create([
            'shipping_method_id' => $shippingMethod->id,
            'shipping_zone_id' => $shippingZone->id,
        ]);

    $cart = $this->createCart($currency, 500);

    $driver = new FreeShipping;

    $request = new ShippingOptionRequest(
        cart: $cart,
        shippingRate: $shippingRate
    );

    $shippingOption = $driver->resolve($request);

    expect($shippingOption)->toBeInstanceOf(ShippingOption::class);
});

test('cant get free shipping if minimum isnt met', function () {
    $currency = Currency::factory()->create([
        'default' => true,
    ]);

    TaxClass::factory()->create([
        'default' => true,
    ]);

    $shippingZone = ShippingZone::factory()->create([
        'type' => 'countries',
    ]);

    $shippingMethod = ShippingMethod::factory()->create([
        'driver' => 'free-shipping',
        'data' => [
            'minimum_spend' => [
                "{$currency->code}" => 500,
            ],
        ],
    ]);

    $shippingRate = \Lunar\Shipping\Models\ShippingRate::factory()
        ->create([
            'shipping_method_id' => $shippingMethod->id,
            'shipping_zone_id' => $shippingZone->id,
        ]);

    $cart = $this->createCart($currency, 50);

    $driver = new FreeShipping;

    $request = new ShippingOptionRequest(
        cart: $cart,
        shippingRate: $shippingRate
    );

    $shippingOption = $driver->resolve($request);

    expect($shippingOption)->toBeNull();
});

test('cant get free shipping if currency isnt met', function () {
    $currency = Currency::factory()->create([
        'default' => true,
    ]);

    TaxClass::factory()->create([
        'default' => true,
    ]);

    $shippingZone = ShippingZone::factory()->create([
        'type' => 'countries',
    ]);

    $shippingMethod = ShippingMethod::factory()->create([
        'driver' => 'free-shipping',
        'data' => [
            'minimum_spend' => [
                'FOO' => 500,
            ],
        ],
    ]);

    $shippingRate = \Lunar\Shipping\Models\ShippingRate::factory()
        ->create([
            'shipping_method_id' => $shippingMethod->id,
            'shipping_zone_id' => $shippingZone->id,
        ]);

    $cart = $this->createCart($currency, 10000);

    $driver = new FreeShipping;

    $request = new ShippingOptionRequest(
        shippingRate: $shippingRate,
        cart: $cart,
    );

    $shippingOption = $driver->resolve($request);

    expect($shippingOption)->toBeNull();
});
