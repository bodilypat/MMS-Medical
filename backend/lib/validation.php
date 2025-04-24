<?php
	function validateEmail($email) {
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}
	function sanitize($input) {
		return htmlspecialchars(strip_tags($input));
	}
	