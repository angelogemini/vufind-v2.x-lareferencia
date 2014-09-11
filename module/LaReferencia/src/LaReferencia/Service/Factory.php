<?php
/**
 * Factory for various top-level VuFind services.
 *
 * PHP version 5
 *
 * Copyright (C) Villanova University 2014.
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
 * @package  Service
 * @author   Demian Katz <demian.katz@villanova.edu>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     http://vufind.org/wiki/vufind2:developer_manual Wiki
 */
namespace LaReferencia\Service;

use Zend\ServiceManager\ServiceManager;

/**
 * Factory for various top-level VuFind services.
 *
 * @category VuFind2
 * @package  Service
 * @author   Demian Katz <demian.katz@villanova.edu>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     http://vufind.org/wiki/vufind2:developer_manual Wiki
 */
class Factory
{
    
    /**
     * Construct the record stats helper.
     *
     * @param ServiceManager $sm Service manager.
     *
     * @return \VuFind\Statistics\Record
     */
    public static function getRecordStats(ServiceManager $sm)
    {
        return new \VuFind\Statistics\Record(
            $sm->get('VuFind\Config')->get('config'),
            $sm->get('VuFind\StatisticsDriverPluginManager'),
            $sm->get('VuFind\SessionManager')->getId()
        );
    }


     /**
     * Construct the record stats helper.
     *
     * @param ServiceManager $sm Service manager.
     *
     * @return \VuFind\Statistics\Record
     */
    public static function getSolrStats(ServiceManager $sm)
    {
        //$sm->getServiceLocator()->get('VuFind\Search\BackendManager')->get('SolrStats')
        
        return new \LaReferencia\Statistics\SolrStats( $sm->get('VuFind\Search\BackendManager')->get('SolrStats') ); 
    }    


    /**
     * Construct the search stats helper.
     *
     * @param ServiceManager $sm Service manager.
     *
     * @return \VuFind\Statistics\Search
     */
    public static function getSearchStats(ServiceManager $sm)
    {
        return new \VuFind\Statistics\Search(
            $sm->get('VuFind\Config')->get('config'),
            $sm->get('VuFind\StatisticsDriverPluginManager'),
            $sm->get('VuFind\SessionManager')->getId()
        );
    }

   
}
