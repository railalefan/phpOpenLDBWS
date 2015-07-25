<?php
  class OpenLDBWS
  {
    private $soapClient = NULL;

    private $accessToken;

    private $trace;

    function __construct($accessToken,$trace=FALSE)
    {
      $this->accessToken = $accessToken;

      $this->trace = $trace;

      $soapOptions = array("trace"=>$this->trace,"compression"=>SOAP_COMPRESSION_ACCEPT|SOAP_COMPRESSION_GZIP);

      $this->soapClient = new SoapClient("http://lite.realtime.nationalrail.co.uk/OpenLDBWS/wsdl.aspx",$soapOptions);

      $soapVar = new SoapVar(array("ns2:TokenValue"=>$this->accessToken),SOAP_ENC_OBJECT);

      $soapHeader = new SoapHeader("http://thalesgroup.com/RTTI/2010-11-01/ldb/commontypes","AccessToken",$soapVar,FALSE);

      $this->soapClient->__setSoapHeaders($soapHeader);
    }

    private function call($method,$params)
    {
      try
      {
        $response = $this->soapClient->$method($params);
      }
      catch(SoapFault $soapFault)
      {
        if ($this->trace)
        {
          $traceOutput["soapFaultMessage"] = $soapFault->getMessage();

          $traceOutput["soapClientRequest"] = str_replace($this->accessToken,"",$this->soapClient->__getLastRequest());

          $traceOutput["soapClientResponse"] = $this->soapClient->__getLastResponse();

          print_r($traceOutput);
        }
      }

      return (isset($response)?$response:FALSE);
    }

    function StationBoard($method,$numRows,$crs,$filterCrs,$filterType,$timeOffset,$timeWindow)
    {
      $params["numRows"] = $numRows;

      $params["crs"] = $crs;

      if ($filterCrs) $params["filterCrs"] = $filterCrs;

      if ($filterType) $params["filterType"] = $filterType;

      if ($timeOffset) $params["timeOffset"] = $timeOffset;

      if ($timeWindow) $params["timeWindow"] = $timeWindow;

      return $this->call($method,$params);
    }

    function DeparturesBoard($method,$crs,$filterList,$timeOffset,$timeWindow)
    {
      $params["crs"] = $crs;

      $params["filterList"] = $filterList;

      if ($timeOffset) $params["timeOffset"] = $timeOffset;

      if ($timeWindow) $params["timeWindow"] = $timeWindow;

      return $this->call($method,$params);
    }

    function GetDepartureBoard($numRows,$crs,$filterCrs="",$filterType="",$timeOffset="",$timeWindow="")
    {
      return $this->StationBoard("GetDepartureBoard",$numRows,$crs,$filterCrs,$filterType,$timeOffset,$timeWindow);
    }

    function GetDepBoardWithDetails($numRows,$crs,$filterCrs="",$filterType="",$timeOffset="",$timeWindow="")
    {
      return $this->StationBoard("GetDepBoardWithDetails",$numRows,$crs,$filterCrs,$filterType,$timeOffset,$timeWindow);
    }

    function GetArrivalBoard($numRows,$crs,$filterCrs="",$filterType="",$timeOffset="",$timeWindow="")
    {
      return $this->StationBoard("GetArrivalBoard",$numRows,$crs,$filterCrs,$filterType,$timeOffset,$timeWindow);
    }

    function GetArrBoardWithDetails($numRows,$crs,$filterCrs="",$filterType="",$timeOffset="",$timeWindow="")
    {
      return $this->StationBoard("GetArrBoardWithDetails",$numRows,$crs,$filterCrs,$filterType,$timeOffset,$timeWindow);
    }

    function GetArrivalDepartureBoard($numRows,$crs,$filterCrs="",$filterType="",$timeOffset="",$timeWindow="")
    {
      return $this->StationBoard("GetArrivalDepartureBoard",$numRows,$crs,$filterCrs,$filterType,$timeOffset,$timeWindow);
    }

    function GetArrDepBoardWithDetails($numRows,$crs,$filterCrs="",$filterType="",$timeOffset="",$timeWindow="")
    {
      return $this->StationBoard("GetArrDepBoardWithDetails",$numRows,$crs,$filterCrs,$filterType,$timeOffset,$timeWindow);
    }

    function GetNextDepartures($crs,$filterList,$timeOffset="",$timeWindow="")
    {
      return $this->DeparturesBoard("GetNextDepartures",$crs,$filterList,$timeOffset,$timeWindow);
    }

    function GetNextDeparturesWithDetails($crs,$filterList,$timeOffset="",$timeWindow="")
    {
      return $this->DeparturesBoard("GetNextDeparturesWithDetails",$crs,$filterList,$timeOffset,$timeWindow);
    }

    function GetFastestDepartures($crs,$filterList,$timeOffset="",$timeWindow="")
    {
      return $this->DeparturesBoard("GetFastestDepartures",$crs,$filterList,$timeOffset,$timeWindow);
    }

    function GetFastestDeparturesWithDetails($crs,$filterList,$timeOffset="",$timeWindow="")
    {
      return $this->DeparturesBoard("GetFastestDeparturesWithDetails",$crs,$filterList,$timeOffset,$timeWindow);
    }

    function GetServiceDetails($serviceID)
    {
      $params["serviceID"] = $serviceID;

      return $this->call("GetServiceDetails",$params);
    }
  }
?>
