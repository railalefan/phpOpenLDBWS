<?php
  require("OpenLDBWS.php");
  $OpenLDBWS = new OpenLDBWS("YOUR_ACCESS_TOKEN");
  $response = $OpenLDBWS->GetFastestDepartures("PAD",array("RDG","BRI"));
  header("Content-Type: text/plain");
  print_r($response);
?>
