#!/usr/bin/perl

$file = '/var/log/auth.log';
open(FH, $file) or die ("File Not Found");

$count = 0;

while(<FH>) {
	$count++ if /pam_unix\(sudo:session\): session opened/;
}

print $count;
