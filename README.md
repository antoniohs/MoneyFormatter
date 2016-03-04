Money Formatter 
===============
[![Run Status](https://api.shippable.com/projects/55a52332edd7f2c0526c925c/badge?branch=master)](https://app.shippable.com/projects/55a52332edd7f2c0526c925c)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/antonienko/MoneyFormatter/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/antonienko/MoneyFormatter/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/antonienko/MoneyFormatter/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/antonienko/MoneyFormatter/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/antonienko/MoneyFormatter/badges/build.png?b=master)](https://scrutinizer-ci.com/g/antonienko/MoneyFormatter/build-status/master)

Class to convert [Moneyphp/money objects](https://github.com/moneyphp/money) to the base unit representation
of the given currency (float) or to a string representation given a locale, using [php's intl extension](http://php.net/manual/en/numberformatter.formatcurrency.php).

To do so it leverages the info provided by the [iso4217 library from Alcohol](https://github.com/alcohol/iso4217) in order
to know the exact number of decimal places that each currency uses.

##Installation
###Composer
This library is available in packagist.org, you can add it to your project via Composer.

In the "require" section of your composer.json file:

Always up to date (bleeding edge, API *not* guaranteed stable)
```javascript
"antonienko/money-formatter": "dev-master"
```

Specific minor version, API stability
```javascript
"antonienko/money-formatter": "2.0.*"
```

## Features
* Convert a ___Money Object to float value___, depending on the number of decimal places used by the currency.
* Convert a ___Money Object to string___, formatted using the provided locale.
* Get the ___currency symbol___ of a Money Object, either just the symbol or the full currency symbol (The "just the symbol" option for Canadian Dollar would be '$', but if you are in the USA you would need the "full symbol" option "CA$")
* Get the ___symbol position___ for a given locale (right or left position)

##Sample Usage
```php
use antonienko\MoneyFormatter\MoneyFormatter;
use Money\Currency;
use Money\Money;

$some_euros   = new Money(300005, new Currency('EUR'));
$some_dollars = new Money(300005, new Currency('USD'));
$mf = new MoneyFormatter('fr_FR_);

$amount = $mf->toFloat($some_euros); //$amount will be (float)3000.05

$french_formatted = $mf->toString($some_euros); //$french_formatted will be '3 000,05 €'

$just_symbol = $mf->toSymbol($some_dollars); //$just_symbol would be '$'

$full_symbol = $mf->toSymbol($some_dollars, false); //$full_symbol would be '$US'

$position = $mf->getSymbolPosition($some_euros); //position would be MoneyFormatter::SYMBOL_POSITION_RIGHT
```

##License Information
Licensed under __The MIT License (MIT)__. See the LICENSE file for more details.
