<?php
//postDump();
//setFunctionOverride("pricePerM2.php", "IncraShop", "CalculateProductPriceFromOptions");

$width = 0.0;
$height = 0.0;

// we check if there are two options which are names 'width' and 'height'
// if not, we do not do anything, and normal functionality will happen

if ($option1 != null)
{
	if ($option1->Label == "Width")
	{
		$width = $value1;
	}
	if ($option1->Label == "Height")
	{
		$height = $value1;
	}
}
if ($option2 != null)
{
	if ($option2->Label == "Width")
	{
		$width = $value2;
	}
	if ($option2->Label == "Height")
	{
		$height = $value2;
	}
}

//$price = $width/100.0 * $height/100.0 * $actualPrice;
//echo "found width=$width and height=$height  actalPRice=$actualPrice   price = $price<br/>";

if ($width > 0.0 && $height > 0.0)
{
	$_HANDLED = true;
	// we calculate the price of he option as length * width  times the price per m2 (the product price). 
	// We assume that the length and width is given in cm.
	// we minus the price of the product because the price of the options is added to the price, but here it needs to replace the price.
	$_RETURN = $width/100.0 * $height/100.0 * $actualPrice - $actualPrice;
}

?>