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
class SolrStats
{
    
    /**
     * Solr backend
     *
     * @var Backend
     */
    protected $solrBackendMngr;
    protected $solrBiblioBackend;
    protected $solrStatsBackend;
    

    /**
     * Constructor
     *
     * @param Backend $backend Solr backend
     */
    public function __construct(BackendManager $backendMngr)
    {
        $this->solrBackendMngr = $backendMngr;
        $this->solrBiblioBackend = $backendMngr->get("Solr");
        $this->solrStatsBackend =  $backendMngr->get("SolrStats");
    }
    
    /**
     * Get the total count of a field.
     *
     * @param string $field What field of data are we researching?
     * @param array  $value Extra options for search. Value => match this value
     *
     * @return array
     */
    public function getClicksPerSource()
    {
    	$query = new Query('*:*');
    	$params = new ParamBag();
    	$params->add('fl', '');

        $params->add('facet', 'true');
    	$params->add('facet.pivot', 'year_month,recordSource');
    	 
    	$response = $this->solrStatsBackend->search($query, 0, 0, $params);
    	
    	return $response->getFacets();
    }
    
    /**
     * Get the total count of a field.
     *
     * @param string $field What field of data are we researching?
     * @param array  $value Extra options for search. Value => match this value
     *
     * @return array
     */
    public function getFieldsCountPerNetwork($fieldsArray, $limit)
    {
    	$query = new Query('*:*');
    	$params = new ParamBag();
    	$params->add('fl', '');
    	$params->add('facet', 'true');
    	
    	$params->add('facet.field', "network_name");
    	$params->add('facet.sort', "count");
    	$params->add('facet.limit', $limit);
    	$params->add('facet.mincount', 2);
    	
    	
    	foreach ($fieldsArray as $field) {
    		$params->add('facet.field', $field);
    		$params->add('facet.pivot', 'network_name,'.$field);
    	}
    	    
    	$response = $this->solrBiblioBackend->search($query, 0, 0, $params);
    
    	
    	 
    	return $this->solrResponseToFacetsArray($response);
    }
    
    
    public function solrResponseToFacetsArray($solrResponse) {
    	
    	$response = array();
    	$response["fields"] = array();
    	    	
    	foreach ($solrResponse->getFacets()->getFieldFacets()->getArrayCopy() as $key => $value) {		
    		$response["fields"][$key] = array( "values" => array() );
    		
    		foreach($value->toArray() as $f_value => $f_count) {			
    			array_push( $response["fields"][$key]["values"], array( "label" => $f_value, "value" => $f_count ));		
    		}
    	}
    		
    	$response["pivots"] = array(); 
    	foreach ($solrResponse->getFacets()->getPivotFacets()->getArrayCopy() as $key => $value) {
    		
    		$response["pivots"][$key]["values"] = array();
    				
    		foreach($value["pivot"] as $pivot) {
    			unset($pivot["field"]);
    			array_push( $response["pivots"][$key]["values"], array( "label" => $pivot["value"], "value" => $pivot["count"] ) );
    		
    		} 
    	}
    	
    	return $response;
    }
}
