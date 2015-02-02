<?php
  require("OpenLDBWS.php");

  $OpenLDBWS = new OpenLDBWS("YOUR_ACCESS_TOKEN");

  $departureBoard = $OpenLDBWS->GetDepartureBoard(10,"PAD");

  header("Content-Type: text/plain");

  print_r($departureBoard);
?>
