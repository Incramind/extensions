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
    [:MetaData, [Website.Name] | [_Customer Account Create] ]
    [:Head]
  </head>

	<body>
		[:HeaderBlock]
		<div class="container mt-5">
			<div class="main-content">
				<h1 class="text-danger"> [_Personal Order list]</h1>
				<div>
					<table class="table table-bordered">
						<thead>
							<tr><th>Number</th><th>Date</th><th>Items</th><th>Total</th><th>Status</th><th>Show details</th></tr>
						</thead>
						<?php 
							$customerId = 0;
							if ($custoemr!=null)
								$customerId = $customer->Id;
							$orders = $website->GetAllOrdersForSession($session->Id, $customerId);
							foreach($orders as $order)
							{
								if ($order->OrgPaymentMethod != "PaymentSample3")
								{
									$status = OrderMutationStatusTypeToString($order->lastStatus);
									$dateStr = incraDateFormat($order->LastDate, "dd-mmm-yyyy hh:nn");
									$total = amountAsString($order->TotalPrice, ',', '.', 2);
									echo "<tr><td>$order->OrderNumber</td><td>$dateStr</td><td>$order->ItemsSummaryText</td><th>$total</td><td>$status</td><td><a href=\"/paymentSample3/OrderDetails/$order->Id\">link text</a></td></tr>";
								}
							}
						?>	
					</table>
				</div>
			</div>
		</div>
		[:FooterBlock]
	</body>

<script type="text/javascript">

</script>



<!-- <table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">First</th>
      <th scope="col">Last</th>
      <th scope="col">Handle</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Jacob</td>
      <td>Thornton</td>
      <td>@fat</td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td colspan="2">Larry the Bird</td>
      <td>@twitter</td>
    </tr>
  </tbody>
</table> -->