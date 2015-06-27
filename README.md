# Freshsauce/GeoLocation

[![Build Status](https://scrutinizer-ci.com/g/freshsauce/GeoLocation-php/badges/build.png?b=master)](https://scrutinizer-ci.com/g/freshsauce/GeoLocation-php/build-status/master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/freshsauce/GeoLocation-php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/freshsauce/GeoLocation-php/?branch=master)

  A PHP class for resolving textual addresses to LatLng's or other info using Googles Free Geo location API
  If your volume goes up you need to use an API key from google and pay for the service

  While an API key is not required, Google will heavily limit your requests if you dont use one. Set it once as follows and all subsequent calls will use it.
  
    \Freshsauce\GeoLocation::setAPIKey('your-google-api-map-key);
    
  Lets do some calls

    $lat_lng = \Freshsauce\GeoLocation::getLatLng('Brighton, UK');
    
    # array(2) {
    #   ["lat"]=>
    #   float(50.82253)
    #   ["lng"]=>
    #   float(-0.137163)
    # }
    

    $summary_info = \Freshsauce\GeoLocation::getSummaryInfo('Brighton, UK');
    
    # array(8) {
    #   ["lat"]=>
    #   float(50.82253)
    #   ["lng"]=>
    #   float(-0.137163)
    #   ["town"]=>
    #   NULL
    #   ["county"]=>
    #   string(29) "The City of Brighton and Hove"
    #   ["country"]=>
    #   string(14) "United Kingdom"
    #   ["country_code"]=>
    #   string(2) "GB"
    #   ["formated"]=>
    #   string(43) "Brighton, The City of Brighton and Hove, UK"
    #   ["postcode"]=>
    #   NULL
    # }
    
    $geo_info = \Freshsauce\GeoLocation::getAllResults('Brighton, UK');
    
    # array(1) {
    #   [0]=>
    #   object(stdClass)#11 (5) {
    #     ["address_components"]=>
    #     array(4) {
    #       [0]=>
    #       object(stdClass)#4 (3) {
    #         ["long_name"]=>
    #         string(8) "Brighton"
    #         ["short_name"]=>
    #         string(8) "Brighton"
    #         ["types"]=>
    #         array(2) {
    #           [0]=>
    #           string(8) "locality"
    #           [1]=>
    #           string(9) "political"
    #         }
    #       }
    #       [1]=>
    #       object(stdClass)#1 (3) {
    #         ["long_name"]=>
    #         string(29) "The City of Brighton and Hove"
    #         ["short_name"]=>
    #         string(29) "The City of Brighton and Hove"
    #         ["types"]=>
    #         array(2) {
    #           [0]=>
    #           string(27) "administrative_area_level_2"
    #           [1]=>
    #           string(9) "political"
    #         }
    #       }
    #       [2]=>
    #       object(stdClass)#3 (3) {
    #         ["long_name"]=>
    #         string(7) "England"
    #         ["short_name"]=>
    #         string(7) "England"
    #         ["types"]=>
    #         array(2) {
    #           [0]=>
    #           string(27) "administrative_area_level_1"
    #           [1]=>
    #           string(9) "political"
    #         }
    #       }
    #       [3]=>
    #       object(stdClass)#5 (3) {
    #         ["long_name"]=>
    #         string(14) "United Kingdom"
    #         ["short_name"]=>
    #         string(2) "GB"
    #         ["types"]=>
    #         array(2) {
    #           [0]=>
    #           string(7) "country"
    #           [1]=>
    #           string(9) "political"
    #         }
    #       }
    #     }
    #     ["formatted_address"]=>
    #     string(43) "Brighton, The City of Brighton and Hove, UK"
    #     ["geometry"]=>
    #     object(stdClass)#8 (4) {
    #       ["bounds"]=>
    #       object(stdClass)#9 (2) {
    #         ["northeast"]=>
    #         object(stdClass)#10 (2) {
    #           ["lat"]=>
    #           float(50.8735837)
    #           ["lng"]=>
    #           float(-0.03626)
    #         }
    #         ["southwest"]=>
    #         object(stdClass)#13 (2) {
    #           ["lat"]=>
    #           float(50.801257)
    #           ["lng"]=>
    #           float(-0.1761194)
    #         }
    #       }
    #       ["location"]=>
    #       object(stdClass)#14 (2) {
    #         ["lat"]=>
    #         float(50.82253)
    #         ["lng"]=>
    #         float(-0.137163)
    #       }
    #       ["location_type"]=>
    #       string(11) "APPROXIMATE"
    #       ["viewport"]=>
    #       object(stdClass)#12 (2) {
    #         ["northeast"]=>
    #         object(stdClass)#7 (2) {
    #           ["lat"]=>
    #           float(50.8735837)
    #           ["lng"]=>
    #           float(-0.03626)
    #         }
    #         ["southwest"]=>
    #         object(stdClass)#6 (2) {
    #           ["lat"]=>
    #           float(50.801257)
    #           ["lng"]=>
    #           float(-0.1761194)
    #         }
    #       }
    #     }
    #     ["place_id"]=>
    #     string(27) "ChIJZ0Ep9gmFdUgR-Q59cnqvxpw"
    #     ["types"]=>
    #     array(2) {
    #       [0]=>
    #       string(8) "locality"
    #       [1]=>
    #       string(9) "political"
    #     }
    #   }
    # }
    

 