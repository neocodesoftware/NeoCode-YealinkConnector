<?php
/**
 * Yealink Call Event Forwarder
 *
 * Receive information from phone as content type "text/xml". Parse out data and forward to
 * FileMaker client using fmp protocol (https://www.filemaker.com/help/14/fmp/en/html/sharing_data.17.6.html).
 *
 * @Author Neo Code
 * @Version 1.0
 * @Created March 2017
 *
 */

// define constants
define( 'ROOT_PATH', dirname( __FILE__ ) );
define( 'LOG_PATH', ROOT_PATH . '/log/' );
define( 'FM_URL', 'fmp://$/' );

// load configuration
// ------------------
// expect 2 values:
//  - FM_database_file
//  - FM_script_name
$config_json = file_get_contents( ROOT_PATH . '/config.json' );
$config      = json_decode( $config_json );

// include vendor classes for logging
require ROOT_PATH . '/vendor/Psr/Log/LoggerInterface.php';
require ROOT_PATH . '/vendor/Psr/Log/AbstractLogger.php';
require ROOT_PATH . '/vendor/Psr/Log/LogLevel.php';
require ROOT_PATH . '/vendor/KLogger/Logger.php';

// initialize logging
// ------------------
// logging level - set as needed
//  - Psr\Log\LogLevel::NOTICE;  // no app logging
//  - Psr\Log\LogLevel::INFO;    // INFO logging only
//  - Psr\Log\LogLevel::DEBUG;   // INFO & DEBUG logging
$logger = new \Katzgrau\KLogger\Logger( LOG_PATH, Psr\Log\LogLevel::INFO );
$logger->info( 'New call event from ' . $_SERVER['REMOTE_ADDR'] );

$logger->debug( print_r( $_REQUEST, true ) );
$logger->debug( print_r( $_SERVER, true ) );

if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {
	if (
		isset( $_GET['e'] ) &&
		isset( $_GET['mac'] ) &&
		isset( $_GET['ip'] ) &&
		isset( $_GET['cid'] ) &&
		isset( $_GET['dr'] ) &&
		isset( $_GET['lcl'] ) &&
		isset( $_GET['rmt'] )
	) {
		$event        = $_GET['e'];
		$mac          = $_GET['mac'];
		$phone_ip     = $_GET['ip'];
		$call_uid     = $_GET['cid'];
		$call_display = $_GET['dr'];
		$called_sip   = $_GET['lcl'];
		$calling_sip  = $_GET['rmt'];

		// Parse out phone #
		$pattern     = '/[:@]/';
		$wk          = preg_split( $pattern, $calling_sip );
		$calling_num = ( isset( $wk[1] ) ? $wk[1] : 'unknown' );

		// validate event
		switch ( $event ) {
			case 'ic':
				// Incoming call event
				$event_text = 'Incoming Call';
				break;
			case 'term':
				// Terminated call event
				$event_text = 'Call Terminated';
				break;
			case 'mis':
				// Missed call event
				$event_text = 'Missed Call';
				break;
			case 'rejic':
				// Incoming call rejected event
				$event_text = 'Call Rejected';
				break;
			case 'ansic':
				// Incoming call answered eent
				$event_text = 'Call Answered';
				break;
			default:
				// Unknown event - ignore.
				$event_text = 'Unknown';
		}

		$logger->info(
			'Event: ' . $event . ' (' . $event_text . ')' .
			' Call ID: ' . $call_uid .
			' From: ' . $calling_num . ' (' . $call_display . ')'
		);

		// Must be known event
		if ( $event_text != 'Unknown' ) {
			// create URL string to call FM
			$url = FM_URL . $config->FM_database_file . '?' .
			       'script=' . $config->FM_script_name . '&' .
			       'param=' . $event . '&' .
			       '$PhoneMAC=' . rawurlencode( $mac ) . '&' .
			       '$PhoneIP=' . rawurlencode( $phone_ip ) . '&' .
			       '$CallUID=' . rawurlencode( $call_uid ) . '&' .
			       '$CallDisplay=' . rawurlencode( $call_display ) . '&' .
			       '$CallingNum=' . rawurlencode( $calling_num ) . '&' .
			       '$CalledSIP=' . rawurlencode( $called_sip );
			$logger->debug( $url );

			//Run OS command to call FM
			if ( substr( php_uname(), 0, 7 ) == "Windows" ) {
				// run explorer.exe on Windows to connect to FileMaker Pro
				$cmd = 'C:\Windows\explorer.exe "' . $url . '"';
				$logger->info( 'FM Called (Win)' );

			} else {
				// assume Mac OS as that is the only other OS for FileMaker Pro
				$cmd = 'open \'' . $url . '\'';
				$logger->info( 'FM Called (Mac)' );
			}

			$logger->debug( $cmd );
			exec( $cmd );
		}

		// leave quietly
		exit( 0 );
	}
}