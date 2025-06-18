<?php

	class Database {
		private static $conn = null;
		
		public static function getConnection() {
			if (self::$conn === null) {
				$env = require __DIR__ . '/env.php';
				
				try {
					self::$conn = new PDO (
						"mysql:host={$env['DB_HOST']}; dbname={$env['DB_NAME']};charset=utf8mb4",
						$env['DB_USER'],
						$env['DB_PASS']
					);
					self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				} catch (PDOException $e) {
					http_response_code(500);
					echo json_encode(['error' => 'DB error','details' => $e->getMessage()]);
					exit();
				}
			}
			return self::$conn;
		}
	}
?>
