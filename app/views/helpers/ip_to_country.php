<?php
App::import('Xml');
class IpToCountryHelper extends Helper {
    var $helpers = array('Html');
	function getIp(){
		if ( isset($_SERVER["REMOTE_ADDR"]) )    {
			$ip = $_SERVER["REMOTE_ADDR"];
		} else if ( isset($_SERVER["HTTP_X_FORWARDED_FOR"]) )    {
			$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		} else if ( isset($_SERVER["HTTP_CLIENT_IP"]) )    {
			$ip = $_SERVER["HTTP_CLIENT_IP"];
		}
	return $ip;
	}
	
	function getCountry(){
		$ip = $this->getIp();
		$parsed =& new Xml('http://api.hostip.info/?ip='.$ip.'&position=true');
        $parsed = Set::reverse($parsed);
		$country2['city'] = $parsed['HostipLookupResultSet']['FeatureMember']['Hostip']['name'];
		$country2['country'] = $parsed['HostipLookupResultSet']['FeatureMember']['Hostip']['countryName'];
		if(!in_array("XX",$parsed['HostipLookupResultSet']['FeatureMember']['Hostip']))
			$country2['coordinates'] = $parsed['HostipLookupResultSet']['FeatureMember']['Hostip']['IpLocation']['PointProperty']['Point']['coordinates'];
		else	
			$country2['coordinates'] = ("-68.8328,-32.8917");
		return $country2;
	}
}

?>