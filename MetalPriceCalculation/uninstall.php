<?php
// clear the function override
setFunctionOverride("MetalPriceCalculation.php", "Product", "GetActualPrice");

// remove the sample product if it still exists
$product = $website->FindProduct("Name", "Test Gold Ring");
if ($product==null)
{
	$website->DeleteProduct($product->Id);
}

?>
