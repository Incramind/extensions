<?php
// clear the function override
setFunctionOverride("pricePerM2.php", "IncraShop", "CalculateProductPriceFromOptions");

// remove the sample product if it still exists
$product = $website->FindProduct("Name", "Sample printing per m2");
if ($product==null)
{
	$website->DeleteProduct($product->Id);
}


?>
