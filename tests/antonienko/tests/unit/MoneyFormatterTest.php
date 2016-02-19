<?php
namespace antonienko\MoneyFormatter\tests;

use antonienko\MoneyFormatter\MoneyFormatter;
use Money\Currency;
use Money\Money;
class MoneyFormatterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * method getAmountInBaseUnits
     * when calledWithProperMoneyObjects
     * should returnProperResult
     * @dataProvider getAmountCurrencyAndExpectedResult
     */
    public function test_getAmountInBaseUnits_calledWithProperMoneyObjects_returnProperResult($amount, $currency, $expected)
    {
        $sut = new MoneyFormatter();
        $actual = $sut->getAmountInBaseUnits(new Money($amount, new Currency($currency)));
        $this->assertEquals($expected, $actual);
    }

    public function getAmountCurrencyAndExpectedResult()
    {
        return array(
            array(30, 'EUR', 0.30),
            array(3000, 'EUR', 30.00),
            array(3005, 'USD', 30.05),
            array(1000538, 'BHD', 1000.538),
            array(1000538, 'BIF', 1000538),
            array(15000000000, 'EUR', 150000000),
        );
    }

    /**
     * method getSymbolPosition
     * when called
     * should returnSymbolPositionWithZeroOrOneValues
     * @dataProvider getSymbolPositionFromLocale
     */
    public function test_getSymbolPosition_called_returnPositionSymbolWithZeroOrOneValues($locale, $currency , $expected)
    {
        $sut = new MoneyFormatter();
        $actual = $sut->getSymbolPosition($locale, new Currency($currency));
        $this->assertEquals($expected,$actual);
    }

    public function getSymbolPositionFromLocale()
    {
        return array(
            array('de_DE', 'EUR', MoneyFormatter::SYMBOL_POSITION_RIGHT),
            array('en_US', 'EUR', MoneyFormatter::SYMBOL_POSITION_LEFT),
            array('fr_FR', 'EUR', MoneyFormatter::SYMBOL_POSITION_RIGHT),
        );
    }


    /**
     * method toStringByLocale
     * when calledWithProperLocaleAndMoneyObjects
     * should returnLocalizedAmountAndCurrencyString
     * @dataProvider getLocaleAmountCurrencyAndExpectedString
     */
    public function test_toStringByLocale_calledWithProperLocaleAndMoneyObjects_returnLocalizedAmountAndCurrencyString($locale, $amount, $currency, $expected)
    {
        $sut = new MoneyFormatter();
        $actual = $sut->toStringByLocale($locale, new Money($amount, new Currency($currency)));
        $this->assertEquals($expected, $actual, 'Test failed for locale: '.$locale);
    }

    public function getLocaleAmountCurrencyAndExpectedString()
    {
        return array(
            array('de_DE', 300005, 'EUR', '3.000,05 €'),
            array('en_US', 300005, 'EUR', '€3,000.05'),
            array('fr_FR', 300005, 'EUR', '3 000,05 €'),
        );
    }

    /**
     * method getSymbol
     * when calledWithAProperCurrency
     * should returnCurrencySymbol
     * @dataProvider getLocaleCurrencyAndExpectedSymbol
     */
    public function test_getSymbol_calledWithAProperCurrency_returnCurrencySymbol($locale, $currency, $expected)
    {
        $sut = new MoneyFormatter();
        $actual = $sut->getSymbol($locale, new Money(300005, new Currency($currency)));
        $this->assertEquals($expected, $actual, 'Test failed for locale '.$locale.' and currency '.$currency);
    }

    public function getLocaleCurrencyAndExpectedSymbol()
    {
        return array(
            array('de_DE', 'EUR', '€'),
            array('en_US', 'EUR', '€'),
            array('fr_FR', 'EUR', '€'),
            array('de_DE', 'USD', '$'),
            array('en_US', 'USD', '$'),
            array('fr_FR', 'USD', '$'),
            array('en_CA', 'CAD', '$'),
            array('en_CA', 'USD', '$'),
            array('de_DE', 'CHF', 'CHF'),
        );
    }

    /**
     * method getSymbol
     * when calledWithAProperCurrencyButJustSymbolFalse
     * should returnFullCurrencySymbol
     * @dataProvider getLocaleCurrencyAndExpectedFullSymbol
     */
    public function test_getSymbol_calledWithAProperCurrencyButJustSymbolFalse_returnFullCurrencySymbol($locale, $currency, $expected)
    {
        $sut = new MoneyFormatter();
        $actual = $sut->getSymbol($locale, new Money(300005, new Currency($currency)), false);
        $this->assertEquals($expected, $actual, 'Test failed for locale '.$locale.' and currency '.$currency);
    }

    public function getLocaleCurrencyAndExpectedFullSymbol()
    {
        return array(
            array('de_DE', 'EUR', '€'),
            array('en_US', 'EUR', '€'),
            array('fr_FR', 'EUR', '€'),
            array('de_DE', 'USD', '$'),
            array('en_US', 'USD', '$'),
            array('fr_FR', 'USD', '$US'),
            array('en_CA', 'CAD', '$'),
            array('en_CA', 'USD', 'US$'),
            array('en_US', 'CAD', 'CA$'),
            array('de_DE', 'CHF', 'CHF'),
        );
    }


}