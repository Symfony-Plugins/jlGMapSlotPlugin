<?php

class GMapGeocode
{
  public static function getGeo($address)
  {
    //Query geocode via Google Map Geo API
    $api_url = 'http://maps.googleapis.com/maps/api/geocode/json?sensor=false&address=' . urlencode($address);

    $json_data = json_decode(file_get_contents($api_url));

    return $json_data;
  }

  public static function isValid($address)
  {
    $json_data = self::getGeo($address);

    if($json_data->{'status'} === "OK") //address valid
    {
      //return Google Map formatted address
      return $json_data->results[0]->{'formatted_address'};
    }
    else //address invalid
    {
      return null;
    }
  }

  public static function getLatLng($address)
  {
    $json_data = self::getGeo($address);

    if($json_data->{'status'} === "OK") //address valid
    {
      //return Google Map Lat Lng
      return $json_data->results[0]->geometry->location->lat . ', ' . $json_data->results[0]->geometry->location->lng;
    }
    else //address invalid
    {
      return null;
    }
  }
}