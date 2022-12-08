<?php
	setMvcEvent("importProduct_list", "admin", "ImportProduct", "list");
	setMvcEvent("importProduct_listupdate", "admin", "ImportProduct", "listupdate");
	setMvcEvent("importProduct_view", "admin", "ImportProduct", "view");
	setMvcEvent("importProduct_show", "admin", "ImportProduct", "show");
	
    CreateTableDefinitions();
	
	
    function CreateTableDefinitions()
    {
        customTableCreate("ImportProduct", "", "Imported products list", "ImportProducts", "Blog");
        customTableAddField("ImportProduct", "Sku", REPLACER_TYPE_STRING, "Imported product stock keeping unit",);
        customTableAddField("ImportProduct", "Name", REPLACER_TYPE_STRING, "Imported product name",);
        customTableAddField("ImportProduct", "Description", REPLACER_TYPE_STRING, "Imported product description",);
        customTableAddField("ImportProduct", "ShortDescription", REPLACER_TYPE_STRING, "Imported product short description",);
        customTableAddField("ImportProduct", "Price", REPLACER_TYPE_AMOUNT, "Imported product price",);
        customTableAddField("ImportProduct", "Category", REPLACER_TYPE_STRING, "Imported Category",);
		// we can have max 4 images (for now)
        customTableAddField("ImportProduct", "Image1", REPLACER_TYPE_STRING, "first imported image",);
        customTableAddField("ImportProduct", "Image2", REPLACER_TYPE_STRING, "second imported image",);
        customTableAddField("ImportProduct", "Image3", REPLACER_TYPE_STRING, "third imported image",);
        customTableAddField("ImportProduct", "Image4", REPLACER_TYPE_STRING, "fourth imported image",);
    }
	
?>