<?php

class jlGMap
{
  protected $options = array(
    'Width' => null,
    'Height' => null,
    'Zoom' => null,
    'Map Type' => null,
    'Map Type Control' => null,
    'Scale Control' => null,
    'Navigation Control' => null,
    'StreetView Control' => null,
    'Dynamic Map' => null,
    'Show Marker' => null,
    'Address' => null,
    'LatLng' => null,
    'Name' => null,
    'id' => null
  );

  public function __construct($options=array())
  {
    $this->setOptions($options);
  }

  public function setOptions($options)
  {
    $this->options = array_merge($this->options,$options);
  }

  public function getId()
  {
    return $this->options['id'];
  }

  public function getWidth()
  {
    return $this->options['Width'];
  }

  public function getHeight()
  {
    return $this->options['Height'];
  }

  public function isValid()
  {
    if ($this->options['Address'])
    {
      return true;
    }
    else
    {
      return false;
    }
  }

  public function isDynamic()
  {
    return $this->options['Dynamic Map'];
  }

  public function displayStatic()
  {
    $html = 'http://maps.google.com/maps/api/staticmap?';
    $html .= 'center='.$this->options['Address'];
    $html .= '&zoom='.$this->options['Zoom'];
    $html .= '&size=' . $this->options['Width'] . 'x' . $this->options['Height'];
    $html .= '&maptype='.$this->options['Map Type'];
    if ($this->options['Show Marker']) 
    {
      $html .= '&markers='.$this->options['Address'];
    }
    $html .= '&sensor=false';

    return $html;
  }

  public function displayDynamic()
  {
    $html = array();

    $html[] = 'function initialize_' . str_replace("-", "_", $this->options['id']) . '() {';
    $html[] = 'var latlng = new google.maps.LatLng(' . $this->options['LatLng'] . ');';
    $html[] = 'var myOptions = {';
    $html[] = 'zoom: ' . $this->options['Zoom'] . ',';
    $html[] = 'center: latlng,';

    if($this->options['Map Type'] === "roadmap")
      $html[] = 'mapTypeId: google.maps.MapTypeId.ROADMAP,';
    if($this->options['Map Type'] === "satellite")
      $html[] = 'mapTypeId: google.maps.MapTypeId.SATELLITE,';
    if($this->options['Map Type'] === "hybrid")
      $html[] = 'mapTypeId: google.maps.MapTypeId.HYBRID,';
    if($this->options['Map Type'] === "terrain")
      $html[] = 'mapTypeId: google.maps.MapTypeId.TERRAIN,';

    if($this->options['Map Type Control'] != null)
      $html[] = 'mapTypeControl: ' . (bool)$this->options['Map Type Control'] . ',';
    else
      $html[] = 'mapTypeControl: false,';
    if($this->options['Navigation Control'] != null)
      $html[] = 'navigationControl: ' . (bool)$this->options['Navigation Control'] . ',';
    else
      $html[] = 'navigationControl: false,';
    if($this->options['Scale Control'] != null)
      $html[] = 'scaleControl: ' . (bool)$this->options['Scale Control'] . ',';
    else
      $html[] = 'scaleControl: false,';
    if($this->options['StreetView Control'] != null)
      $html[] = 'streetViewControl: ' . (bool)$this->options['StreetView Control'];
    else
      $html[] = 'streetViewControl: false';
    $html[] = '};';

    $html[] = "var map_". str_replace("-", "_", $this->options['id']) . " = new google.maps.Map(document.getElementById('" . $this->options['id'] . "'),";
    $html[] = 'myOptions);';

    if($this->options['Show Marker'])
    {
      $html[] = 'var marker = new google.maps.Marker({';
      $html[] = 'position: latlng, ';
      $html[] = 'map: map_'. str_replace("-", "_", $this->options['id']) ;
      $html[] = '});';
    }

    $html[] = '}';

    $html[] = '//avoid loading the maps api multiple times';
    $html[] = 'if(!(window.google != undefined)){';
    $html[] = 'var script = document.createElement("script");';
    $html[] = 'script.type = "text/javascript";';
    $html[] = 'script.src = "http://maps.google.com/maps/api/js?sensor=false";';
    $html[] = 'document.body.appendChild(script);';
    $html[] = '}';

    $html[] = '$(function(){';
    $html[] = 'initialize_' . str_replace("-", "_", $this->options['id']) . '();';
    $html[] = '});';

    $html = join("\n", $html);

    return $html;
  }
}