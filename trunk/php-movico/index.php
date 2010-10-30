<?
require_once("path.php");
require_once("lib/error/runtime-errors.php");

set_exception_handler("handleException");
set_error_handler("handleError", E_ALL);

$view = Singleton::create("ActionController")->perform($_POST);
print Singleton::create("ViewRenderer")->render($view);
?>