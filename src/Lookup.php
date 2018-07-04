<?php

namespace Rentloop\GoogleGeoCode;

use GuzzleHttp\Client;

class Lookup
{

  public function locate($address)
  {
    return $this->buildData($address);
  }

  public function buildData($address)
  {
    $response  = $this->fetchLocation($address);

    $results   = get_object_vars($response->results[0]);
    $address   = $this->parseAddress($results['address_components']);
    $geometry  = $this->parseGeometry($results['geometry']);

    $data['formatted_address'] = $results['formatted_address'];
    $data['place_id']          = $results['place_id'];

    $data['neighborhood']      = $address['neighborhood']['long_name'];
    $data['address']           = $address['street_number']['long_name'].' '. $address['route']['long_name'];
    $data['city']              = $address['locality']['long_name'];
    $data['state']             = $address['administrative_area_level_1']['long_name'];
    $data['postal_code']       = $address['postal_code']['long_name'];
    $data['county']            = $address['administrative_area_level_2']['long_name'];
    $data['country']           = $address['country']['long_name'];

    $data['lat']               = $geometry->lat;
    $data['lng']               = $geometry->lng;

    return $data;
  }

  public function fetchLocation($address)
  {
    $uri = 'https://maps.googleapis.com/maps/api/geocode/json?address='. urlencode($address) .'+Chicago+IL&key='. env('GOOGLE_GEOCODE_KEY');
    $client = new Client();

    $response = json_decode($client->get( $uri )->getBody());

    // TODO: Send an error to the log
    if($response->status != 'OK'){
      return 'ERROR';
    }

    return $response;
  }

  public function parseAddress($components)
  {
    $address_components = [];
    foreach($components as $k => $object){
      $address_components[$object->types[0]] = get_object_vars($object);
    }

    return $address_components;
  }

  public function parseGeometry($location)
  {
    return $location->location;
  }

}
