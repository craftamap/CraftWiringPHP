<html lang="de">
 <head>
 <title>Index - CraftWiringPHP</title>
 <?php $xml = simplexml_load_file('gpio_config.xml');
$xmlsocket = simplexml_load_file('socket.xml'); ?>
 <link rel="stylesheet" href="style.css">
 <style>
	label {
		width: 150px;
	}
 </style>
 </head>
 <body>
  <header>
    <h1>CraftWiringPHP</h1>
  </header>
  <nav>
   <ul>
    <li><a href="index.php">home</a></li>
	<li><a href="gpio-config.php">configuration</a></li>
	<li><a>start manually</a></li>
	<li><a href="status.php">status</a></li>
	<li><a>View on GitHub</a></li>
   </ul>
  </nav>
  <article>
  <?php
  print "<h2>GPIO</h2></br>"; 
  foreach ($xml->portconfig as $portconfig) {
  if ($portconfig->mode['name'] == "latching")
	{$form = "
	<form action='gpio-2.php' class='button-container'>
	<input type='hidden' name='pin' value='".$portconfig->pin."'></input>
	<input type='hidden' name=back value='index'></input>
	<label for='wechsel'>".$portconfig->pin['name']." (".$portconfig->pin.")</label>
	<button name='wechsel' class='btn btn-default btn-sm'>Wechsel</button>
	</form></br>
	";} 
  elseif ($portconfig->mode['name']) 
	{$form ="
	<form action='gpio-2.php' class='button-container'>
	<input type='hidden' name='pin' value='".$portconfig->pin."'></input>
	<input type='hidden' name=back value='index'></input>
	<label for='status'>".$portconfig->pin['name']."(".$portconfig->pin.")</label>
	<button name='status' value=1 class='btn btn-left'>An</button>
	</form><form action='gpio-2.php' class='button-container'>
	<input type='hidden' name=back value='index'></input>
	<input type='hidden' name='pin' value='".$portconfig->pin."'></input>
	<button name='status' value=0 class='btn btn-right'>Aus</button>
	</form></br>
	";} 
  if($portconfig->mode['name'] != "disabled"){
  print $form;
  } 
  }

 print "<h2>Sockets</h2></br>";

 foreach ($xmlsocket->config->socket as $socket){
 print ("
  <form action='gpio-2.php' class='button-container'>
  <input type='hidden' name='socket' value='".$socket['socketadr']."'></input>
  <input type='hidden' name='back' value='index'></input>
  <label>".$socket['name']." (".$socket['socketadr'].")</label>
  <button class='btn btn-left' name='status' value='1'>An</button>
  </form><form action='gpio-2.php' class='button-container'>
  <input type='hidden' name='socket' value='".$socket['socketadr']."'></input>
  <input type='hidden' name='back' value='index'></input>
  <button class='btn btn-right' name='status' value='0'>Aus</button>
  </form></br>

");
}
?>
  </article>
 </body>
</html>
