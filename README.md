Money Formatter 
===============
[![Build Status](https://api.shippable.com/projects/55a52332edd7f2c0526c925c/badge?branchName=master)](https://app.shippable.com/projects/55a52332edd7f2c0526c925c/builds/latest)

Class to convert [Mathias Verraes Money value objects](https://github.com/mathiasverraes/money) to the base unit representation
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
"antonienko/money-formatter": "1.0.*"
```

##Sample Usage
```php
use antonienko\MoneyFormatter\MoneyFormatter;
use Money\Currency;
use Money\Money;

$money = new Money(300005, new Currency('EUR')

$mf = new MoneyFormatter();
$amount = $mf->getAmountInBaseUnits($money); //$amount will be (float)3000.05
$french_formatted = $mf->toStringByLocale('fr_FR', $money) //$french_formatted will be '3 000,05 €'
```

##License Information
Lincensed under __The MIT License (MIT)__. See the LICENSE file for more details.