<?php
namespace antonienko\MoneyFormatter;

use Alcohol\ISO4217;
use Money\Currency;
use Money\Money;

class MoneyFormatter
{
    protected $iso4217;
    protected $locale;

    const SYMBOL_POSITION_LEFT = 0;

    const SYMBOL_POSITION_RIGHT = 1;

    public function __construct($locale)
    {
        $this->iso4217 = new ISO4217();
        $this->locale = $locale;
    }

    public function toFloat(Money $money)
    {
        $iso = $this->iso4217->getByAlpha3($money->getCurrency()->getCode());
        $decimals = $iso['exp'];
        $dividend = pow(10, $decimals);
        return $money->getAmount() / $dividend;
    }

    public function toString(Money $money)
    {
        $number_formatter = new \NumberFormatter($this->locale, \NumberFormatter::CURRENCY);
        return $number_formatter->formatCurrency($this->toFloat($money), $money->getCurrency()->getCode());
    }

    public function toSymbol(Money $money, $justSymbol = true)
    {
        $string = $this->toString($money);
        $symbol = preg_replace('/[0-9., ]*/iu', '', $string);
        if ($justSymbol) {
            $symbol_tmp = preg_replace('/[a-z]+/iu', '', $symbol);
            if ('' != $symbol_tmp) {
                $symbol = $symbol_tmp;
            }
        }
        return $symbol;
    }

    public function toSymbolFromCurrency(Currency $currency, $justSymbol = true)
    {
        return $this->toSymbol(new Money(1, $currency), $justSymbol);
    }

    public function getSymbolPosition(Currency $currency)
    {
        $money = new Money(1, $currency);
        $number_formatter = $this->toString($money);
        $symbol = $this->toSymbol($money);

        if (strpos($number_formatter, $symbol) === 0) {
            return self::SYMBOL_POSITION_LEFT;
        }

        if (strpos($number_formatter, $symbol) === mb_strlen($number_formatter, 'UTF-8')) {
            return self::SYMBOL_POSITION_RIGHT;
        }
        throw new \Exception('Symbol position not found');

    }

}
