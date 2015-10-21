<html lang="de">
 <head>
 <title>Index - CraftWiringPHP</title>
 <?php $xml = simplexml_load_file('gpio_config.xml'); ?>
 <link rel="stylesheet" href="style.css">
 <style>
	label {
		width: 150px;
	}
	
	p {font-family: "Courier New", monospace; }
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
	<li><a>status</a></li>
	<li><a>View on GitHub</a></li>
   </ul>
  </nav>
  <article>
  <p>
    <?php
    $cmd = shell_exec("gpio readall");
    $newcmd = wordwrap($cmd, 80, "</br>\n", true);
	$newcmd2 = substr($newcmd, 1);
    $newcmd3 = str_replace(" ", "&nbsp;", $newcmd2);
    echo $newcmd3;
  ?>
  </p>
    </article>
 </body>
</html>
