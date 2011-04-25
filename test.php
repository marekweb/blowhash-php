<?php
/**
 * Tests for Blowhash.
 *
 * (c) 2011 @marekweb
 *
 */

header('Content-type: text/plain');

require 'Blowhash.php';

$hasher = new Blowhash(8);

$ok = 0;

for ($i = 0; $i < 3; $i++) {

	$correct = 'test12345';
	$hash = $hasher->hashPassword($correct);

	print 'Hash: ' . $hash . "\n";

	$check = $hasher->checkPassword($correct, $hash);
	if ($check) $ok++;
	print "Check correct: '" . $check . "' (should be '1')\n";

	$wrong = 'test12346';
	$check = $hasher->CheckPassword($wrong, $hash);
	if (!$check) $ok++;
	print "Check wrong: '" . $check . "' (should be '0' or '')\n";
	
	print "\n";
	
}
printf("Passed %d/%d\n", $ok, 6);
if ($ok == 6)
	print "All tests have PASSED\n";
else
	print "Some tests have FAILED\n";

?>
