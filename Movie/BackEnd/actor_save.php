<?php
// this event is registered in the Save for movie. It will do the actual updating of the data
// then redirecting back to the list

if ($_POST["id"] == 0)
{
	if (!hasCreateRights("Actor"))
	{
		notification(NotificationType_Violation, "user is not logged in or not allowed to add an actor");
		setPageReturn(ProcessUrl_Error);
		exit;
	}
}
else
{
	if (!hasUpdateRights("Actor"))
	{
		notification(NotificationType_Violation, "user is not logged in or not allowed to add an actor");
		setPageReturn(ProcessUrl_Error);
		exit;
	}
}


$actor = NULL;
// if there is no ID, we have an ADD and we will create a new record. Otherwise we look it up.
if ($_POST["id"] == 0)
{
	$actor = new Actor();
}
else
{
	$actor = $website->GetActor($_POST["id"]);
}

// we set all the properties of the record with the values of the post
// note that the post have small letters
$actor->SetName($_POST["name"]);
$actor->SetGender($_POST["gender"]);
$actor->SetImage($_POST["image"]);
$actor->SetBio($_POST["bio"]);

// to check and print the values of  the post, you can use this dump. but comment the last redirect line also
//postDump();

if ($_POST["id"] == 0)
{
	notification(NotificationType_Notify, "Actor added");
	$website->AddActor($actor);
}
else
{
	notification(NotificationType_Notify, "Actor updated");
}

if (isset($saveAndContinue))
{
	redirect("Admin", "actor/view/".$actor->GetId());
}
else
{
	redirect("Admin", "actor/list");
}


?>