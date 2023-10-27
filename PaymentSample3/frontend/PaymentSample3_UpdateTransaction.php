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

$order = $website->GetOrder($orderId);
$paymentMethod = $website->GetPaymentMethod($paymentMethodId);

if ($amount!="" && $amount!=0)
	$actualAmount = $amount;	

// find the right transaction
$transactionFound = null;
$transactions = $order->GetAllTransactions();
foreach ($transactions as $transaction)
{
	if ($transaction->SecurityCode == $securityCode && $transaction->Status == TransactionStatusType_Open && $transaction->Amount = $actualAmount && $code != "refund")
	{
		$transactionFound = $transaction;
		break;
	}
}

if ($transactionFound == null)
{
	$externalId = "12345";
	$profileId = $name . " profile";
	$message = "test payment (" . $code .") by". $name;
	$issuer = $name;

	$now = new DateTime();

	$transaction = new Transaction();
	$transaction->SetExternalTransactionId($externalId);
	$transaction->SetPaymentMethodName($paymentMethod->Code);
	$transaction->SetCreatedAt($now);
	$transaction->SetUpdatedAt($now);
	$transaction->SetAmount($actualAmount);
	$transaction->SetPaymentDetails("");
	$transaction->SetExtraInfo($profileId);
	$transaction->SetMessage($message);

	if ($code=="success")
	{
		$transaction->SetStatus(TransactionStatusType_Success);
		$transaction->SetTransactionType(TransactionType_Order);
	}
	else if ($code=="processing")
	{
		$transaction->SetStatus(TransactionStatusType_Open);
		$transaction->SetTransactionType(TransactionType_Order);
	}
	else if ($code=="cancel")
	{
		$transaction->SetStatus(TransactionStatusType_Failed);
		$transaction->SetTransactionType(TransactionType_Order);
	}
	else if ($code=="refund")
	{
		$transaction->SetStatus(TransactionStatusType_Refunded);
		$transaction->SetTransactionType(TransactionType_Refund);
	}
	else if ($code=="chargeback")
	{
		$transaction->SetStatus(TransactionStatusType_Disputed);
		$transaction->SetTransactionType(TransactionType_Void);
	}
		
	$transaction->SetStatusText($code);
	$transaction->SetSecurityCode($securityCode);
	$transaction->SetIssuer($issuer);
	$transaction->SetConfiguration("");

	$history = "$code -> $actualAmount";
	$transaction->SetHistory($history);
	if ($order!=null)
		$order->AddTransaction($transaction);
	
	echo "No corresponfding transaction found, creating new one";
}
else
{
	$transactionFound->SetUpdatedAt($now);
	if ($code=="success")
	{
		$transactionFound->SetStatus(TransactionStatusType_Success);
	}
	else if ($code=="processing")
	{
		$transactionFound->SetStatus(TransactionStatusType_Open);
	}
	else if ($code=="cancel")
	{
		$transactionFound->SetStatus(TransactionStatusType_Failed);
	}
	else if ($code=="chargeback")
	{
		$transactionFound->SetStatus(TransactionStatusType_Disputed);
		$transactionFound->SetTransactionType(TransactionType_Void);
	}
	
	$history = "<br/>Update: $code -> $actualAmount";
	$transactionFound->SetHistory($transactionFound->History . $history);
	echo "Existing transaction updated";
}


echo "Done";

?>