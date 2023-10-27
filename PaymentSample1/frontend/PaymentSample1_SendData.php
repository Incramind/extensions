<?php

/* In this override you have the following variables available:

$successPage       (string)                  Page to redirect to when the payment succeeds.
$failPage          (string)                  Page to redirect to when the payment fails
$processingPage    (string)                  Page to redirect to when the payment s still processing 
$webHookPage       (string)                  Page to call for the webhook 
$finishedPage      (string)                  Finish page that will get the status from the transaction
$order             (Object: Order)           The current Order
$mutation          (Object: OrderMutation)   The current mutation  
$pm                (Object: PaymentMethod)   The current payment method class 
$redirect          (return string)           The redirection return to go to the payment method url.  (we can directly return "fail", "Success" or "Processing" if there s no interface or a direct result is known)
$checkout          (Object: ShoppingCart)    The shopping cart with its content. Normally it is better to use the $order and $mutation as this contains the same information as the cart, and is already processed. A shopping cart may contain items that are not checked-out.
*/


class TestObject
{
};

// here we just create a little json object
$myObj = new TestObject;
$myObj->successPage = $successPage;
$myObj->failPage = $failPage;
$myObj->processingPage = $processingPage;
//$myObj->webHookPage = $webHookPage;  (not used)
//$myObj->finishedPage = $finishedPage; (not used)
$tot = $order->GetTotalPrice();     // we get the total price of the order, it is possible to get the tax, price ex tax etc
$summary = $order->GetItemsSummaryText();   // this is a short description for displaying, you can also get all the items individual and make a longer description
$myObj->total = $tot;
$myObj->summary = $summary;
$myObj->orderId = $order->Id;
$myObj->paymentMethodId = $pm->Id;
$myObj->customerName = $order->ShipToName;
$myObj->securityCode = $mutation->SecurityCode;   // the security code is used to match transactions with the order

// create the json string from the object
$myJSON = json_encode($myObj);
// make it base64, so it does not contain strange characters
$myBase64 = base64_encode($myJSON);

// and redirect to the payment processor page
// normally this is an external URL, but we use a internal URL for this sample.
// and yes, we just add the json as a GET, this of course is just a sample, a real payment implementation has more requrements
$redirect = "/PaymentSample1/Show?val=$myBase64";
$_HANDLED = true;
$_RETURN = true;

?>

