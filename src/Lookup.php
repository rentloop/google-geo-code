<?php

namespace Rentloop\GoogleGeoCode;

use GuzzleHttp\Client;

class Lookup
{

  /**
   * Fetch data about given address, city and state from Google's Geocode API.
   *
   * @param String address  Address of location to search for. |REQUIRED|
   * @param String city  City of location address is located  |OPTIONAL|
   * @param String state  State which city and address are located  |OPTIONAL|
   *
   * @return Array  Location Data provided by Google
   */
  public function locate($address, $city = null, $state = null)
  {
    return $this->buildData($address, $city, $state);
  }

  /**
   * Puts together array of data after being fetched.
   *
   * @param String address  Address of location to search for. |REQUIRED|
   * @param String city  City of location address is located  |OPTIONAL|
   * @param String state  State which city and address are located  |OPTIONAL|
   *
   * @return Array data  Data collected from google
   */
  public function buildData($address, $city, $state)
  {
    $response  = $this->fetchLocation($address, $city, $state);

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

  /**
   * Calls the API through Guzzle and fetches location data based on
   * the inputs (address, city, state).
   *
   * @param String address  Address of location to search for. |REQUIRED|
   * @param String city  City of location address is located  |OPTIONAL|
   * @param String state  State which city and address are located  |OPTIONAL|
   *
   * @return Object response  Google GeoCode API response
   */
  public function fetchLocation($address, $city, $state)
  {
    $uri = 'https://maps.googleapis.com/maps/api/geocode/json?address='. urlencode($address) .'+'.
                                                                         urlencode($city) .'+'.
                                                                         urlencode($state) .
                                                                         '&key='. env('GOOGLE_GEOCODE_KEY');
    $client = new Client();

    $response = json_decode($client->get( $uri )->getBody());

    // TODO: Send an error to the log
    if($response->status != 'OK'){
      return 'ERROR';
    }

    return $response;
  }

  /**
   * Takes address componetes and makes the data more readable by
   * parsing the vars into objects
   *
   * @param Array components  Address componets from the Google GeoCode API
   *
   * @return Array address_components
   */
  public function parseAddress($components)
  {
    $address_components = [];
    foreach($components as $k => $object){
      $address_components[$object->types[0]] = get_object_vars($object);
    }

    return $address_components;
  }

  /**
   * Takes geometry data and makes the data more readable by
   * parsing the vars into objects
   *
   * @param Object location  geometry data from the Google GeoCode API
   *
   * @return Array location
   */
  public function parseGeometry($location)
  {
    return $location->location;
  }

}
