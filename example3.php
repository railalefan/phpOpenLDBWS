<!DOCTYPE html>
<html lang="en">
  <head>
    <style type='text/css'>
      body {
        font-family: monospace;
        white-space: nowrap;
      }
      table {
        border-collapse: collapse;
      }
      th,td {
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
  </head>
  <body>
    <?php
      require("OpenLDBWS.php");
      $OpenLDBWS = new OpenLDBWS("YOUR_ACCESS_TOKEN");
      $response = $OpenLDBWS->GetDepartureBoard(10,"GTW");
      $template["header"] = "
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
        print $template["header"];
        foreach($response->GetStationBoardResult->trainServices->service as $service)
        {
          $row = $template["row"];
          $destinations = array();
          foreach($service->destination->location as $location)
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
  </body>
</html>