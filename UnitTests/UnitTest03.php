<?php

phpInclude("UnitTest_check.php");

Start("03", "testing basic functions");

$str = amountAsString(1000, ".", ",", 3, "0");	
Check($str, "1.000,000", "amount (1)", "Amount as String does not have a correct conversion");

$str = amountAsString(1234567, ".", ",", 0, "0");	
Check($str, "1.234.567", "amount (2)", "Amount as String does not have a correct conversion");

$str = amountAsString(1234567.8, "*", ".", 2, "0");	
Check($str, "1*234*567.80", "amount (3)", "Amount as String does not have a correct conversion");

$str = amountAsString(1000, ",", ".", 2, "-");	
Check($str, "1,000.-", "amount (4)", "Amount as String does not have a correct conversion");

$str = stringEscapeHtml("This is a sample <b>text</b> of stringEscapeHtml");
Check($str, "This is a sample &lt;b&gt;text&lt;/b&gt; of stringEscapeHtml", "escapeHtml (1)", "stringEscapeHtml not correct");

$str = stringEscapeHtml("This is a <b style='something'>sample text</b> of stringEscapeHtml");
Check($str, "This is a &lt;b style=&apos;something&apos;&gt;sample text&lt;/b&gt; of stringEscapeHtml", "escapeHtml (2)", "stringEscapeHtml not correct");

$str = stringRemoveHtmlTags("This is a sample <b>text</b> of stringRemoveHtmlTags");
Check($str, "This is a sample text of stringRemoveHtmlTags", "remove Html (1)", "stringRemoveHtmlTags not correct");

$str = stringRemoveHtmlTags("This is a <b style='something'>sample text</b> of stringRemoveHtmlTags");
Check($str, "This is a sample text of stringRemoveHtmlTags", "remove Html (2)", "stringRemoveHtmlTags not correct");

$str = stringMakePrintable("This is:\t a sample stringMakePrintable\n");
Check($str, "This is:/09 a sample stringMakePrintable/0A", "make printable (1)", "stringMakePrintable not correct");

$str = stringReMakePrintable("This is:/09 a sample stringReMakePrintable/0A");
Check($str, "This is:\t a sample stringReMakePrintable\n", "remake printable (1)", "stringReMakePrintable not correct");

$str = stringUrlDecode("This is:\t a sample stringUrlDecode\n");
Check($str, "This is:\t a sample stringUrlDecode\n", "url decode (1)", "stringUrlDecode not correct");

$str = stringUrlSubstitute("This is-C a sample stringUrlSubstitute");
Check($str, "This is: a sample stringUrlSubstitute", "url subsctitute (1)", "stringUrlSubstitute not correct");

$str = stringUrlSetSubsitute("This is: a sample stringUrlSetSubsitute");
Check($str, "This is-C a sample stringUrlSetSubsitute", "url set substitude (1)", "stringUrlSetSubsitute not correct");

$str = stringMakeFileNameReady("This is:\t a sample stringMakeFileNameReady\n");
Check($str, "This_is___a_sample_stringMakeFileNameReady_", "make file name ready (1)", "stringMakeFileNameReady not correct");

$str1 = stringMakeRandomString(15);
$str2 = stringMakeRandomString(15);
Check($str1 != $str2, true, "random string", "stringMakeRandomString not correct");

$str1 = stringRandomWord();
$str2 = stringRandomWord();
Check($str1 != $str2, true, "random word", "stringMakeRandomString not correct");

$str1 = stringRandomPassword();
$str2 = stringRandomPassword();
Check($str1 != $str2, true, "random password", "stringRandomPassword not correct");

$str1 = stringRandomSentence();
$str2 = stringRandomSentence();
Check($str1 != $str2, true, "random sentence", "stringRandomSentence not correct");

$n1 = stringCloseness("Example", "Extern");
$n2 = stringCloseness("Example", "Nothing");
Check($n1, 2, "closeness(1)", "stringCloseness not correct");
Check($n2, 0, "closeness(2)", "stringCloseness not correct");


$d1 = stringCompareSmart("Example", "Extern");    
$d2 = stringCompareSmart("Example", "Nothing");
$d3 = stringCompareSmart("Example", "Sample");
$d4 = stringCompareSmart("Example", "Exanpel");
$d11 = stringCompareSmart("Extern", "Example");    
$d12 = stringCompareSmart("Nothing", "Example");
$d13 = stringCompareSmart("Sample", "Example");
$d14 = stringCompareSmart("Exanpel", "Example");
Check($d1 < $d2, true, "CompareSmart(1)", "stringCompareSmart not correct");
Check($d1 > $d3, true, "CompareSmart(2)", "stringCompareSmart not correct");
Check($d1 > $d4, true, "CompareSmart(3)", "stringCompareSmart not correct");
Check($d2 < $d3, true, "CompareSmart(4)", "stringCompareSmart not correct");
Check($d2 > $d4, true, "CompareSmart(5)", "stringCompareSmart not correct");
Check($d3 > $d4, true, "CompareSmart(6)", "stringCompareSmart not correct");
echo "<br/>stringCompareSmart $d1 ** $d2 ** $d3 ** $d4";
echo "<br/>stringCompareSmart2 $d11 ** $d12 ** $d13 ** $d14";

$ar = stringGetCleanWords("This is:\t a <b>sample</b> of the function stringGetCleanWords.\n");
Check(sizeof($ar), 10, "clean(1)", "stringGetCleanWords not correct");
Check($ar[0], "This", "clean(2)", "stringGetCleanWords not correct");
Check($ar[1], "is", "clean(2)", "stringGetCleanWords not correct");
Check($ar[7], "the", "clean(2)", "stringGetCleanWords not correct");

$nr = stringToNumericHash("Sample");
Check($nr, 13120578, "nrhash(1)", "stringToNumericHash not correct");

$str = stringRemoveWhiteSpaces("This is:\t a <b>sample</b> of the function stringRemoveWhiteSpaces.\n");
Check($str, "Thisis:a<b>sample</b>ofthefunctionstringRemoveWhiteSpaces.", "remove spaces91)", "stringRemoveWhiteSpaces not correct");

$str = stringMultipleTense("Book");
Check($str, "Books", "multiple (1)", "stringMultipleTense not correct");
$str = stringMultipleTense("Actress");
Check($str, "Actresses", "multiple (2)", "stringMultipleTense not correct");
$str = stringMultipleTense("Child");
Check($str, "Children", "multiple (3)", "stringMultipleTense not correct");
$str = stringMultipleTense("Wave");
Check($str, "Waves", "multiple (4)", "stringMultipleTense not correct");
$str = stringMultipleTense("Handle");
Check($str, "Handles", "multiple (5)", "stringMultipleTense not correct");
$str = stringMultipleTense("Fish");
Check($str, "Fish", "multiple (6)", "stringMultipleTense not correct");

$str = stringSingleTense("Books");
Check($str, "Book", "singular (1)", "stringSingleTense not correct");
$str = stringSingleTense("Actresses");
Check($str, "Actress", "singular (2)", "stringSingleTense not correct");
$str = stringSingleTense("Children");
Check($str, "Child", "singular (3)", "stringSingleTense not correct");
$str = stringSingleTense("Waves");
Check($str, "Wave", "singular (4)", "stringSingleTense not correct");
$str = stringSingleTense("Handles");
Check($str, "Handle", "singular (5)", "stringSingleTense not correct");
$str = stringSingleTense("Fish");
Check($str, "Fish", "singular (6)", "stringSingleTense not correct");

$str = stringCamelCaseToSpaces("MyWishList");
Check($str, "My wish list", "camel (1)", "stringCamelCaseToSpaces not correct");

$str = stringCamelCaseToSpaces("MyWishList");
Check($str, "My wish list", "camel (1)", "stringCamelCaseToSpaces not correct");

// dates
$str = incraDateFormat("12/01/20", "dd-mmm-yyyy");
Check($str, "12-jan-2020", "date format (1)", "incraDateFormat not correct");
$str = incraDateFormat(1394003958, "dd-mmm-yyyy");
Check($str, "05-mar-2014", "date format (2)", "incraDateFormat not correct");
$dateObj = mktime(0, 0, 0, 4, 1, 2014);
$str = incraDateFormat($dateObj, "dd-mmm-yyyy");
Check($str, "01-apr-2014", "date format (3)", "incraDateFormat not correct");

$dateObj = incraDateFromString("24 jan 2020");
$str = $dateObj->Format("d/m/Y");
Check($str, "24/01/2020", "date from string (1)", "incraDateFromString not correct");

$val = incraDateFromTimeString("15:28");
Check($val , 55680, "date from timestring (1)", "incraDateFromTimeString not correct");

$str = timeSpanFormat(3024, "hh:mm:ss");
Check($str, "00:50:24", "timeSpan (1)", "timeSpanFormat not correct");

$str = timeSpanFormatSmart(3024);
Check($str, "50 min", "timeSpan (2)", "timeSpanFormatSmart not correct");

$str = timeSpanFormatSmartPlus(3024);
Check($str, "50 min 24 sec", "timeSpan (3)", "timeSpanFormatSmartPlus not correct");

$l1 = timeSpanFromString("00:50:24");
Check($l1, 3024, "timeSpan (4)", "timeSpanFromString not correct");

$hex = colorToHex(128*256*256 + 64*256 + 192);
Check($hex, "#8040c0", "color (1)", "colorToHex not correct");

$name = colorToName(255*256*256 + 165*256 + 0);
Check($name, "Orange", "color (2)", "colorToName not correct");
$name = colorToName("#FFA500");
Check($name, "Orange", "color (3)", "colorToName not correct");

$l1 = colorStringToInteger("blue");
Check($l1, 255, "color (4)", "colorStringToInteger not correct");
$l1 = colorStringToInteger("#0000FF");
Check($l1, 255, "color (5", "colorStringToInteger not correct");

$col = colorDarken("#804000", 25);
Check($col, "#603000", "color (6)", "colorDarken not correct");

$col = colorBrighten("#804000", 25);
Check($col, "#a05000", "color (7)", "colorBrighten not correct");

$col = colorSaturate("#804000", 25);
Check($col, "#805020", "color (8)", "colorSaturate not correct");

$col = colorVivid("#804000", 25);
Check($col, "#803000", "color (9)", "colorVivid not correct");

$col = colorRGB(128, 64, 64);
Check($col, "#804040", "color (10)", "colorRGB not correct");


Stop();



?>