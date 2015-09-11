<?php
shell_exec('gpio export ' . $_GET["pin"] . "  out");
echo $_GET["pin"];
if($_GET["pin"] == "27"){
shell_exec('gpio -g write ' . $_GET["pin"] . " 1");
sleep(1);
shell_exec('gpio -g write ' . $_GET["pin"] . " 0");
} else {
shell_exec('gpio -g write ' . $_GET["pin"] . " " . $_GET["status"]);
}
echo $_GET["pin"];
echo $_GET["status"];
?>

