<?php

/**
 * Search backend interface definition.
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
 * @package  Search
 * @author   David Maus <maus@hab.de>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     http://vufind.org
 */

namespace VuFindSearch\Backend;

use VuFindSearch\Query\AbstractQuery;
use VuFindSearch\Query\QueryGroup;
use VuFindSearch\Query\Query;

use VuFindSearch\ParamBag;

/**
 * Search backend interface definition.
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
 * @package  Search
 * @author   David Maus <maus@hab.de>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     http://vufind.org
 */
interface BackendInterface
{

    /**
     * Perform a search and return record collection.
     *
     * @param AbstractQuery $query  Search query
     * @param integer       $offset Search offset
     * @param integer       $limit  Search limit
     * @param ParamBag      $params Search backend parameters
     *
     * @return RecordCollectionInterface
     */
    public function search (AbstractQuery $query, $offset, $limit, ParamBag $params = null);

    /**
     * Retrieve a single document.
     *
     * @param string   $id     Document identifier
     * @param ParamBag $params Search backend parameters
     *
     * @return RecordCollectionInterface
     */
    public function retrieve ($id, ParamBag $params = null);

    /**
     * Delete a single record.
     *
     * @param string   $id     Record identifier
     * @param ParamBag $params Search backend parameters
     *
     * @return RecordCollectionInterface
     *
     * @todo Relocate to WritableBackendInterface
     */
    public function delete ($id, ParamBag $params = null);

    /**
     * Return similar records.
     *
     * @param string   $id     Id of record to compare with
     * @param ParamBag $params Search backend parameters
     *
     * @return RecordCollectionInterface
     */
    public function similar ($id, ParamBag $params = null);
}