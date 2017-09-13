<?php
function cfgSET($bgjiieeead) {
	$cedbbcjhba = mysql_fetch_array( mysql_query( 'SELECT * FROM `settings` WHERE cfgname = \'' . $bgjiieeead . '\' LIMIT 1' ) );
	return $cedbbcjhba['data'];
}


if (!( defined( 'ACCESS' ))) {
	exit(  );
	(bool)true;
}

$cfgLiberty = $adminmail = $key2 = 'Z201OlC1985';
$cfgPerfect = cfgSET( 'cfgPerfect' );
$cfgPAYEE_NAME = cfgSET( 'cfgPAYEE_NAME' );
$cfgLRsecword = cfgSET( 'cfgLRsecword' );
$ALTERNATE_PHRASE_HASH = cfgSET( 'ALTERNATE_PHRASE_HASH' );
$cfgAutoPay = cfgSET( 'cfgAutoPay' );
$cfgPMID = cfgSET( 'cfgPMID' );
$cfgPMpass = cfgSET( 'cfgPMpass' );
$cfgMinOut = cfgSET( 'cfgMinOut' );
$adminmail = cfgSET( 'adminmail' );
$cfgPercentOut = cfgSET( 'cfgPercentOut' );

?>
