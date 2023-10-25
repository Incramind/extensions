
<?php

    $apiKey = "9ff1bde57b5674b1667d00b7";

    //$baseCurrency = "EUR";
    $baseCurrency = $currencyUsed->displayname;   

    $parameters = array();
    $extraHeaders = array();
    $result = callJsonApi("v6.exchangerate-api.com", "v6/".$apiKey."/latest/".$baseCurrency."", "",  AuthenticationType_None, "", $parameters,     $extraHeaders);

    //echo "v6.exchangerate-api.com", "v6/".$apiKey."/latest/".$baseCurrency."", "",  AuthenticationType_None, "", $parameters,     $extraHeaders;

    $apiData = json_decode($result); 
    //Converting a stdClass -> array
    $arrayData = json_decode(json_encode($apiData), true);
    $apiDataRates = ($arrayData["conversion_rates"]);


    $AllUsedCurrencies = $website->GetAllUsedCurrencies();

        foreach ($AllUsedCurrencies as $currency) {

                foreach ($apiDataRates as $currencyName => $conversionRate) {

                    if($currency->displayname == $currencyName){

                        $currency->setConversionRate($conversionRate);
                    }
                }
            //echo $currency->unit;  
         }  

?>
