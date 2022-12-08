<?php
	adminHeader("Imported Product List");
	
	$ar = array("Id", "Sku", "Name", "Description", "ShortDescription", "Price", "Category", "Image1", "Image2", "Image3","Image4");
	adminListView("ImportProduct", "Imported Product List", $ar,"","","");

	adminFooter();
?>
