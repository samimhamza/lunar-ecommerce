# Taxation

## Overview

No one likes taxes! But we have to deal with them... Lunar provides manual tax rules to implement the correct sales tax for each order. For complex taxation (e.g. US States) we suggest integrating with a service such as [TaxJar](https://www.taxjar.com/).


## Tax Classes

Tax Classes are assigned to Products and allow us to classify products to certain taxable groups that may have differing tax rates.

```php
Lunar\Models\TaxClass
```

|Field|Description|
|:-|:-|
|id||
|name|e.g. `Clothing`|
|created_at||
|updated_at||

```php
$taxClass = TaxClass::create([
    'name' => 'Clothing',
]);
```

## Tax Zones

These specify a geographic zone for tax rates to be applied. Tax Zones can be based upon countries, states or zip/post codes.

```php
Lunar\Models\TaxZone
```

|Field| Description                         |
|:-|:------------------------------------|
|id|                                     |
|name| e.g. `UK`                           |
|zone_type| `country`, `states`, or `postcodes` |
|price_display| `tax_inclusive` or `tax_exclusive`  |
|active| true/false                          |
|default| true/false                          |
|created_at|                                     |
|updated_at|                                     |

```php
$taxZone = TaxZone::create([
    'name' => 'UK',
    'zone_type' => 'country',
    'price_display' => 'tax_inclusive',
    'active' => true,
    'default' => true,
]);
```

```php
Lunar\Models\TaxZoneCountry
```

|Field|Description|
|:-|:-|
|id||
|tax_zone_id||
|country_id||
|created_at||
|updated_at||


```php
$taxZone->countries()->create([
    'country_id' => \Lunar\Models\Country::first()->id,
]);
```

```php
Lunar\Models\TaxZoneState
```

|Field|Description|
|:-|:-|
|id||
|tax_zone_id||
|state_id||
|created_at||
|updated_at||

```php
$taxZone->states()->create([
    'state_id' => \Lunar\Models\State::first()->id,
]);
```

```php
Lunar\Models\TaxZonePostcode
```

|Field|Description|
|:-|:-|
|id||
|tax_zone_id||
|country_id||
|postcode|wildcard, e.g. `9021*`|
|created_at||
|updated_at||

```php
Lunar\Models\TaxZoneCustomerGroup
```

|Field|Description|
|:-|:-|
|id||
|tax_zone_id||
|customer_group_id||
|created_at||
|updated_at||


## Tax Rates

Tax Zones have one or many tax rates. E.g. you might have a tax rate for the State and also the City, which would collectively make up the total tax amount.

```php
Lunar\Models\TaxRate
```

|Field|Description|
|:-|:-|
|id||
|tax_zone_id||
|name|e.g. `UK`|
|created_at||
|updated_at||

```php
Lunar\Models\TaxRateAmount
```

|Field|Description|
|:-|:-|
|id||
|tax_rate_id||
|tax_class_id||
|percentage|e.g. `6` for 6%|
|created_at||
|updated_at||


## Settings
- Shipping and other specific costs are assigned to tax classes in the settings.
- Calculate tax based upon Shipping or Billing address?
- Default Tax Zone

## Extending

Sometimes the standard tax calculations aren't enough, and you may want to implement your own logic, perhaps connecting to a Tax service such as TaxJar.

Lunar allows you to implement your own tax driver, check the [Extending Lunar](/core/extending/taxation) section for more information.

