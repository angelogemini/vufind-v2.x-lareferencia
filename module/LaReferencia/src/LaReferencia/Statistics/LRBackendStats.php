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
    protected $solrBackendMngr;
    protected $solrBiblioBackend;
    protected $solrStatsBackend;
    
    const VALID_TAG = "validSize";
    const TRANSFORMED_TAG = "transformedSize";
    const TOTAL_TAG = "size";
    const NAME_TAG = "name";
    
    
    /**
     * Constructor
     *
     * @param Backend $backend Solr backend
     */
    public function __construct()
    {

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
    	$networksInfoArray = $this->callJSONService( "http://localhost:8090/public/listNetworks" );
    	
    	$aggrInfo = array(self::VALID_TAG => 0, self::TRANSFORMED_TAG => 0, self::TOTAL_TAG => 0);
    	$response  = array();
    	$networks = array();
    	
    	foreach ($networksInfoArray as $networkInfo) {
	
    		$aggrInfo[self::TOTAL_TAG] = $aggrInfo[self::TOTAL_TAG] + $networkInfo[self::TOTAL_TAG];	
    		$aggrInfo[self::TRANSFORMED_TAG] = $aggrInfo[self::TRANSFORMED_TAG] + $networkInfo[self::TRANSFORMED_TAG];
    		$aggrInfo[self::VALID_TAG] = $aggrInfo[self::VALID_TAG] + $networkInfo[self::VALID_TAG];
    		
    		
    		array_push($networks, array(
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
    	return $this->callJSONService( "http://localhost:8090/public/listValidPublicSnapshotsStats" );
    }
         

    
    private function callJSONService($serviceURL) {
    	return json_decode( file_get_contents($serviceURL), true );   	 
    }
    
    


}
