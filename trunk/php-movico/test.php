<?
require_once("path.php");
session_start();

require_once("lib/error/runtime-errors.php");

set_exception_handler("handleException");
set_error_handler("handleError", E_ALL^E_NOTICE);

require_once("lib/simpletest/autorun.php");

// String tests
new StringContainsTest();
new StringStartsWithTest();
new StringEndsWithTest();
new StringLengthTest();
new StringSplitTest();
new StringMatchesTest();
new StringCompareTest();
new StringReplaceTest();
new StringRemoveTest();
new StringIndexOfTest();
new StringIndexesOfTest();

// ArrayList tests
new ListAddElementTest();
new ListGetElementTest();
new ListJoinElementsTest();
new ListContainsTest();
new ListGetSublistTest();
new ListIteratorTest();
new ListSortTest();
new ListToStringTest();
new ListIndexesOfTest();

// HashSet tests
new SetAddElementTest();

// HashMap tests
new MapPutElementTest();
new MapGetElementTest();
new MapIteratorTest();
new MapToStringTest();

// TypeUtil tests
new IsObjectTypeTest();
new IsPrimitiveTypeTest();
new IsComparableTest();

// Boggle tests
new WordIsPossibleInLayoutTest();
new BoggleGridIndicesTest();
?>