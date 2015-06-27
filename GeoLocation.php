<?php
namespace Freshsauce;

/**
* GeoLocation using google GEO API
* current supports location text to Lat,Lng
*/
class Geolocation
{
  // API URL
  const API_URL   = 'http://maps.googleapis.com/maps/api/geocode/json';
  static $API_KEY = null;

  private function __construct() {} // No need to 
  
  /**
  * Set Google API key
  *
  * @param string $key 
  * @return void
  */
  public static function setAPIKey($key) {
    self::$API_KEY = $key;
  }
  
  /**
   * Get LatLng of address
   *
   * @param array|string $address_parts array of address parts least significant first or a string
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
   * Get LatLng, Town, county and country from a lookup string such as post code
   *
   * @param string $lookup
   * @return array()
   * @throws GeolocationException
   */
  public static function getSummaryInfo( $lookup ) {
    
    if (strlen($lookup) == 0) {
      throw new GeolocationException("No address to Geocode", 1);
    }

    // define result
    $results = self::doCall([
      'address' => $lookup,
      'sensor' => 'false'
    ]);
    
    // return coordinates latitude/longitude
    $data = [
      'lat'          => isset($results[0]->geometry->location->lat) ? (float) $results[0]->geometry->location->lat : null,
      'lng'          => isset($results[0]->geometry->location->lat) ? (float) $results[0]->geometry->location->lng : null,
      'town'         => null,
      'county'       => null,
      'country'      => null,
      'country_code' => null,
      'formated'     => isset($results[0]->formatted_address) ? $results[0]->formatted_address : null,
      'postcode'     => null
    ];
    
    // Parse out address components
    if (isset($results[0]->address_components)) {
      foreach($results[0]->address_components as $ac) {
        if (in_array('postal_code',$ac->types)) {
          $data['postcode'] = $ac->long_name;
        } else if (in_array('postal_town',$ac->types)) {
          $data['town'] = $ac->long_name;
        } else if (in_array('administrative_area_level_2',$ac->types)) {
          $data['county'] = $ac->long_name;
        } else if (in_array('country',$ac->types)) {
          $data['country']      = $ac->long_name;
          $data['country_code'] = $ac->short_name;
        }
      }
    }
    return $data;
  }
  
  /**
   * Get all returned lookup info from a lookup string such as post code
   *
   * @param string $lookup
   * @return array
   * @throws GeolocationException
   */
  public static function getAllResults( $lookup ) {
    
    if (strlen($lookup) == 0) {
      throw new GeolocationException("No address to Geocode", 1);
    }

    // define result
    return self::doCall([
      'address' => $lookup,
      'sensor' => 'false'
    ]);
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

    if (self::$API_KEY) $parameters['key'] = self::$API_KEY;
    
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

    // We have an error so throw it
    if (isset($response->error_message)) throw new GeoLocationException($response->error_message);

    // return the content
    return $response->results;
  }
}

class GeoLocationException extends \Exception {}

