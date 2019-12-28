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