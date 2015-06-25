<?php
namespace Freshsauce;

/**
* GeoLocation using google GEO API
* current supports location text to Lat,Lng
*/
class Geolocation
{
  // API URL
  const API_URL = 'http://maps.googleapis.com/maps/api/geocode/json';
  
  private function __construct() {} // No need to 
  
  /**
   * Get LatLng of address
   *
   * @param array|string $$address_parts array of address parts least significant first or a string
   * @return void
   */
  public static function getLatLng( $address_parts ) {
    
    if (is_array($address_parts)) {
      if (count($address_parts) == 0)
        throw new GeoLocationException("No address to Geocode", 1);
      $address = implode(' ', $address_parts);
    } else {
      if (strlen($address_parts) == 0)
        throw new GeoLocationException("No address to Geocode", 1);
      $address = $address_parts;
    }

    // define result
    $results = self::doCall([
      'address' => $address,
      'sensor' => 'false'
    ]);
    // return coordinates latitude/longitude
    return array(
      'lat' => isset($results[0]->geometry->location->lat) ? (float) $results[0]->geometry->location->lat : null,
      'lng' => isset($results[0]->geometry->location->lat) ? (float) $results[0]->geometry->location->lng : null
    );
  }
  
  /**
   * Do call
   *
   * @return object
   * @param  array  $parameters
   */
  protected static function doCall($parameters = array()) {
    // check if curl is available
    if (!function_exists('curl_init')) {
      // throw error
      throw new GeoLocationException('cURL isn\'t installed.');
    }

    // create URL
    $url = self::API_URL . '?';
    foreach ($parameters as $key => $value) {
       $url .= $key . '=' . urlencode($value) . '&';
    }
    // trim last &
    $url = trim($url, '&');

    // init curl & set options
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    if (ini_get('open_basedir') == '' && ini_get('safe_mode' == 'Off')) {
      curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    }

    // execute
    $response     = curl_exec($curl);

    // fetch errors
    $errorNumber  = curl_errno($curl);
    $errorMessage = curl_error($curl);

    // close curl
    curl_close($curl);

    // we have errors
    if ($errorNumber != '') throw new GeoLocationException($errorMessage);

    // redefine response as json decoded
    $response = json_decode($response);

    // return the content
    return $response->results;
  }
}

class GeoLocationException extends \Exception {}

