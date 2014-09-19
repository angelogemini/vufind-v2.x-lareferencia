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
    	 
    	$response = $this->solrStatsBackend->search($query, 1, 10, $params);
    	
    	return $response->getFacets();
    
    }


}
