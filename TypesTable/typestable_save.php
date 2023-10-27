<?php
// this event is registered in the Save for movie. It will do the actual updating of the data
// then redirecting back to the list

if ($_POST["id"] == 0)
{
	if (!hasCreateRights("TypesTable"))
	{
		notification(NotificationType_Violation, "user is not logged in or not allowed to add a TypesTable record");
		setPageReturn(ProcessUrl_Error);
		exit;
	}
}
else
{
	if (!hasUpdateRights("TypesTable"))
	{
		notification(NotificationType_Violation, "user is not logged in or not allowed to add a TypesTable record");
		setPageReturn(ProcessUrl_Error);
		exit;
	}
}

postDump();

$tt = NULL;
if ($_POST["id"] == 0)
{
	$tt = new TypesTable();
	$website->AddTypesSample($tt);
}
else
{
	$tt = $website->GetTypesSample($_POST["id"]);
}
$tt->SetExtraBool($_POST["extra_bool"]);
$tt->SetExtraLong($_POST["extra_long"]);
$tt->SetExtraDouble($_POST["extra_double"]);
$tt->SetExtraString($_POST["extra_string"]);
$tt->SetExtraDate($_POST["extra_date"]);
$tt->SetExtraDateTime($_POST["extra_date_time"]);
$tt->SetExtraTime($_POST["extra_time"]);
$tt->SetExtraTimeSpan($_POST["extra_time_span"]);
$tt->SetExtraColor($_POST["extra_color"]);
$tt->SetExtraAmount($_POST["extra_amount"]);
$tt->SetExtraStoreViewString($_POST["extra_store_view_string"]);
$tt->SetExtraReference($_POST["extra_reference"]);
$tt->SetExtraEnum($_POST["extra_enum"]);

if ($_POST["id"] == 0)
	notification(NotificationType_Notify, "TypesTable record added");
else
	notification(NotificationType_Notify, "TypesTable record updated");



//redirect("admin", "TypesTable/list");

?>