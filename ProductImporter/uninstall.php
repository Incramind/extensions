<?php

	removeMvcEvent("importProduct_list");
	removeMvcEvent("importProduct_listupdate");
	removeMvcEvent("importProduct_view");
	removeMvcEvent("importProduct_show");

	customTableDelete("ImportProduct");


?>
