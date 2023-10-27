<?php

$code = $_URL["CONTROLLER"];

$amount = $_GET["enteredAmount"];
$orderId = $_GET["orderId"];
$paymentMethodId = $_GET["paymentMethodId"];
$actualAmount = $_GET["actualAmount"];
$name = $_GET["name"];
$securityCode = $_GET["securityCode"];

echo "code = $code<br/>";
echo "amount = $amount<br/>";
echo "orderId = $orderId<br/>";
echo "paymentMethodId = $paymentMethodId<br/>";
echo "name = $name<br/>";
echo "securityCode = $securityCode<br/>";

if ($amount!="" && $amount!=0)
	$actualAmount = $amount;	

$order = $website->GetOrder($orderId);
$paymentMethod = $website->GetPaymentMethod($paymentMethodId);

$externalId = "12345";

$profileId = $name . " profile";
$message = "test payment (" . $code .") by". $name;
$issuer = $name;

$now = new DateTime();

$transaction = new Transaction();
$transaction->SetExternalTransactionId($externalId);
$transaction->SetPaymentMethodName($paymentMethod->Code);
$transaction->SetTransactionType(TransactionType_Order);
$transaction->SetCreatedAt($now);
$transaction->SetUpdatedAt($now);
$transaction->SetAmount($actualAmount);
$transaction->SetPaymentDetails("");
$transaction->SetExtraInfo($profileId);
$transaction->SetMessage($message);

if ($code=="success")
	$transaction->SetStatus(TransactionStatusType_Success);
else if ($code=="processing")
	$transaction->SetStatus(TransactionStatusType_Open);
else if ($code=="cancel")
	$transaction->SetStatus(TransactionStatusType_Failed);
	
$transaction->SetStatusText($code);
$transaction->SetSecurityCode($securityCode);
$transaction->SetIssuer($issuer);
$transaction->SetConfiguration("");

$history = "$code -> $actualAmount";
$transaction->SetHistory($history);
if ($order!=null)
	$order->AddTransaction($transaction);


echo "Done";

?>