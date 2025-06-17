<?php 

	/* Application name */
	define('APP_NAME', 'Medical Management System');
	
	/* Base URL (for API or links, if needed */
	define('BASE_URL', 'http://localhost/mms');
	
	/* Directory paths (if needed for upload/logs/... */
	define('UPLOADS_DIR', __DIR__ . '/../public/upload/');
	define('LOGS_DIR', __DIR__ . '/../storage/logs/');
	
	/* User Roles */
	define('ROLE_ADMIN', 'admin');
	define('ROLE_DOCTOR', 'doctor');
	define('ROLE_NURSE', 'nurse');
	define('ROLE_RECEPTIONIST', 'receptionist');
	define('ROLE_LAB_TECHNICIAN', 'lab_technician');
	define('ROLE_USER', 'user');
	
	/* Appointment Status */
	define('STATUS_SCHEDULED', 'Scheduled');
	define('STATUS_CHECKED_IN', 'Checked-In');
	define('STATUS_CANCELLED', 'Cancelled');
	define('STATUS_NO_SHOW', 'No-Show');
	
	/* Test Status */
	define('TEST_PENDING', 'Pending');
	define('TEST_IN_PROGRESS', 'In Progress');
	define('TEST_COMPLETED', 'Completed');
	define('TEST_FAILED', 'Failed');
	define('TEST_CANCELLED', 'Cancelled');
	
	/* Payment Status */
	define('PAYMENT_PAID', 'Paid');
	define('PAYMENT_PARTIALLY_PAID', 'Partially Paid');
	define('PAYMENT_PENDING', 'Pending');
	define('PAYMENT_OVERDUE', 'Overdue');
	define('PAYMENT_REFERENCE', 'Refunded');
	
	/* Insurance Status */
	define('INSURANCE_APPROVED', 'Approved');
	define('INSURANCE_PENDING', 'Pending');
	define('INSURANCE_DENIED', 'Denied');
	define('INSURANCE_NA', 'Not Applicable');
	
	/* Default pagination size */
	define('DEFAULT_PAGE_SIZE', 2O);
	
	/* Timezone */
	date_default_timezone_set('UTC');
	
	