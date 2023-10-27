
<?php


    function createKeyTable()
{
    // use for front-end metal name display based on metal type
    $ret = enumManGetValues("MetalType");
    if($ret == null){
        addCustomEnum("MetalType", "The types of the metal");
        addCustomEnumOption("MetalType", "XAU", "Gold");
        addCustomEnumOption("MetalType", "XAG", "Silver");
        addCustomEnumOption("MetalType", "XPT", "Platinum");
        addCustomEnumOption("MetalType", "XPD", "Palladium");
        echo "Custom Enum for MetalType created!<br>";
    }

    if(!CustomTableExists("Metal"))
    {
        customTableCreate("Metal", "", "Metal prices based on their types", "Metals", "blog");
        customTableAddField("Metal", "Name", REPLACER_TYPE_STRING, "What kind of metal it is");
        customTableAddField("Metal", "Price", REPLACER_TYPE_AMOUNT, "Price of the metal");
        customTableAddField("Metal", "Currency", REPLACER_TYPE_STRING, "The currency of the price");
        customTableAddField("Metal", "LastRequestedDate", REPLACER_TYPE_DATETIME, "The last request date-time of getting the API values");
        echo "Custom Table Metal created!<br>";
    }
}

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
         echo "Currency rate updated!";

?>



<?php

    createKeyTable();

    function createKeyTable()
    {
        if(!CustomTableExists("ExchangeRateAPIKey"))
            {
                customTableCreate("ExchangeRateAPIKey", "", "Metal prices based on their types", "Metals", "blog");

                echo "Custom Table ExchangeRateAPIKey created!<br>";
            }
    }

?>