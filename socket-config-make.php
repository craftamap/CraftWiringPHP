<?php
//Variablen
$xmlsocket = simplexml_load_file('socket.xml');
$u_action = $_REQUEST['action'];
$u_code = (int)$_REQUEST['code'];
$u_socketadr = (int)$_REQUEST['socketadr'];
$u_name = $_REQUEST['name'];


if ($u_action == "home"){
	home($xmlsocket, $u_code);
} elseif ($u_action == "change") {
	change($xmlsocket, $u_socketadr, $u_name);
} elseif ($u_action == "delete") {
	delete($xmlsocket, $u_socketadr);
} elseif ($u_action == "new") {
	create ($xmlsocket, $u_socketadr, $u_name);
}


function home ($xmlsocket, $u_code) {
	if ($xmlsocket->config['home'] == $u_code) {
	 header('Location: gpio-config.php?msg=1#tabs-2');
	} else {
		$xmlsocket->config['home'] = $u_code;
		$xmlsocket->AsXML("socket.xml");
		 header('Location: gpio-config.php?msg=00#tabs-2');
	}
}

function change ($xmlsocket, $u_socketadr, $u_name) {
	foreach($xmlsocket->config->socket as $socket) {
		if ($socket['socketadr'] == $u_socketadr) {
			if ($socket['name'] == $u_name) {header('Location:gpio-config.php?msg=1#tabs-2');} else {
				$socket['name'] = $u_name;
				$xmlsocket->AsXML("socket.xml");
				header('Location: gpio-config.php?msg=00#tabs-2');
			}

		}
	}
}

function delete ($xmlsocket, $u_socketadr){
	foreach($xmlsocket->config->socket as $socket){
		if ($socket['socketadr'] == $u_socketadr) {
			$dom=dom_import_simplexml($socket);
			$dom->parentNode->removeChild($dom);
			$xmlsocket->AsXML("socket.xml");
	}
	}
	header('Location: gpio-config.php?msg=4#tabs-2');
}


function create ($xmlsocket, $u_socketadr, $u_name){
	$make = 0;
	foreach ($xmlsocket->config->socket as $socket){
		if ($socket['socketadr']== $u_socketadr){
			$make = 1;
		}
	}
	if ($make == 1) {
	header('Location: gpio-config.php?msg=5#tabs-2');
	} elseif ($make == 0) {
	$socketconfig = $xmlsocket->config->addChild('socket');
	$socketconfig->addAttribute('socketadr', $u_socketadr);
	$socketconfig->addAttribute('name', $u_name);
	$xmlsocket->AsXML('socket.xml');
	$headerdata = "msg=2";
	header('Location: gpio-config.php?'.$headerdata.'#tabs-2');
	}
}
?>
