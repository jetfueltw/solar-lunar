# solarlunar-php

公曆（阳历）、農曆（阴历）轉換，支援時間從 `1900-01-01` 到 `2099-12-31`。

基於 https://github.com/isee15/Lunar-Solar-Calendar-Converter  
有更好的 PSR 與 Composer 支持。

# Installation

```sh
composer require jetfueltw/solarlunar-php
```

# Useage

公曆轉農曆
```php
$solar = Solar::create(2015, 1, 15);
$lunar = SolarLunar::solarToLunar($solar);
// Lunar {
//     "year" => 2014,
//     "month" => 11,
//     "day" => 25,
//     "isLeap" => false
// }
```

農曆轉公曆
```php
$lunar = Lunar::create(2014, 11, 25, false);
$solar = SolarLunar::lunarToSolar($lunar);
// Solar {
//     "year" => 2015,
//     "month" => 1,
//     "day" => 15
// }
```
