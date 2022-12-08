<?php
if ($movieReview==null)
{
	echo "null";
	exit;
}
$id = $movieReview->GetCriticId();
if ($id==0)
{
	echo "";
	exit;
}
$critic = $website->GetCritic($id);
if ($critic==null)
{
	echo "$id is not a critic";
}
else
{
	if ($critic->name == "")
		echo "{unnamed}";
	else
		echo $critic->name;
}
?>