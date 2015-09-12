<html>
  <head>
	<?php $xml = simplexml_load_file('gpio_config.xml'); // XML wird geladen?>
	<style>
	body {
		font-family: sans-serif;
	}
	
	hr {
		width: 150px;
		border: 0;
		height: 1px;
		background-color: grey;
	}
  
    input, select {
		width:75px;
	}
	
	label {
		display: inline-block;
		width: 50px;
		margin-bottom: 10px;
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
		width: 75px;
		
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
 <div id="alert" class='alert <?=$alertstat ?>'>
  <?=$alerttext ?>
  </div>
	<form action="gpio-config-make.php">
	
		<input type="hidden" name="action" value="home">
		<label for="home">Home</label>
		<input name="home" value=<?=$xml['home']?>></input></br>
		<button type="submit">SEND</button>
	</form>
	 <hr align='left'>
  <?php
  $stack = array(); //Leerer Array wird erstellt 
  foreach ($xml->portconfig as $portconfig) {
	  $add = $portconfig->pin;
	  array_push($stack,(int) $add);
	  $key = array_search((int)$portconfig->pin, $stack);
	  print $key;
	  //Ab hier wird die Form geprintet
  ?>
  
<form action="gpio-config-make.php"> 

	<input type="hidden" name="key" value="<?=$key ?>">
	<input type="hidden" name="action" value="change">
	

	 <label for='pin'>PIN:</label>
	   <input type='number' id='pin' name='pin' readonly value=<?php print $portconfig->pin; ?> >
	 </br>
	 
	 <?php
	 //options array
	 $options = array("none","latching","disabled")
	 ?>
	
	 <label for="mode">Mode:</label>
	   <select id='name' name='mode'>
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
	 </br>
	 
	 <label for='wert'>Wert:</label>
	   <input type='number' id='wert' name='wert' value=<?php print $portconfig->mode->impuls['time']; ?>>
	 
	 </br>
	 <button type="submit">SEND</button>
 </form> 
 <form action="gpio-config-make.php">
 	<input type="hidden" name="key" value="<?=$key ?>">
	<input type="hidden" name="action" value="delete">
	<button type="submit">DELETE</button>
 </form>
	 <hr align='left'>
	
<?  
  } //Schleife wird geschlossen
  ?>
  NEW<form action="gpio-config-make.php"> 

	<input type="hidden" name="action" value="new">
	

	 <label for='pin'>PIN:</label>
	   <input type='number' id='pin' name='pin' value="" ></br>
	 
	 	
	 <label>Mode:</label>
	   <select name='mode'>
		<option >none</option>
		<option>latching</option>
	   </select></br>
	 
	 <label for='Wert'>Wert:</label>
	   <input type='number' id='wert' name='wert' value=1>
	 </br>
	 <button type="submit">SENDEN</button>
 </form>   
  </body>
</html>