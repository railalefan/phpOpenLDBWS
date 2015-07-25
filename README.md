phpOpenLDBWS
============

Very simple PHP object encapsulation of the National Rail Enquiries live departure boards SOAP web service (OpenLDBWS) as documented at http://www.livedepartureboards.co.uk/ldbws/

Usage
=====

    <?php
      require("OpenLDBWS.php");
      $OpenLDBWS = new OpenLDBWS("YOUR_ACCESS_TOKEN");
    ?>

To enable the trace option in the SoapClient and to display fault message, last request and last response on error, initiate using:

    <?php
      require("OpenLDBWS.php");
      $OpenLDBWS = new OpenLDBWS("YOUR_ACCESS_TOKEN",TRUE);
    ?>

Methods
=======

    stdClass GetDepartureBoard ( $numRows , $crs [, $filterCrs = "" , $filterType = "" , $timeOffset = "" , $timeWindow = "" ] )

    stdClass GetDepBoardWithDetails ( $numRows , $crs [, $filterCrs = "" , $filterType = "" , $timeOffset = "" , $timeWindow = "" ] )

    stdClass GetArrivalBoard ( $numRows , $crs [, $filterCrs = "" , $filterType = "" , $timeOffset = "" , $timeWindow = "" ] )

    stdClass GetArrBoardWithDetails ( $numRows , $crs [, $filterCrs = "" , $filterType = "" , $timeOffset = "" , $timeWindow = "" ] )

    stdClass GetArrivalDepartureBoard ( $numRows , $crs [, $filterCrs = "" , $filterType = "" , $timeOffset = "" , $timeWindow = "" ] )

    stdClass GetArrDepBoardWithDetails ( $numRows , $crs [, $filterCrs = "" , $filterType = "" , $timeOffset = "" , $timeWindow = "" ] )

    stdClass GetNextDepartures ( $crs , $filterList [, $timeOffset = "" , $timeWindow = "" ] )

    stdClass GetNextDeparturesWithDetails ( $crs , $filterList [, $timeOffset = "" , $timeWindow = "" ] )

    stdClass GetFastestDepartures ( $crs , $filterList [, $timeOffset = "" , $timeWindow = "" ] )

    stdClass GetFastestDeparturesWithDetails ( $crs , $filterList [, $timeOffset = "" , $timeWindow = "" ] )

    stdClass GetServiceDetails( $serviceID )

Example 1
=========

Request the next 10 departures from London Paddington (PAD), display stdClass response using print_r():

    <?php
      require("OpenLDBWS.php");
      $OpenLDBWS = new OpenLDBWS("YOUR_ACCESS_TOKEN");
      $response = $OpenLDBWS->GetDepartureBoard(10,"PAD");
      header("Content-Type: text/plain");
      print_r($response);
    ?>

Live demo:

http://www.railalefan.co.uk/rail/phpOpenLDBWS/example1.php

Example 2
=========

Request the next fastest departures from London Paddington (PAD), to Reading (RDG) and Bristol Temple Meads (BRI), display stdClass response using print_r():

    <?php
      require("OpenLDBWS.php");
      $OpenLDBWS = new OpenLDBWS("YOUR_ACCESS_TOKEN");
      $response = $OpenLDBWS->GetFastestDepartures("PAD",array("RDG","BRI"));
      header("Content-Type: text/plain");
      print_r($response);
    ?>

Live demo:

http://www.railalefan.co.uk/rail/phpOpenLDBWS/example2.php
