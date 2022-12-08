<?php
// override the function to calculate a price from the options
setFunctionOverride("pricePerM2.php", "IncraShop", "CalculateProductPriceFromOptions");

// create a test product
$product = $website->FindProduct("Name", "Sample printing per m2");
if ($product==null)
{
	$product = new Product();
    $product->ProductType = ProductType_Simple;
	$product->SKU = "SampleM2";
	$product->Name = "Sample printing per m2";
	$product->ShortDescription = "printing on Canvas, per m2";
	$product->Description = "this is a sample product with option for width and height, where the price is calculated width * height * product price. width/height in cm, price per m2";
	$product->price = 12.50;
	$product->active = true;
	$product->Visibility = Visibility_Catalog_and_Search;
	$product->InStock = true;
	$product->UrlKey = "SampleM2";

    // set the attribute set (to simple products or otherwise the first set available)	
    $set = null;
    $sets = $website->GetAllAttributeSets();
    foreach ($sets as $s)
    {
		if ($set == null)
		{
			$set = $s;
		}
        if ($s->Name == "Simple products")
        {
            $set = $s;
            break;
        }
    }
    $product->BasedOnAttributeSet = $set;
	
    // get the tax class to something with High taxes (or otherwise the first)
    $tcpId = 0;
    $tcps = $website->GetAllTaxClassProducts();
    foreach ($tcps as $t)
    {
        if ($tcpId == 0)
		{
            $tcpId = $t->Id;
		}
        if (stripos($t->Name, "high") != FALSE)
		{
            $tcpId = $t->Id;
        }
	}
    $product->TaxType = $tcpId;
	
	// get the category (or crate a category)
	$cat = null;
	$cat1s = $website->GetAlLTopCategories();
	if (sizeof($cat1s)==0)
	{
		$cat = new Category();
		$cat->Name = "Sample";
		$website->AddCategory($cat);
		$website->AddTopCategory($cat);
	}
	else
	{
		foreach ($cat1s as $c)
		{
			$cat = $c;
			break;
		}
	}
	if ($cat != null)
	{
		$cat2s = $cat->GetAllChildCategories();
		if (sizeof($cat2s) != 0)
		{
			foreach ($cat2s as $c)
			{
				$cat = $c;
				break;
			}
		}
		$product->AddCategory($cat);
	}

	// copy the image from the plug-in image
	$plugin = $website->FindInstalledPlugIn("name", "PricePerM2");
	if ($plugin != null)
	{		
		$image = $plugin->getImage1();
		echo "going to copy image file image = $image ....";
		$saveName = copyImageFile($image, $product);
		echo " and it is savename: $saveName ....";
		if ($saveName != "")
		{
			$pimage = new ProductImage();
			$pimage->ImageUrl = $saveName;
			//$pimage->IsBaseImage = true;
			$product->AddImage($pimage);
		}
	}
	
	// create the options
	$option1 = new ProductOption();
	$option1->Required = true;
	$option1->SortOrder = 1;
	$option1->Label = "Width";
	$option1->OptionType = OptionType_Field;
	$product->AddOption($option1);
    // and the height option
	$option2 = new ProductOption();
	$option2->Required = true;
	$option2->SortOrder = 2;
	$option2->Label = "Height";
	$option2->OptionType = OptionType_Field;
	$product->AddOption($option2);

	// and add the product
	$website->AddProduct($product);
}

?>
