<?php
/**
 * Blowhash: Strong PHP password hashing. For PHP 5.3 and up.
 *
 * (c) 2011 @marekweb
 *
 * The author(s) provide the software as-is without any warranties and accept
 * no liabilities resulting from its use.
 *
 */
/**
 * Blowhash bcrypt password hasher.
 */
class Blowhash {

	private $cost;
	
	/**
	 * Create an instance with a given cost factor. Cost is log2 iterations. The
	 * portable parameter is ignored, and is only provided for phpass
	 * interface compatibility.
	 */
	public function __construct($cost = 8, $portable = FALSE) {
		$this->cost = min(31, max(4, $cost));
	}

	/**
	 * Hash a password with bcrypt. Returns a 60-character string which
	 * includes the salt, or false if hashing failed.
	 */
	public function hashPassword($password) {
		$hash = crypt($password, $this->generateSalt());
		if (strlen($hash) == 60) {
			return $hash;
		} else {
			return false;
		}
	}

	/**
	 * Check the password against the stored hash.
	 */
	public function checkPassword($password, $storedHash) {
		return crypt($password, $storedHash) === $storedHash;
	}

	/**
	 * Generate random bcrypt salt (with $2a header), 22 characters in length.
	 */
	private function generateSalt() {
		// 1. Generate a 16-byte binary md5 hash based on the microsecond time.
		// 2. Base-64 encode it, using the bcrypt alphabet "./0-9A-Za-z".
		// 3. Use the first 22 characters (of 24 produced by the encoding).
		$salt = substr(strtr(base64_encode(md5(microtime(), 1)), '+', '.'), 0, 22);
		// The bcrypt salt format: $2a$xx$yyyyyyyyyyyyyyyyyyyyyy (29 characters)
		// Where 2a is the bcrypt identifier, x is the cost factor in decimal,
		// and y is a salt value in "./0-9A-Za-z"
		$hash = '$2a$' . sprintf('%02d', $this->cost) . '$' . $salt;
		return $hash;
	}
}