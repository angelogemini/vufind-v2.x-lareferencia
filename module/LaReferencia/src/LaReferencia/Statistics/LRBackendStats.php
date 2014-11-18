<?php
/**
 * Solr Statistics Driver
 *
 * PHP version 5
 *
 * Copyright (C) Villanova University 2010.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License version 2,
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * @category VuFind2
 * @package  Statistics
 * @author   Chris Hallberg <challber@villanova.edu>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     http://vufind.org   Main Site
 */
namespace LaReferencia\Statistics;

use VuFindSearch\Backend\Solr\Backend;
use VuFindSearch\Query\Query;
use VuFindSearch\ParamBag;
use VuFind\Search\BackendManager;

/**
 * @category VuFind2
 * @package  Statistics
 * @author   Chris Hallberg <challber@villanova.edu>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     http://vufind.org   Main Site
 */
class LRBackendStats
{
    
    /**
     * Solr backend
     *
     * @var Backend
     */
    protected $config;
    protected $BackendWSBaseURL;
 
    
    const VALID_TAG = "validSize";
    const TRANSFORMED_TAG = "transformedSize";
    const TOTAL_TAG = "size";
    const NAME_TAG = "name";
    const ACRONYM_TAG = "acronym";
    const DATESTAMP_TAG = "datestamp";
    
   
    /**
     * Constructor
     *
     * @param Backend $backend Solr backend
     */
    public function __construct( /*\Zend\Config\Config $config*/ )
    {
    	/*$this->config = $config;   */	    	
    	$this->BackendWSBaseURL = "http://localhost:8090"; //isset($config->Backend->wsurl) ? $config->Backend->wsurl : 'http://localhost:8090/backend';
    }
    
   
    /**
     * Get the total count of a field.
     *
     * @param string $field What field of data are we researching?
     * @param array  $value Extra options for search. Value => match this value
     *
     * @return array
     */
    public function getNetworkList()
    
    
    {
    	$networksInfoArray = $this->callJSONService( $this->BackendWSBaseURL . "/public/listNetworks" );
    	
    	$aggrInfo = array(self::VALID_TAG => 0, self::TRANSFORMED_TAG => 0, self::TOTAL_TAG => 0);
    	$response  = array();
    	$networks = array();
    	
    	foreach ($networksInfoArray as $networkInfo) {
	
    		
    		$aggrInfo[self::TOTAL_TAG] = $aggrInfo[self::TOTAL_TAG] + $networkInfo[self::TOTAL_TAG];	
    		$aggrInfo[self::TRANSFORMED_TAG] = $aggrInfo[self::TRANSFORMED_TAG] + $networkInfo[self::TRANSFORMED_TAG];
    		$aggrInfo[self::VALID_TAG] = $aggrInfo[self::VALID_TAG] + $networkInfo[self::VALID_TAG];
    		
    		
    		array_push($networks, array(
    				self::ACRONYM_TAG		  => $networkInfo[ self::ACRONYM_TAG ],	
    				self::DATESTAMP_TAG		  => $networkInfo[ self::DATESTAMP_TAG ],				
    				self::NAME_TAG		  => $networkInfo[ self::NAME_TAG ],
    				self::VALID_TAG 	  => $networkInfo[self::VALID_TAG], 
    				self::TRANSFORMED_TAG => $networkInfo[self::TRANSFORMED_TAG], 
    				self::TOTAL_TAG 	  => $networkInfo[self::TOTAL_TAG]
    				 
    		) ); 
    		
    	}
    	
    	$response[ "total" ] = $aggrInfo;
    	$response[ "networks"] = $networks;
    	
    	return $response;
    }
    
    /**
     * Get the total count of a field.
     *
     * @param string $field What field of data are we researching?
     * @param array  $value Extra options for search. Value => match this value
     *
     * @return array*/
    
    public function getHarvestingHistory()
    { 
    	return $this->callJSONService( $this->BackendWSBaseURL."/public/listNetworksHistory" );
    }
         

    
    private function callJSONService($serviceURL) {
    	return json_decode( file_get_contents($serviceURL), true );   	 
    }
    
    


}
