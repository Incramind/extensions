
<?php
    //echo $website->Name;
     

    RunImport($website, 25.0, 10.0);


    function RunImport($website, $price_perc, $price_add) 
	{
		$deletedCnt = 0;
		$updatedCnt = 0;
		$addedCnt = 0;
		
        $csvFound=csvOpen("/data/ShopData/Marketplace_data/Marketplace/extensions/ProductImporter/tmp/test.csv");
        if (!$csvFound)
		{
            echo "Error! Csv file not found.";
			return;
		}
		$rows = csvGetNrLines();
		for ($i=0; $i<$rows; $i++)
		{
			$exist_import = false;
			$exist_product = false;
			$arr_csv = csvGetData($i);
			$sku_csv = $arr_csv['Sku'];
			$importedSkus[$sku_csv] = true;

			$import = $website->FindImportProduct('Sku', $sku_csv);
			if ($import == null)
				$exist_import = false;
			else
				$exist_import = true;
			$product = $website->FindProduct('Sku', $sku_csv);
			if ($product == null)
				$exist_product = false;
			else
				$exist_product = true;

			echo "<br/>Line " . ($i+1) . ": " . $sku_csv;
			// the product does not yet exist and is not imported before
			// in this case we will add it.
			if (!$exist_import && !$exist_product) 
			{
				echo "   ... not exist in import and not in product";
				$import = CreateImportProductRecord($arr_csv);
				$website->AddImportProduct($import);
				
				$product = CreateProduct($website, $arr_csv, $price_perc, $price_add);
				$website->AddProduct($product);
				$addedCnt++;
			}
			
			// if it exists in the last import, but not in the product, it means the product was manually deleted or not imported
			// we do not want to import the product, because it was deleted with a reason
			else if ($exist_import && !$exist_product) 
			{
				echo "   ... exist in import and not in product";
				UpdateImportProductRecord($import, $arr_csv);
			}
			
			// if it exists in the import and in the product, then this product was imported before
			// in this case we need to check for changes
			else if ($exist_import && $exist_product) 
			{
				echo "   ... exist in import and in product";
				if (UpdateProduct($product, $import, $arr_csv, $price_perc, $price_add))
					$updatedCnt++;
				UpdateImportProductRecord($import, $arr_csv);
			}    		
			// if it does not exist in the last import, but it exist as product
			// this is a strange situation, it might have been imported before
			// we will add it to the imported products and not update the product, but later changes will update the product
			else if (!$exist_import && $exist_product) 
			{
				echo "   ... not exist in import and does exist in product";
				$import = CreateImportProductRecord($arr_csv);
				$website->AddImportProduct($import);
			}
		}
		
		// we now look at all the product that were imported last time, but not in the latest import anymore
		$imports = $website->GetAllImportProducts();
		foreach ($imports as $import) 
		{
			$exist_in_csv = isset($importedSkus[$import->Sku]);
			if (!$exist_in_csv)
			{
				echo "<br/>product $import->Sku was imported before, but now not anymore in the import";
				// we always have to delete the import product record
				$website->DeleteImportProduct($import->Id);
				// in this case the product is no longer in the csv, but was there before, so we have to delete it if there is a also product
				$product = $website->FindProduct('Sku', $import->sku);
				if ($product != null)
				{
					echo "...also we will delete the product";
					$website->DeleteProduct($product->Id);
					$deletedCnt++;
				}
			}
		}
		
		echo "<p>$addedCnt products added; $updatedCnt products updated and $deletedCnt products deleted</p>";
    }
	
	function CreateImportProductRecord($arr_csv)
	{
		$import = new ImportProduct();
		if (isset($arr_csv["Sku"]))
			$import->sku = $arr_csv["Sku"];
		if (isset($arr_csv["Name"]))
			$import->name = $arr_csv["Name"];
		if (isset($arr_csv["ShortDescription"]))
			$import->shortDescription = $arr_csv["ShortDescription"];
		if (isset($arr_csv["Description"]))
			$import->description = $arr_csv["Description"];
		if (isset($arr_csv["Price"]))
			$import->price = $arr_csv["Price"];
		if (isset($arr_csv["Category"]))
			$import->category = $arr_csv["Category"];
		if (isset($arr_csv["Image1"]))
			$import->image1 = $arr_csv["Image1"];
		if (isset($arr_csv["Image2"]))
			$import->image2 = $arr_csv["Image2"];
		if (isset($arr_csv["Image3"]))
			$import->image3 = $arr_csv["Image3"];
		if (isset($arr_csv["Image4"]))
			$import->image4 = $arr_csv["Image4"];
		return $import;
	}
	
	function CreateProduct($website, $arr_csv, $price_perc, $price_add)
	{
		$product = new Product();
		$product->ProductType = ProductType_Simple;
		if (isset($arr_csv["Sku"]))
			$product->SKU = $arr_csv["Sku"];
		if (isset($arr_csv["Name"]))
			$product->Name = $arr_csv["Name"];
		if (isset($arr_csv["ShortDescription"]))
			$product->ShortDescription = $arr_csv["ShortDescription"];
		if (isset($arr_csv["Description"]))
			$product->Description = $arr_csv["Description"];
		
		// prices can be adjusted
		if (isset($arr_csv["Price"]))
			$product->price = $arr_csv["Price"] * ( 1 + $price_perc/100.0) + $price_add;
		
		if (isset($arr_csv["Name"]) && isset($arr_csv["Price"]))
			$product->active = true;
		else
			$product->active = false;
		$product->Visibility = Visibility_Catalog_and_Search;
		$product->InStock = true;
		if (isset($arr_csv["Name"]))
			$product->UrlKey = $arr_csv["Name"];

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

		// get the category (or create a category)
		if (isset($arr_csv["Category"]))
			$catTotalNames = $arr_csv["Category"];
		else
			$catTotalNames = "Test|Import";
		
		$cat = GetCategory($website, $catTotalNames);
		$product->AddCategory($cat);

		if ($arr_csv["Image1"] != "")
		{
			CopyAndMakeProductImage($product, $arr_csv["Image1"]);
		}
		if ($arr_csv["Image2"] != "")
		{
			CopyAndMakeProductImage($product, $arr_csv["Image2"]);
		}
		if ($arr_csv["Image3"] != "")
		{
			CopyAndMakeProductImage($product, $arr_csv["Image3"]);
		}
		if ($arr_csv["Image4"] != "")
		{
			CopyAndMakeProductImage($product, $arr_csv["Image4"]);
		}

	    return $product;
	}
	
	function UpdateProduct($product, $import, $arr_csv, $price_perc, $price_add)
	{
		// update conditional only
		$fieldCnt = 0;
		
		// when the value in the new inport file is changed since last time, and the product value was not modified manually
		if (isset($arr_csv["Sku"]) && $import->sku != $arr_csv["Sku"])
		{
			if ($product->sku == $import->sku)
			{
				$product->sku = $arr_csv["Sku"];
				$fieldCnt++;
				echo ", sku updated";
			}
			$import->sku = $arr_csv["Sku"];
		}
		if (isset($arr_csv["Name"]) && $import->name != $arr_csv["Name"])
		{
			if ($product->name == $import->name)
			{
				$product->name = $arr_csv["Name"];
				$fieldCnt++;
				echo ", name updated";
			}
			$import->name = $arr_csv["Name"];
		}
		if (isset($arr_csv["ShortDescription"]) && $import->shortDescription != $arr_csv["ShortDescription"])
		{
			if ($product->shortDescription == $import->shortDescription)
			{
				$product->shortDescription = $arr_csv["ShortDescription"];
				$fieldCnt++;
				echo ", short description updated";
			}
			$import->shortDescription = $arr_csv["ShortDescription"];
		}
		if (isset($arr_csv["Description"]) && $import->description != $arr_csv["Description"])
		{
			if ($product->description == $import->description)
			{
				$product->description = $arr_csv["Description"];
				$fieldCnt++;
				echo ", description updated";
			}
			$import->description = $arr_csv["Description"];
		}
		if (isset($arr_csv["Price"]) && $import->price != $arr_csv["Price"])
		{
			if ($product->price == $import->price * (1 + $price_perc/100.0) + $price_add)
			{
				$product->price = $arr_csv["Price"] * (1 + $price_perc/100.0) + $price_add;
				$fieldCnt++;
				echo ", price updated";
			}
			$import->price = $arr_csv["Price"];
		}
		if (isset($arr_csv["Category"]) && $import->category != $arr_csv["Category"])
		{
			// categories not checked on current value
			$product->ClearCategories();
			$product->AddCategory(GetCategory($website, $arr_csv["Category"]));
			$fieldCnt++;
			echo ", category updated";
			$import->category = $arr_csv["Category"];
		}
		if (isset($arr_csv["Image1"]) && $import->image1 != $arr_csv["Image1"])
		{
			echo "csv1: '" . $arr_csv["Image1"] . "' and '$import->image1' shit = $shit..."; 
			$imageStr = substr($import->image1, 0, -4);
			RemoveImageWithLabel($product, $imageStr);
			CopyAndMakeProductImage($product, $arr_csv["Image1"]);
			$fieldCnt++;
			echo ", image1 updated";
			$import->image1 = $arr_csv["Image1"];
			echo "csv1: " . $arr_csv["Image1"] . " and $import->image1 ..."; 
		}
		if (isset($arr_csv["Image2"]) && $import->image2 != $arr_csv["Image2"])
		{
			echo "csv2: " . $arr_csv["Image2"] . " and $import->image2 ..."; 
			$imageStr = substr($import->image2, 0, -4);
			RemoveImageWithLabel($product, $imageStr);
			CopyAndMakeProductImage($product, $arr_csv["Image2"]);
			$fieldCnt++;
			echo ", image2 updated";
			$import->image2 = $arr_csv["Image2"];
			echo "csv2: " . $arr_csv["Image2"] . " and $import->image2 ..."; 
		}
		if (isset($arr_csv["Image3"]) && $import->image3 != $arr_csv["image3"])
		{
			$imageStr = substr($import->image3, 0, -4);
			RemoveImageWithLabel($product, $imageStr);
			CopyAndMakeProductImage($product, $arr_csv["Image3"]);
			$fieldCnt++;
			echo ", image3 updated";
			$import->image3 = $arr_csv["Image3"];
		}
		if (isset($arr_csv["Image4"]) && $import->image4 != $arr_csv["Image4"])
		{
			$imageStr = substr($import->image4, 0, -4);
			RemoveImageWithLabel($product, $imageStr);
			CopyAndMakeProductImage($product, $arr_csv["Image4"]);
			$fieldCnt++;
			echo ", image4 updated";
			$import->image4 = $arr_csv["Image4"];
		}
		return $fieldCnt > 0;
	}
	
	function UpdateImportProductRecord($import, $arr_csv)
	{
		if (isset($arr_csv["Sku"]))
			$import->sku = $arr_csv["Sku"];
		if (isset($arr_csv["Name"]))
			$import->name = $arr_csv["Name"];
		if (isset($arr_csv["ShortDescription"]))
			$import->shortDescription = $arr_csv["ShortDescription"];
		if (isset($arr_csv["Description"]))
			$import->description = $arr_csv["Description"];
		if (isset($arr_csv["Price"]))
			$import->price = $arr_csv["Price"];
		if (isset($arr_csv["Category"]))
			$import->category = $arr_csv["Category"];
		if (isset($arr_csv["Image1"]))
			$import->image1 = $arr_csv["Image1"];
		if (isset($arr_csv["Image2"]))
			$import->image2 = $arr_csv["Image2"];
		if (isset($arr_csv["Image3"]))
			$import->image3 = $arr_csv["Image3"];
		if (isset($arr_csv["Image4"]))
			$import->image4 = $arr_csv["Image4"];
	}
				
	function CopyAndMakeProductImage($product, $imageName)
	{
		$imageStr = substr($imageName, 0, -4);
		$fileName = "/data/ShopData/Marketplace_data/Marketplace/extensions/ProductImporter/tmp/" . $imageName;
		$saveName = copyUploadedImage($fileName, $product);
        $image = new ProductImage();
        $image->IsBaseImage = true;
        $image->Label = $imageStr;
        $image->ImageUrl = $saveName;
        $product->AddImage($image);
	}
				

	function GetCategory($website, $catTotalNames)
	{
		$catNames = explode("|", $catTotalNames);
		$top = true;
		$parentCat = null;
		foreach ($catNames as $catName)
		{
			$cat = null;
			if ($parentCat==null)
			{
				$cats = $website->GetAllTopCategories();
			}
			else
			{
				$cats = $parentCat->GetAllChildCategories();
			}
			foreach ($cats as $c)
			{
				if ($c->Name == $catName)
				{
					$cat = $c;
					break;
				}
			}
			if ($cat == null)
			{
				echo "  - create category: $catName ";
				$cat = new Category();
				$cat->Name = $catName;
				$cat->Description = $catName;
				$cat->DisplayMode = CategoryDisplayMode_Products;
				$cat->InLeftMenu = true;
				$cat->InTopMenu = true;
				$cat->IsActive = true;
				$cat->PageTitle = $catName;
				$cat->UrlKey = $catName; // $website->GetNextFreeUrl(cci, subCatName, URLKINDTYPE_CATEGORY, hcat->GetId(cci)));
				$website->AddCategory($cat);
				if ($parentCat==null)
				{
					echo "  as top ";
					$website->AddTopCategory($cat);
				}
				else
				{
					echo "  as child under $parentCat->name ";
					$parentCat->AddChildCategory($cat);
				}
			}
			$parentCat = $cat;
		}
		return $cat;
	}
	
	function RemoveImageWithLabel($product, $label)
	{
		$arr = $product->GetAllImages();
		foreach ($arr as $pimage)
		{
			if ($pimage->label == $label)
			{
				$product->DeleteImage($pimage->Id);
				break;
			}
		}
	}

				
?>

