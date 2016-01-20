<?php
namespace antonienko\MoneyFormatter;

use Alcohol\ISO4217;
use Money\Currency;
use Money\Money;

class MoneyFormatter
{
    protected $iso4217;

    public function __construct()
    {
        $this->iso4217 = new ISO4217();
    }

    public function getAmountInBaseUnits(Money $money)
    {
        $iso = $this->iso4217->getByAlpha3($money->getCurrency()->getName());
        $decimals = $iso['exp'];
        $dividend = pow(10,$decimals);
        return $money->getAmount()/$dividend;
    }

    public function toStringByLocale($locale, Money $money)
    {
        $number_formatter = new \NumberFormatter($locale, \NumberFormatter::CURRENCY);
        return $number_formatter->formatCurrency($this->getAmountInBaseUnits($money), $money->getCurrency()->getName());
    }

    public function getSymbol($locale, Money $money)
    {
        $string = $this->toStringByLocale($locale, $money);
        return preg_replace('/[a-z0-9., ]*/iu', '', $string);
    }

    public function getSymbolFromCurrency($locale, Currency $currency)
    {
        return $this->getSymbol($locale, new Money(1, $currency));
    }

    public function getSymbolPosition($locale, Currency $currency)
    {
        $money = new Money(1, $currency);
        $number_formatter = $this->toStringByLocale($locale, $money);
        $symbol = $this->getSymbol($locale,$money);

        if(strpos($number_formatter,$symbol) === 0) {
            return 0;
        }
        var_dump(strpos($number_formatter,$symbol), mb_strlen($number_formatter));
        var_dump(mb_strpos($number_formatter,$symbol), mb_strlen($number_formatter));
        if(strpos($number_formatter,$symbol) === mb_strlen($number_formatter)) {
            return 1;
        }
        throw new \Exception('Symbol position not found');

    }

}
