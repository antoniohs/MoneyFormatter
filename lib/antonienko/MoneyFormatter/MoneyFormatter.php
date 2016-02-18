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

    public function getSymbol($locale, Money $money, $justSymbol = true)
    {
        $string = $this->toStringByLocale($locale, $money);
        $symbol = preg_replace('/[0-9., ]*/iu', '', $string);
        if ($justSymbol) {
            $symbol_tmp = preg_replace('/[a-z]+/iu','',$symbol);
            if ('' != $symbol_tmp) {
                $symbol = $symbol_tmp;
            }
        }
        return $symbol;
    }

    public function getSymbolFromCurrency($locale, Currency $currency, $justSymbol = true)
    {
        return $this->getSymbol($locale, new Money(1, $currency), $justSymbol);
    }

    public function getSymbolPosition($locale, Currency $currency)
    {
        $money = new Money(1, $currency);
        $number_formatter = $this->toStringByLocale($locale, $money);
        $symbol = $this->getSymbol($locale,$money);

        if(strpos($number_formatter,$symbol) === 0) {
            return 0;
        }

        if(strpos($number_formatter,$symbol) === mb_strlen($number_formatter, 'UTF-8')) {
            return 1;
        }
        throw new \Exception('Symbol position not found');

    }

}
