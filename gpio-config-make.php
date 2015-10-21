<?php

//VARIABLEN
$action = $_REQUEST['action'];
$key = (int)$_REQUEST['key'];
$home = (int)$_REQUEST['home'];
$pin = $_REQUEST['pin'];
$mode = $_REQUEST['mode'];
$wert = $_REQUEST['wert'];
$name = $_REQUEST['name'];

//XML Importieren
$xml = simplexml_load_file('gpio_config.xml');

//Änderung oder Neu IF
if ($action == "change") {
	change($xml, $key, $pin,$mode, $wert, $name);
} elseif ($action == "new") {
	neu($xml, $key, $pin,$mode, $wert, $name);
} elseif ($action == "delete") {
	delete($xml, $key);
} elseif ($action == "home") {
	home($xml, $home);
}


function change ($xml, $key, $pin, $mode, $wert, $name) {
  //VARIABLEN XML
  $xml_pin = (int)$xml->portconfig[$key]->pin;
  $xml_mode = (string)$xml->portconfig[$key]->mode['name'];
  $xml_wert = (int)$xml->portconfig[$key]->mode->impuls['time'];
  $xml_name = (string)$xml->portconfig[$key]->pin['name'];


  //VERGLEICHEN; bei != überschreiben MODUS
  if ($xml_mode == $mode) {
	$status1=True;
  } else {
	$xml->portconfig[$key]->mode['name'] = $mode;
	$status1=False;
  }
  
  //VERGLEICHEN; bei != überschreiben WERT
  if ($xml_wert == $wert){
	$status2=True;
  } else {
	$xml->portconfig[$key]->mode->impuls['time'] = $wert;
	$status2=False; 
  }
  if ($xml_name == $name){
	$status3=True;
  } else {
	$xml->portconfig[$key]->pin['name'] = $name;
	$status3=False; 
  }
  
  //If Soll geschrieben werden?
  if ($status1 == False or $status2 == False or $status3 == False){
	$xml->AsXML("gpio_config.xml"); 
	$headerdata = "msg=00";
  } else {
	$headerdata = "msg=1";  
  }
  header('Location: gpio-config.php?'.$headerdata);
}

function neu ($xml, $key, $pin,$mode, $wert, $name) {
  
  $portconfig = $xml->addChild('portconfig'); //PortConfig wird erstellt
  $portconfig->addChild('pin',$pin); //Pin wird erstellt & mit Pin gefüllt
  $portconfig->pin->addAttribute('name', $name);
  $portconfig->addChild('mode'); //mode wird erstellt
  $portconfig->mode->addAttribute('name',$mode); //mode bekommt Modus zugewiesen
  $portconfig->mode->addChild('impuls'); //Impuls wird erstellt
  $portconfig->mode->impuls->addAttribute('time',$wert); //Implus bekommt Zeit zugewiesen
  $xml->AsXML("gpio_config.xml"); //Datei wird beschrieben
  $headerdata = "msg=2";
  header('Location: gpio-config.php?'.$headerdata);
}

function delete ($xml, $key) {
	$portconfig = $xml->portconfig[$key];
	$dom=dom_import_simplexml($portconfig);
	$dom->parentNode->removeChild($dom);
	$xml->AsXML("gpio_config.xml"); 
	$headerdata = "msg=4";
	header('Location: gpio-config.php?'.$headerdata);
	
}

function home ($xml, $home) {
	$xml_home = (int)$xml['home'];
	if ($xml_home == $home) {
		$headerdata = "msg=1";
	} else {
		$xml['home'] = $home;
		$xml->AsXML("gpio_config.xml");
		$headerdata = "msg=00";		
	}
	header('Location: gpio-config.php?'.$headerdata);
}

?>
