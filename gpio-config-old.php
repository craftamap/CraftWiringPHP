<html lang="de">
 <head>
 <title>Config - CraftWiringPHP</title>
 <link rel="stylesheet" href="style.css">
	<?php $xml = simplexml_load_file('gpio_config.xml');	// XML wird geladen
		  $xml_socket = simplexml_load_file('socket.xml');?>
	<style>
	
	hr {
		width: 150px;
		border: 0;
		height: 1px;
		background-color: grey;
	}
  
	
	label {
		/*display: inline-block;*/
		margin-bottom: 10px;
		width: auto;
		margin-right: -4px;
	}
	
	.alert {
		width: 80%;
		text-align: center;
		margin: 0 auto;
		border: 3px;
		border-style: solid;

		padding: 5px;
		border-radius: 5px;
	}
	
	.alertsuccess {
		border-color: darkgreen;
		background-color:green;
	}
	
	.alerterror {
		border-color: darkred;
		background-color:Crimson;
	}
	
	.alertnote {
		border-color: Gold;
		background-color:yellow;
	}
	
	.none {
		display: none;
	}
	
	button {
		width: 80px;
		
	}
	input {
		width: 70px;
		
	}
	.button-container {
		display: inline;
	}
	
	input, select {

	}
	
	select {
	  margin-left: -1px;
	  height: 30px;
	}
	</style>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

	<script>
	window.onload = function () {
		setTimeout(function(){
			$('#alert').fadeOut('slow', function() {});
		},5000);
		
	}
	</script>
  <?php
  if(!empty($_GET['msg']) or $_GET['msg'] == '0'){
	echo $script;
	$msg = (int)$_GET['msg'];
	if($msg == 0) {
		$alertstat = "alertsuccess";
		$alerttext = "Erfolgreich bearbeitet";
	} elseif ($msg == 1) {
		$alertstat = "alertnote";
		$alerttext = "Daten bereits identisch";
	} elseif ($msg == 2) {
		$alertstat = "alertsuccess";
		$alerttext = "Erfolgreich erstellt";
	} elseif ($msg == 3) {
		$alertstat = "alerterror";
		$alerttext = "Wert nicht vorhanden";
	} elseif ($msg == 4) {
		$alertstat = "alertsuccess";
		$alerttext = "Ausnahme erfolgreich gelöscht";
	}
  }
  if (empty($_REQUEST['msg'])) {
	  $alertstat = "none";

  }
  
  ?>
  </head>

  <body>
  <header>
    <h1>CraftWiringPHP</h1>
  </header>
  <nav>
   <ul>
    <li><a href="index.php">home</a></li>
	<li><a">configuration</a></li>
	<li><a>start manually</a></li>
	<li><a href="gpio-status.php">status</a></li>
	<li><a>View on GitHub</a></li>
   </ul>
  </nav>
  <article>
 <div id="alert" class='alert <?=$alertstat ?>'>
  <?=$alerttext ?>
  </div>
	<form action="gpio-config-make.php" class='button-container'>
	
		<input type="hidden" name="action" value="home">
		<label for="home" class="btn btn-left">homecode </label>
		<input class="btn btn-right" name="home" value=<?=$xml['home']?>></input></br></br>
		<button class="btn" type="submit">SEND</button></br>
	</form>
	 <hr align='left'>
  <?php
  $stack = array(); //Leerer Array wird erstellt 
  foreach ($xml->portconfig as $portconfig) {
	  $add = $portconfig->pin;
	  array_push($stack,(int) $add);
	  $key = array_search((int)$portconfig->pin, $stack);
	  print ($key."</br>");
	  //Ab hier wird die Form geprintet
  ?>
  
<form action="gpio-config-make.php" class='button-container'> 

	<input type="hidden" name="key" value="<?=$key ?>">
	<input type="hidden" name="action" value="change">
	

	 <label  class="btn btn-left" >PIN:</label>
	   <input class="btn btn-right" type='number' id='pin' name='pin' readonly value=<?php print $portconfig->pin; ?> >
	 <label  class="btn btn-left" >Name:</label>
	   <input class="btn btn-right" id='name' name='name' value=<?php print $portconfig->pin['name']; ?> >
	 
	 <?php
	 //options array
	 $options = array("none","latching","disabled")
	 ?>
	
	 <label class="btn btn-left">Mode:</label>
	   <select class="btn btn-right" id='name' name='mode'>
		<?php
		foreach ($options as $option) {
			if ($option == $portconfig->mode['name']){
				$active = "selected='selected'";
			} else {
				$active = "";
			}
			print "<option " . $active . ">" . $option . "</option>";
			
		}
		
		?>
	   </select>
	 
	 <label class="btn btn-left">Wert:</label>
	   <input class="btn btn-right" type='number' id='wert' name='wert' value=<?php print $portconfig->mode->impuls['time']; ?>>
	 
	 </br>
	 </br>
	 <button class="btn" type="submit">SEND</button>
 </form> 
 <form action="gpio-config-make.php" class='button-container'>
 	<input type="hidden" name="key" value="<?=$key ?>">
	<input type="hidden" name="action" value="delete">
	<button class="btn" type="submit">DELETE</button>
 </form>
 </br></br>
	 <hr align='left'>
	
<?php
  } //Schleife wird geschlossen
  ?>
  NEW
  <form action="gpio-config-make.php"> 

	<input class="btn" type="hidden" name="action" value="new">
	
		 <label class="btn btn-left">PIN:</label>
	   <input class="btn btn-right" type='number' id='pin' name='pin' value="" >
		 <label  class="btn btn-left" >Name:</label>
	   <input class="btn btn-right" id='name' name='name' value="" >	   
	 	
	 <label class="btn btn-left">Mode:</label>
	   <select class="btn btn-right" name='mode'>
		<option >none</option>
		<option>latching</option>
		<option>disabled</option>
	   </select>
	 
	 <label class="btn btn-left" for='Wert'>Wert:</label>
	   <input class="btn btn-right" type='number' id='wert' name='wert' value=1>
	 </br>
	 </br>
	 <button class="btn" type="submit">SENDEN</button>
 </form>
   </article>
  </body>
</html>
