<?php
class ErrorPrinter {
	
	public static function printError($type, $msg, $file, $line, $context) {
		ini_set("display_errors", 0);
		$errorType = self::getErrorType($type);
		return <<<ERR
<html>
	<head>
		<title>
			An unexpected error occurred. Please contact your administrator.
		</title>
		<style type="text/css">
			#errors {
				border: 1px solid red;
				background: #FFD9D9;
				padding: 15px;
				font: 12px Tahoma;	
				color: gray;			
			}
			
			#message {
				color: red;
				font-weight: bold;
			}
		</style>
	</head>
	<body>
		<div id="errors">
			<span id="message"><u>$errorType</u>: $msg!</span><br/>
			Occured in <b>$file</b> on line <b>$line</b>.
		</div>
	</body>
</html>
ERR;
	}

	private static function getErrorType($errorNo) {
		$errorTypes = array(
			E_ERROR => "Error",
			E_WARNING => "Warning",
			E_PARSE => "Parse error",
			E_NOTICE => "Notice",
			E_CORE_ERROR => "Core error",
			E_CORE_WARNING => "Core warning",
			E_COMPILE_ERROR => "Compile error",
			E_COMPILE_WARNING => "Compile warning",
			E_USER_ERROR => "Error",
			E_USER_WARNING => "Warning",
			E_USER_NOTICE => "Notice",
			E_STRICT => "Suggestion",
			E_RECOVERABLE_ERROR => "Recoverable error",
			E_DEPRECATED => "Deprecated",
			E_USER_DEPRECATED => "Deprecated");
		return $errorTypes[$errorNo];
	}
		
}
?>