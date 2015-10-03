<?php

//Variablen definieren
$pin = $_GET["pin"];
$status = $_GET["status"];
$socket = $_GET["socket"];
$stack = array(); //empty array
$xml = simplexml_load_file('gpio_config.xml');

if (isset($pin) AND isset($socket)) {
	print ("FEHLER");
} elseif (isset($pin)){
	gpio($xml, $stack, $pin, $status);

} elseif (isset($socket)) {
	socket($xml, $socket, $status);

}

//Pins der Ausnahmen in String $stack schreiben
function gpio ($xml, $stack, $pin, $status) {

foreach ($xml->portconfig as $portconfig) {
	$add = $portconfig->pin;
	array_push($stack,(int) $add);
}

//GPIO Exportieren
shell_exec('gpio export ' . $_GET["pin"] . "  out");


//Ist Pin Eine Ausnahme
if (in_array($pin, $stack)) {
	$key = array_search($pin, $stack); //Key von benötigtem Pin

	if((string)$xml->portconfig[$key]->mode['name'] == "latching") { //STROMSTOSS

		$time = (int)$xml->portconfig[$key]->mode->impuls['time'];

		shell_exec('gpio -g write ' . $_GET["pin"] . " 1");
		sleep($time);
		shell_exec('gpio -g write ' . $_GET["pin"] . " 0");
	} elseif ((string)$xml->portconfig[$key]->mode['name'] == "none") {
		
		shell_exec('gpio -g write ' . $_GET["pin"] . " " . $_GET["status"]); 
		
	} elseif ((string)$xml->portconfig[$key]->mode['name'] == "disabled") {
		
	}
	
	
} else {
	//Standard
	shell_exec('gpio -g write ' . $_GET["pin"] . " " . $_GET["status"]); 
}
}

function socket($xml, $socket, $status) {
	$home = $xml['home'];
	shell_exec('sudo raspberry-remote/send ' . $home . ' ' . $socket . ' ' . $status);
}
?>

