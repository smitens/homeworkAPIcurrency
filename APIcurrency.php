<?php
$fromAmountCurrency = readline("Enter amount and currency you want to convert (for example 100 EUR) : ");
$toCurrency = readline("Enter the currency you want to covert to (for example USD): ");

list($fromAmount, $fromCurrency) = explode(" ", $fromAmountCurrency);

$fromCurrency = strtolower($fromCurrency);

$apiUrl = "https://cdn.jsdelivr.net/npm/@fawazahmed0/currency-api@latest/v1/currencies/eur.json";

$response = file_get_contents($apiUrl);

if ($response !== false) {

    $currencyRates = json_decode($response, true);

    $validCurrencyCodes = array_keys($currencyRates['eur']);

    if (!in_array($fromCurrency, $validCurrencyCodes) || !in_array($toCurrency, $validCurrencyCodes)) {
        echo "ERROR: Invalid currency code entered.\n";
        exit;
    }

    if (!isset($currencyRates['eur'][$fromCurrency]) || !isset($currencyRates['eur'][$toCurrency])) {
        echo "ERROR: Exchange rates not available for the requested currencies.\n";
        exit;
}
        $fromCurrencyRate = $currencyRates['eur'][$fromCurrency];
        $toCurrencyRate = $currencyRates['eur'][$toCurrency];
        $convertedAmount = $fromAmount * ($toCurrencyRate / $fromCurrencyRate);
        echo "Converted amount:" . round($convertedAmount, 2) . $toCurrency . "\n";
    } else {
    echo "Failed to get exchange rates data from API.\n";
}