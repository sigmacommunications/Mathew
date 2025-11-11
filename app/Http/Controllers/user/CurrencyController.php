<?php

// app/Http/Controllers/CurrencyController.php
namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Torann\GeoIP\Facades\GeoIP;

use GeoIPLocation;

class CurrencyController extends Controller
{

    public function getUserLocation()
    {
        $code = GeoIPLocation::getCountryCode();
        $countryCode = $code; // Country code like 'US'
        return $countryCode;
    }

    // public function convertCurrency($amount, $fromCurrency, $toCurrency)
    // {
    //     $exchangeRates = GeoIPLocation::getCurrencyExchangeRate();
    //     $rate = $exchangeRates->getExchangeRate($fromCurrency, $toCurrency);
    //     return $amount * $rate;
    // }

    public function convertCurrency($amount, $fromCurrency, $toCurrency)
    {   
        // Assuming GeoIPLocation is a class with a static method getCurrencyExchangeRate
        // $exchangeRates = GeoIPLocation::getCurrencyExchangeRate();
        $rate = GeoIPLocation::getCurrencyExchangeRate($fromCurrency, $toCurrency);
        return $amount * $rate;
    }

    public function convertCurrencyForUser()
    {   
        $userLocation = $this->getUserLocation();
        $amount = 100; // Replace with the actual amount
        $convertedAmount = $this->convertCurrency($amount, 'USA', $userLocation);
        return view('user.users.converted', compact('convertedAmount'));
    }

}
