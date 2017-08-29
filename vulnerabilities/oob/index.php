<?php

define( 'DVWA_WEB_PAGE_TO_ROOT', '../../' );
require_once DVWA_WEB_PAGE_TO_ROOT . 'dvwa/includes/dvwaPage.inc.php';

dvwaPageStartup( array( 'authenticated', 'phpids' ) );

$page = dvwaPageNewGrab();
$page[ 'title' ]   = 'Vulnerability: Out-of-Band attacks (OOB)' . $page[ 'title_separator' ].$page[ 'title' ];
$page[ 'page_id' ] = 'oob';
$page[ 'help_button' ]   = 'oob';
$page[ 'source_button' ] = 'oob';

dvwaDatabaseConnect();

$vulnerabilityFile = '';
switch( $_COOKIE[ 'security' ] ) {
	case 'low':
		$vulnerabilityFile = 'low.php';
		break;
	case 'medium':
		$vulnerabilityFile = 'medium.php';
		break;
	case 'high':
		$vulnerabilityFile = 'high.php';
		break;
	default:
		$vulnerabilityFile = 'impossible.php';
		break;
}

require_once DVWA_WEB_PAGE_TO_ROOT . "vulnerabilities/oob/source/{$vulnerabilityFile}";

# For the impossible level, don't decode the querystring
$decodeURI = "decodeURI";
if ($vulnerabilityFile == 'impossible.php') {
	$decodeURI = "";
}

$page[ 'body' ] = <<<EOF
<div class="body_padded">
	<h1>Vulnerability: Out of Band</h1>

	<div class="vulnerable_code_area">
EOF;
$page[ 'body' ] .= $html;
 
$page[ 'body' ] .= <<<EOF
	</div>
EOF;

$page[ 'body' ] .= "
	<h2>More Information</h2>
	<ul>
		<li>" . dvwaExternalLinkUrlGet( 'https://www.owasp.org/index.php/Cross-site_Scripting_(XSS)' ) . "</li>
		<li>" . dvwaExternalLinkUrlGet( 'https://www.owasp.org/index.php/Testing_for_DOM-based_Cross_site_scripting_(OTG-CLIENT-001)' ) . "</li>
		<li>" . dvwaExternalLinkUrlGet( 'https://www.acunetix.com/blog/articles/dom-xss-explained/' ) . "</li>
	</ul>
</div>\n";

dvwaHtmlEcho( $page );

?>
