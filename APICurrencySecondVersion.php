<?php

$fromAmountCurrency = readline("Enter amount and currency you want to convert (for example 100 EUR) : ");
$toCurrency = readline("Enter the currency you want to covert to (for example USD): ");

list($fromAmount, $fromCurrency) = explode(" ", $fromAmountCurrency);

$fromCurrency = strtolower($fromCurrency);
$toCurrency = strtolower($toCurrency);

$apiUrl = "https://cdn.jsdelivr.net/npm/@fawazahmed0/currency-api@latest/v1/currencies/" . $fromCurrency . ".json";

$response = file_get_contents($apiUrl);

if ($response !== false) {

    $currencyRates = json_decode($response);

    if (!isset($currencyRates->$fromCurrency)) {
        echo "ERROR: Invalid base currency code entered.\n";
        exit;
    }
    $validCurrencyCodes = get_object_vars($currencyRates->$fromCurrency);
    if (!array_key_exists($toCurrency, $validCurrencyCodes)) {
        echo "ERROR: Invalid target currency code entered.\n";
        exit;
    }
    $toCurrencyRate = $currencyRates->$fromCurrency->$toCurrency;
    $convertedAmount = $fromAmount * $toCurrencyRate;
    echo "Converted amount:" . round($convertedAmount, 2) . " " . strtoupper($toCurrency) . "\n";
} else {
    echo "Failed to get exchange rates data from API.\n";
}