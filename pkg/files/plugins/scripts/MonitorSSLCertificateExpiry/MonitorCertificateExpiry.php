<?php
   /**
	 * Copy File from HTTPS/SSL location
	 *
	 * @param string $FromLocation
	 * @param string $ToLocation
	 * @return boolean
	 */
	 
	 //copySecureFile("http://localhost:9999/","c:\\temp");
	 
	
	$statusURL = $argv[2];
	
	function copySecureFile($FromLocation,$ToLocation,$VerifyPeer,$VerifyHost,$fileName)
	{
		
		
		
		
		
		$error_FH = fopen($fileName,"w");
		
		//$error_FH;
		// Initialize CURL with providing full https URL of the file location
		$Channel = curl_init($FromLocation);
 
		// Open file handle at the location you want to copy the file: destination path at local drive
		//$File = fopen ($ToLocation, "w");
 
		// Set CURL options
		//curl_setopt($Channel, CURLOPT_FILE, $File);
 
		// We are not sending any headers
		curl_setopt($Channel, CURLOPT_HEADER, 0);
 
 		//CURLOPT_VERBOSE
 		
 		
 		
 		
		// We are not sending any headers
		curl_setopt($Channel, CURLOPT_VERBOSE, 1);
 		
 		//CURLOPT
 		curl_setopt($Channel, CURLOPT_STDERR, $error_FH);
 
 
		// Disable PEER SSL Verification: If you are not running with SSL or if you don't have valid SSL
		curl_setopt($Channel, CURLOPT_SSL_VERIFYPEER, 0);
 
		// ENABLE HOST (the site you are sending request to) SSL Verification,
                // if Host can have certificate which is nvalid / expired / not signed by authorized CA.
		curl_setopt($Channel, CURLOPT_SSL_VERIFYHOST, 2);
		
		// Set SSL version
		curl_setopt($Channel, CURLOPT_SSLVERSION, 3);		
 
		// Execute CURL command
		curl_exec($Channel);
 		
 		//echo curl_error ( $Channel );

		//$info = curl_getinfo($Channel);
		
		//echo "INFO:".$info['ssl_verify_result'];
		
 
		// Close the CURL channel
		curl_close($Channel);

 		fclose($error_FH);
		

		// Close file handle
		//fclose($File);
 
		// return true if file download is successfull
		//return file_exists($ToLocation);
	}
 
	
	function dateDiffInDays($dateExpiry, $dateCur) {
		// Convert date/time to seconds and get the difference and then return the amount in days
		//print "\nFrom: $dateExpiry\nCurrent: $dateCur\n";
		$dateExpiry = strtotime($dateExpiry, 0);
		$dateCur = strtotime($dateCur, 0);
		$difference = $dateExpiry - $dateCur;	// Difference in seconds
		$difference = ($difference / 60 / 60 / 24);
		$difference = intval($difference);
		// Make sure there are no negative days left
		/*
		if ($difference < 0) {
			$difference = 0;
		}*/
		return $difference;
	}
	
//$configPath="c:\\";
$fileName="cert.log.".rand();



// Function Usage

//Test for Valid Certificate
//copySecureFile("https://www.verisign.com/hp07/i/vlogo.gif","c:/test25.txt",false,false,$fileName);


//debug code
//echo $argv[2];

//Test for expired certificate
$output = copySecureFile("$argv[2]","test.txt","false","false",$fileName);



$fh = fopen($fileName, "r");

$expiryFound = false;
$error = "";
while(true)
{
	$line = fgets($fh);
	if($line == null)break;

	// Look for "expire date"
	if(stristr($line, 'expire date' ) != FALSE) {
		$expiryDate	= date('Y-m-d H:i:s T', strtotime(substr($line, 17)));
		$expiryFound = true;
	}
	// Look for "error"
	if(stristr($line, 'error' ) != FALSE) {
		$error = substr($line, 2);
	}
	// Look for "Could not"
	if(stristr($line, 'could not' ) != FALSE) {
		$error = substr($line, 2);
	}
}
fclose($fh);

// Output the number of days left in the expiry date
if ($expiryFound) {
	$curDate	= date('Y-m-d H:i:s T', strtotime("now"));
	echo "expirydays " . dateDiffInDays($expiryDate, $curDate) . "\n";
}
else {
	echo "expirydays 0\n";
}
// Output any errors (if any)
if (strlen($error) == 0) {$error = "OK";}
echo "msg " . trim($error) . "\n";

unlink($fileName);

?>
