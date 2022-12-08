<?php
	// all is done, we can now display the form
	adminHeader("Imported Product file info");
	callTemplate("<div class=\"columns \">");
	adminViewSideHead("ImportProduct", "Imported Product", "Imported Product");
	adminViewAddTab(true, "General info", "Basic information of the Imported Product");
	adminViewSideFooter();
	callTemplate("<div class=\"main-col\" id=\"content\">");
	adminViewMainColumn("ImportProduct", "[ImportProduct.name]");

	adminViewEditHeader("ImportProduct", $isAdd);
	adminViewTabHeader("General info", true);
	adminViewFieldInputString("ImportProduct", "Sku", "Sku");
	adminViewFieldInputString("ImportProduct", "Name", "Name");
	adminViewFieldInputString("ImportProduct", "Description", "Description");
	adminViewFieldInputString("ImportProduct", "ShortDescription", "Short Description");
	adminViewFieldInputAmount("ImportProduct", "Price", "Price");
	adminViewFieldInputString("ImportProduct", "Category", "Category");
	adminViewFieldInputString("ImportProduct", "Image1", "Image1");
	adminViewFieldInputString("ImportProduct", "Image2", "Image2");
	adminViewFieldInputString("ImportProduct", "Image3", "Image3");
	adminViewFieldInputString("ImportProduct", "Image4", "Image4");
	adminViewTabFooter();

	adminViewEditFooter("ImportProduct");

	callTemplate("</div></div>");
	callTemplate("</div></div>");
	adminFooter();
?>