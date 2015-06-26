# Freshsauce/GeoLocation

  a PHP class for resolving textual addresses to LatLng's using Googles Free Geo location API
  If your volume goes up you need to use an API key from google and pay for the service

  Examples:-
    \Freshsauce\GeoLocation::setAPIKey('your-key);
    
    $latLng = \Freshsauce\GeoLocation::getLatLng('Brighton,UK');
    
    $latLng = \Freshsauce\GeoLocation::getLatLng(['Bristol','UK']); 

 