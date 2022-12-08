<?php
if ($movieActor==null)
{
	echo "null";
	exit;
}
$id = $movieActor->GetActorId();
if ($id==0)
{
	echo "";
	exit;
}
$actor = $website->GetActor($id);
if ($actor==null)
{
	echo "$id is not an actor";
}
else
{
	if ($actor->name == "")
		echo "{unnamed}";
	else
		echo $actor->name;
}
?>