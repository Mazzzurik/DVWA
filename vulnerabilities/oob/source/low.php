<?php

$html = "";
$html .= "<p>Hello and welcome to the vulnerability.</p>";

if (array_key_exists ("HTTP_REFERER", $_SERVER)) {
	$referrer = $_SERVER['HTTP_REFERER'];
	# var_dump ($referrer);

	# Can't use file_get_contents as it doesn't handle redirects well in all cases
	# $body = file_get_contents($referrer);

	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_RETURNTRANSFER => 1, # Return the HTML page
		CURLOPT_URL => $referrer, # The URl
		CURLOPT_FOLLOWLOCATION => TRUE, # Follow redirects
		CURLOPT_SSL_VERIFYHOST => 0, # Ignore SSL certificates
		CURLOPT_SSL_VERIFYPEER => 0, # Ignore SSL certificates
		CURLOPT_USERAGENT => 'Mozilla/5.0' # User agent string
	));
	$body = curl_exec($curl);
	# var_dump ($body);

	if ($body !== false) {
		$dom = new DOMDocument();
		# Mutes any warnings from invalid HTML pages
		libxml_use_internal_errors(true);
		$dom->loadHTML($body);
		$xpath = new DOMXpath($dom);
		$title = $xpath->query('/html/head/title');
		# var_dump ($title);
		if ($title !== false && !is_null ($title) && $title->length > 0) {
			$html .= "<p>You came from: <a href='" . $referrer . "'>" . $title[0]->nodeValue . "</a></p>";
		}
	}
}
?>
