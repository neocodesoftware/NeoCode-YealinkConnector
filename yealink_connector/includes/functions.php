<?php
/**
 * Yealink Functions
 *
 * Miscellaneous functions for the connector application
 *
 * @Author Neo Code
 * @Version 1.0
 * @Created April 2017
 *
 */

/**
 * @return array of IPv4 addresses
 */
function getIPaddresses() {
	// determine OS
	if ( substr( php_uname(), 0, 7 ) == "Windows" ) {
		$return = getWinIP();
	} else {
		// assume Mac OS as that is the only other case I'm coding for
		$return = getMacIP();
	}
	return $return;
}

/**
 * getWinIP
 *
 * Run ipconfig command to get the IPv4 addresses of the machine
 *
 * @return array of IPv4 addresses
 */
function getWinIP() {
	// run ipconfig command
	$config = shell_exec('ipconfig');

	// split command string result into an array with one line per array entry
	$lines = explode("\n", $config);

	// find the lines with the IPv4 address entries
	$lines = array_filter($lines, 'filterIP');

	// find the IP address from each record
	$return = array();
	foreach ($lines as $line) {
		if ( preg_match('/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/', $line, $ip_match) ) {
			$return[] = $ip_match[0];
		}
	}

	return $return;
}

/**
 * filterIP
 *
 * Callback function for array_filter function. Looks for 'IPv4 Address' string that are not autoconfigure addresses.
 *
 * @param $line
 *
 * @return bool
 */
function filterIP( $line ) {
	// find the records with "IPv4" addresses
	$pos = strpos( $line, 'IPv4 Address');

	// discard records without 'IPv4 Address'
	if ( $pos === false ) {
		return false;
	} else {
		// eliminate autoconfigure IPs
		$pos_a = strpos( $line, 'Autoconfiguration');
		if ( $pos_a === false ) {
			return $line;
		} else {
			return false;
		}
	}
}

/**
 * getMacIP
 *
 * Run an ifconfig command to get the IPv4 addresses of the machine
 *
 * @return array of IPv4 addresses
 */
function getMacIP() {
    // run a command to get a string of IPv4 addresses
	$result = shell_exec('ifconfig | grep "inet " | grep -v "127.0.0.1" | cut -d " " -f 2');

	// convert string to an array
	$return = explode(PHP_EOL, $result);

	// remove empty entry that seems to be at the end of the array
	$return = array_filter($return);

	return $return;
}