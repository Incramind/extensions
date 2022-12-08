<?php
	$product 		= $website->GetProduct($product->Id);
	$metal_type 	= $product->MetalType;
	$isMetal 		= $product->IsMetal;

	if($isMetal){ // check if it is a metal property
		$metal 			= $website->FindMetal("Name", $metal_type);
		$return_data 	= initializeMetalPrice($metal, $website, $metal_type, $product);
		if($return_data != null){
			$product->Price = $return_data["return"];
			$_RETURN 		= $return_data["return"];
			$_HANDLED 		= $return_data["return"];
		}
	}

	function initializeMetalPrice($metal, $website, $metal_type, $product){
		$metalTypes = array("XAU", "XAG", "XPT", "XPD");
		$return_data == null;
		if(in_array($metal_type, $metalTypes)){
			if($metal != null){
				// we will check if the datetime difference is greater than 1 hour
				$interval = getInterval($metal->LastRequestedDate);
				$interval_hour = $interval->h;
				$interval_days = $interval->d;
				$interval_year = $interval->y;
				if($interval_hour > 0 || $interval_days > 0 || $interval_year > 0){ // executes when interval reached its limit. Limit is 1 hour
					// we need to change/update the existing metal value then calculate
					$obj = getApiResult($metal_type);
					if($obj != "error"){
						$new_met = updateMetalData($website, $obj, $metal); // this will returns the updated metal value
						$return_data = calculateMetalPrice($website, $new_met, $product);
					}else{
						$return_data = defaultReturnData();
					}
				}else{
					// calculate price
					$return_data = calculateMetalPrice($website, $metal, $product);
				}
			}else{
				// new metal added then do calculate
				$obj = getApiResult($metal_type); // we will create new data if $metal is null
				if($obj != "error"){
					$new_met = createNewData($obj, $website);
					$return_data = calculateMetalPrice($website, $new_met, $product);
				}else{
					$return_data = defaultReturnData();
				}
			}
		}else{
			$return_data = defaultReturnData();
		}
		return $return_data;
	}

	function defaultReturnData(){
		$return_data = array(
			"return" 	=> "",
			"handled" 	=> false
		);
		return $return_data;
	}

	function calculateMetalPrice($website, $metal, $product){
		$isHandled = false;
		$default_troy_ounce_value = 31.103; // value of troy ounce from grams

		# this will be the values from the attribute items
		$metal_type 		= $metal->Name;
		$purity	 			= $product->Purity;
		$grams				= $product->MetalWeight;
		$price_factor 		= $product->PriceFactor;
		$price_additional 	= $product->PriceAdditional;
		$isKarat 			= $product->IsKarat;
		// $currency_used 		= getCurrentCurrencyUsed()->Unit;
		# end of values from attribute item

		$new_price = 0;

		if($isKarat){
			$purity_calc 			= $purity / 24;
			$purity_price_result 	= $metal->Price * $purity_calc;
			$isHandled 				= true;
		}else{
			$purity_calc 			= $purity / 100;
			$purity_price_result 	= $metal->Price * $purity_calc;
			$isHandled 				= true;
		}

		// calculate price per grams, converted from troy ounce
		$price_per_grams 	= $purity_price_result / $default_troy_ounce_value;
		$total_price 		= $price_per_grams * $grams;
		// additional charges
		$factored_price 	= $total_price * ($price_factor/100);
		$total_additional   = $factored_price + $price_additional;
		$new_price 			= $total_additional + $total_price;

		// we'll set the actual price to new price
		$return_data = array(
			"return" 	=> $new_price,
			"handled" 	=> $isHandled
		);
		return $return_data;
		// $debug_data = array(
		// 	"Metal Name" 			=> $metal->Name,
		// 	"Metal Original Price" 	=> $metal->Price,
		// 	"Price based on Purity" => $total_price,
		// 	"Additional Prices" 	=> $total_additional,
		// 	"New Metal Price" 		=> $new_price
		// );
		// print_r($debug_data);
	}

	# function Api Call returns object
	function getApiResult($metal_type){
		$parameters 	= array();
		$extraHeaders 	= array( "x-access-token" => "goldapi-cvncukg22g6zd-io" );
		$result 		= callJsonApi("www.goldapi.io", "api/".$metal_type."/EUR", "",  AuthenticationType_None, "", $parameters, $extraHeaders);
		$apiObj 		= json_decode($result);
		if($apiObj->error != null){ // if has error
			return "error";
		}
		return $apiObj;
	}

	function getInterval($date){
		$date_now = date_create(); // creates new datetime
		$interval = date_diff($date, $date_now); // differetiate time
		return $interval;
	}

	function createNewData($obj, $website){
		$metaltimestamp = $obj->timestamp;
		$metalprice 	= $obj->price;
		$metaltype 		= $obj->metal;
		$metalcurrency 	= $obj->currency;

		$_metal = new Metal();
		$_metal->Name = $metaltype;
		$_metal->Price = $metalprice;
		$_metal->Currency = $metalcurrency;
		$_metal->LastRequestedDate = date('m/d/Y H:i:s', $metaltimestamp);
		$website->AddMetal($_metal);
		return $website->FindMetal("Name", $metaltype);
	}

	function updateMetalData($website, $obj, $metal){
		$metaltimestamp = $obj->timestamp;
		$metalprice 	= $obj->price;
		$metaltype 		= $obj->metal;
		$metalcurrency 	= $obj->currency;

		// find the metal based on id then update the values
		$metal = $website->GetMetal($metal->Id);
		$metal->Name = $metaltype;
		$metal->Price = $metalprice;
		$metal->Currency = $metalcurrency;
		$metal->LastRequestedDate = date('m/d/Y H:i:s', $metaltimestamp);
		return $metal;
	}
?>