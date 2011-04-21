Blowhash
========
 
Blowhash uses bcrypt, a strong adaptive algorithm, to securely hash
passwords. It uses the native `bcrypt` implementation found in PHP 5.3.

Blowhash is named after the Blowfish cipher on which `bcrypt` is based.


Why Blowhash uses `bcrypt`
--------------------------

`bcrypt` is currently the best choice for password hashing. It is

 * cryptographically "slow", which makes it strong against brute force;
 * adaptive, meaning that its computation cost can be specified and stretched;
 * individually salted, which makes it immune to rainbow table attacks.
 
MD5, for instance, satisfies *none* of the above without extra help. That's how bad it is.

PHP 5.3 and up provides a native `bcrypt` implementation (as part of the `crypt`
function). There is no longer any reason to use any other hashing scheme.


Comparison to `phpass`
----------------------

The Blowhash class is loosely based on `phpass`, a high quality password hashing library, with the following modifications:

 - Use of the native bcrypt algorithm only (introduced in PHP 5.3).
 - Removal of fallback portable hash implementations.
 - Replacement of the base64 function with the native PHP version.
 - Replacement of the random bytes generator with a faster solution.

As a result, Blowhash has significantly less overhead than `phpass` while keeping the same power.


Using Blowhash
--------------

Use the `hashPassword` method when a password is first created to obtain a 60-character hash string.

When validating a login attempt, retrieve the hash string and use the `checkPassword` method. It will return true if the hashes match, indicating that the password is valid.

Usage:

```php
// Hash a password: returns a 60-character string.
$blowhash = new Blowhash();
$hash = $blowhash->hashPassword($password);
```

```php
// Check a password: the result is a boolean.
$isValid = $blowhash->checkPassword($hash, $input);
```


Authors
-------

Blowhash is (c) 2011 @marekweb


