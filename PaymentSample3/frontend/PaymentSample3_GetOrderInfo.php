<?php

$orderId = $_GET["orderId"];
$securityCode = $_GET["securityCode"];

//echo "orderId = $orderId and security code = $securityCode";

$order = $website->GetOrder($orderId);
if ($order==null)
{
		echo "Invalid order id";
}
else
{
	$mutations = $order->GetAllMutations();
	$mutation = $mutations[0];
	if ($mutation->GetSecurityCode() != $securityCode)
	{
		echo "Invalid security code";
	}
	else
	{
		class TestObject
		{
		};

		// here we just create a little json object
		$myObj = new TestObject;

		$tot = $order->GetTotalPrice();     // we get the total price of the order, it is possible to get the tax, price ex tax etc
		$totTax = $order->GetTotalTax();     // we get the total price of the order, it is possible to get the tax, price ex tax etc
		$totExTax = $order->GetTotalExTax();     // we get the total price of the order, it is possible to get the tax, price ex tax etc
		$totCosts = $order->GetTotalCosts();     // we get the total price of the order, it is possible to get the tax, price ex tax etc
		$summary = $order->GetItemsSummaryText();   // this is a short description for displaying, you can also get all the items individual and make a longer description

		$myObj->total = $tot;
		$myObj->totalTax = $totTax;
		$myObj->totalExTax = $totExTax;
		$myObj->totalShipping = $totCosts;
		$myObj->summary = $summary;
		$myObj->orderId = $order->Id;
		$myObj->orderNumber = $order->OrderNumber;
		$myObj->orderDate = $order->LastDate;
		$myObj->paymentMethodId = $pm->Id;
		$myObj->customerName = $order->ShipToName;
		$myObj->securityCode = $mutation->SecurityCode;   // the security code is used to match transactions with the order
		$myObj->billToName = $order->BillToName;
		$myObj->billToAddressLine1 = $order->BillToAddressLine1;
		$myObj->billToAddressLine2 = $order->BillToAddressLine2;
		$myObj->items = array();

		$items = $mutation->GetAllItems();
		foreach($items as $item)
		{
			$itemObj = new TestObject;
			$itemObj->name = $item->Name;
			$itemObj->sku = $item->Sku;
			$itemObj->shortDescription = $item->ShortDescription;
			$itemObj->priceEach = $item->PriceEach;
			$itemObj->quantity = $item->Quantity;
			$itemObj->price = $item->Price;
			$myObj->items[] = $itemObj;
		}

		// create the json string from the object
		$myJSON = json_encode($myObj);
		// make it base64, so it does not contain strange characters

		// return the json on the call
		echo $myJSON;
	}
}
?>

