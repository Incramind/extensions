<?php

$testCnt = 0;
$testFailed = 0;
$nrLogsBegin = 0;

function Start($testNr, $testName)
{
	global $testCnt;
	global $testFailed;
	global $nrLogsBegin;
	
	$ar = incraLogGetLastLoggings(4);
	$nrLogsBegin = sizeof($ar);
	
	$testCnt = 0;
	$testFailed = 0;
	echo "<h3>$testNr $testName</h3>";
	echo "Starting testing: $testName<br/>";
	echo "<table><tr><th>Code</th><th>Result</th><th>Description</th></tr>";
}

function Check($val1, $val2, $code, $description)
{
	global $testCnt;
	global $testFailed;
	
	$testCnt++;
	if ($val1 == $val2)
	{
		echo "<tr><td>$code</td><td>OK</td></tr>";
	}
	else
	{
		echo "<tr><td>$code</td><td><b>Error</b></td><td>$description</td></tr>";
		$testFailed++;
	}
}

function Stop()
{
	global $testCnt;
	global $testFailed;
	global $nrLogsBegin;
	
	$ar = incraLogGetLastLoggings(4);
	$nrLogsAfter = sizeof($ar);
	Check($nrLogsBegin, $nrLogsAfter, "syntax", "some syntax errors where thrown while executing");
	
	
	echo "</table>";
	echo "<br/>$testCnt tests done.<br/>";
	if ($testFailed>0)
	{
		echo "<b>$testFailed tests have failed.</b><br/>";
	}
}


?>