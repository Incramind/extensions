<?php

/* In this page we list all the orders for this session or customer.
    if the customer is logged in, orders on other browsers or machines will be included.
	When there is no customer, but just checkout as guest, only orders for the same user and browser are shown.
	You can select a order from the list to see some details, and to do some actions if the paymen method was using the webhook test payment provider.
	If the order is still pending payment or partly paid, you can still make a payment or fail a payment
	Also you can send a change back or a refund when the order is open or already paid.
*/   


?>

  <head>
    [:MetaData, [Website.Name] | [_Order details] ]
    [:Head]
  </head>

	<body>
		[:HeaderBlock]
		<div class="container mt-5">
			<div class="main-content">
				<h1 class="text-danger"> [_Order details]</h1>
				<div class="row">
<?php                 
    $orderId = $_URL["CONTROLLER"];
	//echo "orderId = $orderId";
    $orderId2 = $controller;
	//echo "orderId2 = $orderId2";
	$customerId = 0;
	if ($custoemr!=null)
		$customerId = $customer->Id;
	$order = $website->GetOrder($orderId);
	$mutation = null;
	if ($order==null)
	{
		echo "Order not found";
	}
	// check if the order belongs to the current user/session. Otherwise you can just edit the number and see someone else his/her orders.
	else if ($order->sessionId == $session->Id || $order->custoemrId = $customerId)
	{
		$mutations = $order->GetAllMutations();
		$mutation = $mutations[0];
		$pm = $website->FindPaymentMethod("code", "Sample3");
		if ($pm==null || $mutation==null)
		{
			echo "Payment method not existing?";
		}
		else
		{
			if ($mutation->OrgPaymentMethodId != $pm->Id)
			{
				echo "Another payment method is selected for your order: $order->OrgPaymentMethod";
			}
			else
			{
				$status = OrderMutationStatusTypeToString($order->lastStatus);
				
				$dateStr = incraDateFormat($order->LastDate, "dd-mmm-yyyy hh:nn");
				$total = amountAsString($order->TotalPrice, ',', '.', 2);
				echo "<table class='table table-bordered'>";
				echo "<tr><td>OrderNumber</td><td>$order->OrderNumber</td></tr>";
				echo "<tr><td>Date</td><td>$dateStr</td></tr>";
				echo "<tr><td>Items</td><td>$order->ItemsSummaryText</td></tr>";
				echo "<tr><td>TotalExTax</td><td>$order->TotalExTax</td></tr>";
				echo "<tr><td>TotalTax</td><td>$order->TotalTax</td></tr>";
				echo "<tr><td>TotalCosts</td><td>$order->TotalCosts</td></tr>";
				echo "<tr><td>TotalDiscounts</td><td>$order->TotalDiscounts</td></tr>";
				echo "<tr><td>Total</td><td>$total</td></tr>";
				echo "<tr><td>BillToName</td><td>$order->BillToName</td></tr>";
				echo "<tr><td>ShipToName</td><td>$order->ShipToName</td></tr>";
				echo "<tr><td>ShipToAddressLine1</td><td>$order->ShipToAddressLine1</td></tr>";
				echo "<tr><td>ShipToAddressLine2</td><td>$order->ShipToAddressLine2</td></tr>";
				echo "<tr><td>Status</td><td><strong>$status</strong></td></tr>";
				echo "<tr><td>OpenAmount</td><td>$order->OpenAmount</td></tr>";
				echo "<tr><td>PaidAmount</td><td>$order->PaidAmount</td></tr>";
				echo "</table>";
				$transactions = $order->GetAllTransactions();
				echo "<table class='table table-bordered'>";
				echo "<thead><tr><th>Transactions:</th><th>Date</th><th>Amount</th><th>Status</th><th>Message</th></tr></thead>";
				$cnt = 0;
				foreach ($transactions as $transaction)
				{
					$cnt++;
					$transactionDateStr = incraDateFormat($transaction->UpdatedAt, "dd-mmm-yyyy hh:nn");
					echo "<tr><td class='text-center'>$cnt</td><td class='text-center'>$transactionDateStr</td><td class='text-center'>$transaction->Amount</td><td class='text-center'>$transaction->StatusText</td><td>$transaction->Message</td></tr>";
				}
				echo "</table>";
				//if ($order->lastStatus == OrderMutationStatusType_PendingPayment || $order->lastStatus == OrderMutationStatusType_StartPayment || $order->lastStatus == OrderMutationStatusType_PartlyPaid) 
				//{
				

					// buttons to pay, and to cancel
					echo "<button type=\"button\" onclick=\"successPayment()\" name=\"success\">Pay</button>";
					echo "<input type=\"text\" id=\"amount\" name=\"amount\" title=\"amount\" class=\"input-text form-control\">";
					echo "<button type=\"button\" onclick=\"cancelTransaction()\" name=\"cancel\">Fail payment</button>";
				//}
				//if ($order->lastStatus == OrderMutationStatusType_PendingPayment || $order->lastStatus == OrderMutationStatusType_StartPayment || $order->lastStatus == OrderMutationStatusType_PartlyPaid) 
				//{
					// buttons to refund or charge-back
					echo "<button type=\"button\" onclick=\"refundPayment()\" name=\"refund\">Refund</button>";
					echo "<input type=\"text\" id=\"amountRefund\" name=\"amountRefund\" title=\"amount refund\" class=\"input-text form-control\">";
					echo "<button type=\"button\" onclick=\"chargeBack()\" name=\"cancel\">Charge back</button>";
				//}
				
			}
		}
	}
	else
	{
		echo "Order does not belong to you";
	}
?>	
				</div>
			</div>
		</div>
		[:FooterBlock]
	</body>

<script type="text/javascript">

function callWebhook(){
	console.log("Calling webhook");
	var url_update = "url/{show}";
	
	jQuery.ajax({
			url	:	<?php 
			$webhookPage = "/CheckOut/Webhook/$order->Id/$mutation->Id/$mutation->SecurityCode";		
			echo "\"$webhookPage"; 
			?> ",
			type:	"POST",
			data:	"json",
			success	:	function(responseText){
							console.log("sucess webhook");
							//window.location.reload();
						}
	   });
}

function cancelTransaction()
{
	var url_update = "url/{show}";
	console.log("Calling CANCEL");
	jQuery.ajax({
			url	:	"/paymentSample3/UpdateTransaction/cancel?orderId=" + <?php echo "\"$orderId\""; ?> + "&paymentMethodId=" + <?php echo "\"$mutation->OrgPaymentMethodId\""; ?> + "&actualAmount=" + <?php echo "\"$order->TotalPrice\""; ?> + "&securityCode=" + <?php echo "\"$mutation->SecurityCode\""; ?> + "&name=" + <?php echo "\"$order->BillToName\""; ?>,
			type:	"POST",
			data:	"json",
			success	:	function(responseText){
							console.log("success cancel")								  
							callWebhook();							
						}
	   });
}

function chargeBack()
{
	var url_update = "url/{show}";
	console.log("Calling CANCEL");
	jQuery.ajax({
			url	:	"/paymentSample3/UpdateTransaction/chargeback?orderId=" + <?php echo "\"$orderId\""; ?> + "&paymentMethodId=" + <?php echo "\"$mutation->OrgPaymentMethodId\""; ?> + "&actualAmount=" + <?php echo "\"$order->TotalPrice\""; ?> + "&securityCode=" + <?php echo "\"$mutation->SecurityCode\""; ?> + "&name=" + <?php echo "\"$order->BillToName\""; ?>,
			type:	"POST",
			data:	"json",
			success	:	function(responseText){
							console.log("success cancel")								  
							callWebhook();							
						}
	   });
}

function refundPayment()
{
	var url_update = "url/{show}";
	var amount = jQuery("#amountRefund").val();
	console.log("Calling CANCEL");
	jQuery.ajax({
			url	:	"/paymentSample3/UpdateTransaction/refund?enteredAmount="+amount+"&orderId=" + <?php echo "\"$orderId\""; ?> + "&paymentMethodId=" + <?php echo "\"$mutation->OrgPaymentMethodId\""; ?> + "&actualAmount=" + <?php echo "\"$order->TotalPrice\""; ?> + "&securityCode=" + <?php echo "\"$mutation->SecurityCode\""; ?> + "&name=" + <?php echo "\"$order->BillToName\""; ?>,
			type:	"POST",
			data:	"json",
			success	:	function(responseText){
							console.log("success cancel")								  
							callWebhook();							
						}
	   });
}

function successPayment()
{
	var url_update = "url/{show}";
	var amount = jQuery("#amount").val();
	console.log("Calling CANCEL");
	jQuery.ajax({
			url	:	"/paymentSample3/UpdateTransaction/success?enteredAmount="+amount+"&orderId=" + <?php echo "\"$orderId\""; ?> + "&paymentMethodId=" + <?php echo "\"$mutation->OrgPaymentMethodId\""; ?> + "&actualAmount=" + <?php echo "\"$order->TotalPrice\""; ?> + "&securityCode=" + <?php echo "\"$mutation->SecurityCode\""; ?> + "&name=" + <?php echo "\"$order->BillToName\""; ?>,
			type:	"POST",
			data:	"json",
			success	:	function(responseText){
							console.log("success cancel")								  
							callWebhook();							
						}
	   });
}

</script>



