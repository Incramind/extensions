<?php

$orderId = $_GET["orderId"];
$paymentMethodId = $_GET["paymentMethodId"];
$actualAmount = $_GET["actualAmount"];
$name = $_GET["name"];
$securityCode = $_GET["securityCode"];

$order = $website->GetOrder($orderId);
$paymentMethod = $website->GetPaymentMethod($paymentMethodId);

$externalId = "12345";

$profileId = $name . " profile";
$message = "test payment accepted by". $name;
$issuer = $name;

$now = new DateTime();

$transaction = new Transaction();
$transaction->SetExternalTransactionId($externalId);
$transaction->SetPaymentMethodName($paymentMethod->Code);
$transaction->SetTransactionType(TransactionType_Order);
$transaction->SetCreatedAt($now);
$transaction->SetAmount($actualAmount);
$transaction->SetPaymentDetails("");
$transaction->SetExtraInfo($profileId);
$transaction->SetMessage($message);
$transaction->SetStatus(TransactionStatusType_Success);
$transaction->SetStatusText("success");
$transaction->SetSecurityCode($securityCode);
$transaction->SetIssuer($issuer);
$transaction->SetConfiguration("");

$history = "full payment made (test, no actual payment)";
$transaction->SetHistory($history);
$order->AddTransaction($transaction);


echo "Done";

?>