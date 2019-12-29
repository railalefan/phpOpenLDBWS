phpOpenLDBWS
============

Very simple PHP object encapsulation of the National Rail Enquiries live departure boards SOAP web service (OpenLDBWS) as documented at http://lite.realtime.nationalrail.co.uk/OpenLDBWS/

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

https://railalefan.co.uk/phpOpenLDBWS/example1.php

(response cached for 60s)

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

https://railalefan.co.uk/phpOpenLDBWS/example2.php

(response cached for 60s)

Example 3
=========

Departures summary as an HTML table to demonstrate looping over result set and multiple destinations:

    <?php
      require("OpenLDBWS.php");
      $OpenLDBWS = new OpenLDBWS("YOUR_ACCESS_TOKEN");
      $response = $OpenLDBWS->GetDepartureBoard(10,"GTW");
      $template["header"] = "
        <style type='text/css'>
          table {
            border-collapse: collapse;
          }
          th,td {
            font-family: monospace;
            border: 1px solid #eee;
            padding: 10px;
          }
          th:nth-child(1),th:nth-child(2) {
            text-align: left;
          }
          th:nth-child(3),td:nth-child(3) {
            text-align: center;
          }
          th:nth-child(4),td:nth-child(4) {
            text-align: right;
          }
        </style>
        <table>
          <thead>
            <tr>
              <th>Time</th>
              <th>Destination</th>
              <th>Platform</th>
              <th>Expected</th>
            </tr>
          </thead>
          <tbody>
        ";
      $template["row"] = "
            <tr>
              <td>{std}</td>
              <td>{destination}</td>
              <td>{platform}</td>
              <td>{etd}</td>
            </tr>
      ";
      $template["footer"] = "
          </tbody>
        </table>
      ";
      if (isset($response->GetStationBoardResult->trainServices->service))
      {
        if (is_array($response->GetStationBoardResult->trainServices->service))
        {
          $services = $response->GetStationBoardResult->trainServices->service;
        }
        else
        {
          $services = array($response->GetStationBoardResult->trainServices->service);
        }
        print $template["header"];
        foreach($services as $service)
        {
          $row = $template["row"];
          $destinations = array();
          if (is_array($service->destination->location))
          {
            $locations = $service->destination->location;
          }
          else
          {
            $locations = array($service->destination->location);
          }
          foreach($locations as $location)
          {
            $destinations[] = $location->locationName;
          }
          $row = str_replace("{std}",$service->std,$row);
          $row = str_replace("{destination}",implode(" and ",$destinations),$row);
          $row = str_replace("{platform}",(isset($service->platform)?$service->platform:"&nbsp;"),$row);
          $row = str_replace("{etd}",$service->etd,$row);
          print $row;
        }
        print $template["footer"];
      }
    ?>

Live demo:

https://railalefan.co.uk/phpOpenLDBWS/example3.php

(response cached for 60s)