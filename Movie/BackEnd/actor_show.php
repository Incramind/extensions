<?php
// all is done, we can now display the form
adminHeader("Actor info");
callTemplate("<div class=\"columns \">");
adminViewSideHead("TypesTable", "Add a new Actor", "Actor");
adminViewAddTab(true, "General info", "Basic information");
adminViewSideFooter();
callTemplate("<div class=\"main-col\" id=\"content\">");
adminViewMainColumn("Actor", "[Actor.Name]");

adminViewEditHeader("Actor", $isAdd);
adminViewTabHeader("General info", true);
adminViewFieldInputString("Actor", "Name", "Name");
adminViewFieldInputEnum("GenderType", "Actor", "Gender", "Gender");
adminViewFieldInputImage("Actor", "Image", "Image");
adminViewFieldInputArea("Actor", "Bio", "Bio info", 60, 20);
adminViewTabFooter();
adminViewEditFooter("Actor");

callTemplate("</div></div>");
callTemplate("</div></div>");
adminFooter();
?>

