<?php
/**
 * Model for Primo Central records.
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
 * @package  RecordDrivers
 * @author   Demian Katz <demian.katz@villanova.edu>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     http://vufind.org/wiki/vufind2:record_drivers Wiki
 */
namespace VuFind\RecordDriver;

/**
 * Model for Primo Central records.
 *
 * @category VuFind2
 * @package  RecordDrivers
 * @author   Demian Katz <demian.katz@villanova.edu>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     http://vufind.org/wiki/vufind2:record_drivers Wiki
 */
class Primo extends SolrDefault
{
    /**
     * Date converter
     *
     * @var \VuFind\Date\Converter
     */
    protected $dateConverter = null;

    /**
     * Get the short (pre-subtitle) title of the record.
     *
     * @return string
     */
    public function getShortTitle()
    {
        return $this->getTitle();
    }

    /**
     * Get the full title of the record.
     *
     * @return string
     */
    public function getTitle()
    {
        return isset($this->fields['title'])
            ? $this->fields['title'] : '';
    }

    /**
     * Get the authors of the record.
     *
     * @return array
     */
    public function getCreators()
    {
        return isset($this->fields['creator'])
            ? $this->fields['creator'] : array();
    }

    /**
     * Get an array of all subject headings associated with the record
     * (may be empty).
     *
     * @return array
     */
    public function getAllSubjectHeadings()
    {
        return isset($this->fields['subjects'])
            ? $this->fields['subjects'] : array();
    }

    /**
     * Get the item's source.
     *
     * @return array
     */
    public function getSource()
    {
        return isset($this->fields['ispartof'])
            ? $this->fields['ispartof'] : array();
    }

    /**
     * Get the item's description.
     *
     * @return array
     */
    public function getDescription()
    {
        return isset($this->fields['description'])
            ? $this->fields['description'] : array();
    }

    /**
     * Get the item's collection.
     *
     * @return array
     */
    public function getCollection()
    {
        return isset($this->fields['source'])
            ? $this->fields['source'] : array();
    }

    /**
     * Get an array of all ISSNs associated with the record (may be empty).
     *
     * @return array
     */
    public function getISSNs()
    {
        $issns = array();
        if (isset($this->fields['issn'])) {
            $issns = $this->fields['issn'];
        }
        return $issns;
    }

    /**
     * Get the language associated with the record.
     *
     * @return String
     */
    public function getLanguages()
    {
        return isset($this->fields['language'])
            ? (array)$this->fields['language'] : array();
    }

    /**
     * Returns one of three things: a full URL to a thumbnail preview of the record
     * if an image is available in an external system; an array of parameters to
     * send to VuFind's internal cover generator if no fixed URL exists; or false
     * if no thumbnail can be generated.
     *
     * @param string $size Size of thumbnail (small, medium or large -- small is
     * default).
     *
     * @return string|array|bool
     */
    public function getThumbnail($size = 'small')
    {
        if ($isbn = $this->getCleanISBN()) {
            return array('size' => $size, 'isn' => $isbn);
        }
        return array('size' => $size, 'contenttype' => 'JournalArticle');
    }

    /**
     * Return an array of associative URL arrays with one or more of the following
     * keys:
     *
     * <li>
     *   <ul>desc: URL description text to display (optional)</ul>
     *   <ul>url: fully-formed URL (required if 'route' is absent)</ul>
     *   <ul>route: VuFind route to build URL with (required if 'url' is absent)</ul>
     *   <ul>routeParams: Parameters for route (optional)</ul>
     *   <ul>queryString: Query params to append after building route (optional)</ul>
     * </li>
     *
     * @return array
     */
    public function getURLs()
    {
        $retVal = array();

        if (isset($this->fields['url'])) {
            $retVal[] = array();
            $retVal[0]['url'] = $this->fields['url'];
            if (isset($this->fields['fulltext'])) {
                $desc = $this->fields['fulltext'] == 'fulltext'
                    ? 'Get full text' : 'Request full text';
                $retVal[0]['desc'] = $this->translate($desc);
            }
        }

        return $retVal;
    }

    /**
     * Return the unique identifier of this record within the Solr index;
     * useful for retrieving additional information (like tags and user
     * comments) from the external MySQL database.
     *
     * @return string Unique identifier.
     */
    public function getUniqueID()
    {
        return $this->fields['recordid'];
    }

    /**
     * Get an array of strings representing citation formats supported
     * by this record's data (empty if none).  For possible legal values,
     * see /application/themes/root/helpers/Citation.php, getCitation()
     * method.
     *
     * @return array Strings representing citation formats.
     */
    protected function getSupportedCitationFormats()
    {
        return array();
    }
}
