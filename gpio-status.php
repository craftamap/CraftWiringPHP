<html>

<head>

  <style>
  body {font-family: "Courier New", monospace;
  </style>

</head>
 <body>
  <?php
    $cmd = shell_exec("gpio readall");
    $newcmd = wordwrap($cmd, 80, "</br>\n", true);
    $newcmd2 = str_replace(" ", "&nbsp;", $newcmd);
    echo $newcmd2;
  ?>
  </body>

</head>


