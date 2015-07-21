<?php
namespace antonienko\MoneyFormatter;

use Alcohol\ISO4217;
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
        return preg_replace('/[a-z0-9., ]*/i', '', $string);
    }
}