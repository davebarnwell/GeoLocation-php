<?php

/*
 * Testing
 */

namespace Freshsauce;


require_once(dirname(__DIR__).'/GeoLocation.php');

Class geoLocationTest extends \PHPUnit_Framework_TestCase {
  
    /**
     * @covers ::getLatLng
     */
    public function testGetLatLng() {
        $response = GeoLocation::getLatLng('Brighton, UK'); // city/town lookup
        
        $this->assertNotEmpty($response);

        $this->assertArrayHasKey('lat',$response);
        $this->assertArrayHasKey('lng',$response);

        $this->assertInternalType("float",$response['lat']);
        $this->assertInternalType("float",$response['lng']);
    }
    
    /**
     * @covers ::getSummaryInfo
     */
    public function testGetSummaryInfo() {
        $response = GeoLocation::getSummaryInfo('BN3 2LS'); // post code lookup
        
        $this->assertNotEmpty($response);

        $this->assertArrayHasKey('lat',$response);
        $this->assertArrayHasKey('lng',$response);
        $this->assertArrayHasKey('town',$response);
        $this->assertArrayHasKey('county',$response);
        $this->assertArrayHasKey('country',$response);
        $this->assertArrayHasKey('country_code',$response);
        $this->assertArrayHasKey('formated',$response);
        $this->assertArrayHasKey('postcode',$response);
        

        $this->assertInternalType('float',$response['lat']);
        $this->assertInternalType('float',$response['lng']);
        $this->assertInternalType('string',$response['town']); // Optional
        // $this->assertInternalType('string',$response['county']); // Optional
        $this->assertInternalType('string',$response['country']);
        $this->assertInternalType('string',$response['country_code']);
        $this->assertInternalType('string',$response['formated']);
        $this->assertInternalType('string',$response['postcode']); // Optional

    }
    
    /**
     * @covers ::getAllResults
     */
    public function testGetAllResults() {
        $response = GeoLocation::getAllResults('BN3 2LS');  // post code lookup
        
        $this->assertNotEmpty($response);

    }
    
}