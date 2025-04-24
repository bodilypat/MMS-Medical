<?php
	function logError($message) {
		error_log("[" .data('Y-m-d H:i:s') . "] $message\n", 3, __DIR__.'/../logs/error.log');
	}
	