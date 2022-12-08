<?php 

overrideMethods();
createMetalTableDefinitions();
setupAttributeGroupWithAttributeItems($website);
createSampleMetalProducts($website);

function overrideMethods()
{
	setFunctionOverride("MetalPriceCalculation.php", "Product", "GetActualPrice");
	echo "function GetActualPrice overriden<br>";
}

function createMetalTableDefinitions()
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

function setupAttributeGroupWithAttributeItems($website)
{
	$attributeSet 			= $website->findAttributeSet("Name", "Simple products");
	if ($attributeSet==null)
	{
		$sets = $website->GetAllAttributeSets();
		if ($sets.size() == 0)
			return;
		$attributeSet = $sets[0];
	}
	$count_attributeGroup   = $attributeSet->countAttributeGroups();
	$count_attributeGroup++;
	$attributeGroup 		= $attributeSet->findAttributeGroup("Name", "Metal Properties");
	if ($attributeGroup == null)
	{
		$newGroup = new AttributeGroup();
		$newGroup->Code 		= "MetalProp";
		$newGroup->Name 		= "Metal Properties";
		$newGroup->SortOrder 	= $count_attributeGroup; // This will be the last count of the attribute groups
		$attributeSet->addAttributeGroup($newGroup);

		echo "AttributeGroup 'Metal Properties' has been created! $newGroup->Id<br>";
		$attributeGroup = $attributeSet->findAttributeGroup("Name", "Metal Properties");
	}
	echo "atribute group found $attributeGroup->Id<br>";
	setupAttributeGroupWithItems($website, $attributeSet, $attributeGroup);
}

function setupAttributeGroupWithItems($website, $attributeSet, $attributeGroup)
{
	// $count 		= getStartingNumberInOrderGroup($website, $attributeGroup);
	$count 		= 1;
	$groupId 	= $attributeGroup->Id; // the attributeGroup Id

	echo "atribute group id again is $groupId<br>";
	
	/*
 	 * Complete list http://local-codeslice.incrashop.nl:9011/Man/PhpFunction/9000017559
 	 * CatalogInputType Enum        Values
 	 * CatalogInputType_TextField	(1)
 	 * CatalogInputType_YesNo       (4)
 	 * CatalogInputType_Price 		(7)
	 */

	$array_data = array(
		"AdminTitle" 		=> "Is Metal",
		"AttributeCode" 	=> "IsMetal",
		"CatalogInputType" 	=> 4,
		"GroupId" 			=> $groupId,
		"OrderInGroup" 		=> $count,
		"DefaultValue"		=> 2, // NO, 1 is yes,
		"VisibleOnProductPage" => 0 // No, 1 is yes
	);
	addAttributeItem($website, $attributeSet, $array_data);
	$count++;
	
	$array_data = array(
		"AdminTitle" 		=> "Metal Type",
		"AttributeCode" 	=> "MetalType",
		"CatalogInputType" 	=> 1,
		"GroupId" 			=> $groupId,
		"OrderInGroup" 		=> $count,
		"DefaultValue"		=> "",
		"VisibleOnProductPage" => 1 // No, 1 is yes
	);
	addAttributeItem($website, $attributeSet, $array_data);
	$count++;

	$array_data = array(
		"AdminTitle" 		=> "Is Karat",
		"AttributeCode" 	=> "IsKarat",
		"CatalogInputType" 	=> 4,
		"GroupId" 			=> $groupId,
		"OrderInGroup" 		=> $count,
		"DefaultValue"		=> 2,
		"VisibleOnProductPage" => 0 // No, 1 is yes
	);
	addAttributeItem($website, $attributeSet, $array_data);
	$count++;

	$array_data = array(
		"AdminTitle" 		=> "Purity Value",
		"AttributeCode" 	=> "Purity",
		"CatalogInputType" 	=> 1,
		"GroupId" 			=> $groupId,
		"OrderInGroup" 		=> $count,
		"DefaultValue"		=> 0,
		"VisibleOnProductPage" => 1 // No, 1 is yes
	);
	addAttributeItem($website, $attributeSet, $array_data);
	$count++;

	$array_data = array(
		"AdminTitle" 		=> "Metal Weight (grams)",
		"AttributeCode" 	=> "MetalWeight",
		"CatalogInputType" 	=> 1,
		"GroupId" 			=> $groupId,
		"OrderInGroup" 		=> $count,
		"DefaultValue"		=> 1,
		"VisibleOnProductPage" => 1 // No, 1 is yes
	);
	addAttributeItem($website, $attributeSet, $array_data);
	$count++;

	$array_data = array(
		"AdminTitle" 		=> "Price Additional",
		"AttributeCode" 	=> "PriceAdditional",
		"CatalogInputType" 	=> 7,
		"GroupId" 			=> $groupId,
		"OrderInGroup" 		=> $count,
		"DefaultValue"		=> 0.00,
		"VisibleOnProductPage" => 0 // No, 1 is yes
	);
	addAttributeItem($website, $attributeSet, $array_data);
	$count++;

	$array_data = array(
		"AdminTitle" 		=> "Price Factor (%)",
		"AttributeCode" 	=> "PriceFactor",
		"CatalogInputType" 	=> 7,
		"GroupId" 			=> $groupId,
		"OrderInGroup" 		=> $count,
		"DefaultValue"		=> 0.00,
		"VisibleOnProductPage" => 0 // No, 1 is yes
	);
	addAttributeItem($website, $attributeSet, $array_data);
	$count++;
}

function addAttributeItem($website, $set, $data)
{
	// check if attribute item is already added
	$checkedAttributeItem = $set->findAttribute("AttributeCode", $data["AttributeCode"]);
	if ($checkedAttributeItem == null)
	{
		$attributeItem 							= new AttributeItem();
		$attributeItem->AdminTitle 				= $data["AdminTitle"];
		$attributeItem->AttributeCode 			= $data["AttributeCode"];
		$attributeItem->CatalogInputType 		= $data["CatalogInputType"];
		$attributeItem->ClearGroupIds();
		$attributeItem->ClearOrderInGroups();
		$attributeItem->SetGroupId($set->Id, $data["GroupId"]);
		$attributeItem->SetOrderInGroup($set->Id, $data["OrderInGroup"]);
		$attributeItem->DefaultValue			= $data["DefaultValue"];
		$attributeItem->VisibleOnProductPage    = $data["VisibleOnProductPage"];
		$attributeItem->ValueRequired 			= 0;
		$attributeItem->ApplyToAllProductTypes 	= 0;
		$attributeItem->AddApplyToProductType(ProductType_Simple);
		$set->addAttribute($attributeItem);
		$website->AddAttribute($attributeItem);
		echo "Item ".$data['AdminTitle']." has been added to AttributeGroup!<br>";
	}
	else
	{
		echo "attributeItem ".$data['AdminTitle']." already added!";
	}
}

function getStartingNumberInOrderGroup($set, $selectedAttributeGroup)
{
	// we need to get all attribute items
	$groupId        = $selectedAttributeGroup->Id;
	$attributeItems = $set->GetAllAttributes();
	$count 			= 0;
	foreach ($attributeItems as $attributeItem) 
	{
		if ($attributeItem->GroupId == $groupId)
		{
			$count += 1;
		}
		else
		{
			$count += 0;
		}
	}
	return $count;
}

function checkProductNotAvailable($website, $productName)
{
	$product = $website->findProduct("Name", $productName);
	return $product == null ? true : false;
}

function createSampleMetalProducts($website)
{
	if (checkProductNotAvailable($website, "Test Gold Ring"))
	{
		// add sample image to metal product: make sure the image is in the directory
		$productImage = new ProductImage();
		$productImage->ImageUrl 		= "Themes_data/codeslice/media/products/Test_Gold_Ring.jpg";

		$product = new Product();
		$taxType 						= $website->findTaxClassProduct("Name","NO VAT");
		$product->Name 					= "Test Gold Ring";
		$product->UrlKey 				= "Test_Gold_Ring";
		$product->Sku 					= "GLDRING12134554321";
		$product->ProductType 			= 1; // Simple products
		$product->BasedOnAttributeSet 	= $website->findAttributeSet("Name","Simple products");
		$product->Active 				= 1;
		$product->Visibility 			= 3; // Catalog and Search 
		$product->Price 				= 0.00;
		$product->TaxType  				= $taxType->Id;
		$product->InStock 				= 1;
		$product->IsFeaturedProduct 	= 1;
		// start: metal properties
		$product->IsMetal				= true;
		$product->MetalType 			= "XAU";
		$product->IsKarat 				= true;
		$product->Purity 				= 24;
		$product->MetalWeight 			= 31.103;
		$product->PriceAdditional 		= 0.00;
		$product->PriceFactor 			= 0.00;
		// end: metal properties
		$product->addImage($productImage);
		$product->Description 			= "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.";
		$product->ShortDescription 		= "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.";
		$website->addProduct($product);
	}

	/*if (checkProductNotAvailable($website, "Test Silver Ring"))
	{
		// add another sample product
		$productImage = new ProductImage();
		$productImage->ImageUrl 		= "Themes_data/codeslice/media/products/Test_Silver_Ring.jpg";

		$product = new Product();
		$taxType 						= $website->findTaxClassProduct("Name","NO VAT");
		$product->Name 					= "Test Silver Ring";
		$product->UrlKey 				= "Test_Silver_Ring";
		$product->Sku 					= "SLVRRING12134554321";
		$product->ProductType 			= 1; // Simple products
		$product->BasedOnAttributeSet 	= $website->findAttributeSet("Name","Simple products");
		$product->Active 				= 1;
		$product->Visibility 			= 3; // Catalog and Search 
		$product->Price 				= 0.00;
		$product->TaxType  				= $taxType->Id;
		$product->InStock 				= 1;
		$product->IsFeaturedProduct 	= 1;
		// start: metal properties
		$product->IsMetal				= true;
		$product->MetalType 			= "XAG";
		$product->IsKarat 				= false;
		$product->Purity 				= 92.5;
		$product->MetalWeight 			= 31.103;
		$product->PriceAdditional 		= 0.00;
		$product->PriceFactor 			= 0.00;
		// end: metal properties
		$product->addImage($productImage);
		$product->Description 			= "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.";
		$product->ShortDescription 		= "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.";
		$website->addProduct($product);
	}*/

	echo "Sample Products has been created!<br>";
}
?>