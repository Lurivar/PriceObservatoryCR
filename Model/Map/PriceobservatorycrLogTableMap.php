<?php

namespace PriceObservatoryCR\Model\Map;

use PriceObservatoryCR\Model\PriceobservatorycrLog;
use PriceObservatoryCR\Model\PriceobservatorycrLogQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'priceobservatorycr_log' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class PriceobservatorycrLogTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'PriceObservatoryCR.Model.Map.PriceobservatorycrLogTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'priceobservatorycr_log';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\PriceObservatoryCR\\Model\\PriceobservatorycrLog';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'PriceObservatoryCR.Model.PriceobservatorycrLog';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 9;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 9;

    /**
     * the column name for the ID field
     */
    const ID = 'priceobservatorycr_log.ID';

    /**
     * the column name for the FEED_ID field
     */
    const FEED_ID = 'priceobservatorycr_log.FEED_ID';

    /**
     * the column name for the SEPARATION field
     */
    const SEPARATION = 'priceobservatorycr_log.SEPARATION';

    /**
     * the column name for the LEVEL field
     */
    const LEVEL = 'priceobservatorycr_log.LEVEL';

    /**
     * the column name for the PSE_ID field
     */
    const PSE_ID = 'priceobservatorycr_log.PSE_ID';

    /**
     * the column name for the MESSAGE field
     */
    const MESSAGE = 'priceobservatorycr_log.MESSAGE';

    /**
     * the column name for the HELP field
     */
    const HELP = 'priceobservatorycr_log.HELP';

    /**
     * the column name for the CREATED_AT field
     */
    const CREATED_AT = 'priceobservatorycr_log.CREATED_AT';

    /**
     * the column name for the UPDATED_AT field
     */
    const UPDATED_AT = 'priceobservatorycr_log.UPDATED_AT';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'FeedId', 'Separation', 'Level', 'PseId', 'Message', 'Help', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'feedId', 'separation', 'level', 'pseId', 'message', 'help', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(PriceobservatorycrLogTableMap::ID, PriceobservatorycrLogTableMap::FEED_ID, PriceobservatorycrLogTableMap::SEPARATION, PriceobservatorycrLogTableMap::LEVEL, PriceobservatorycrLogTableMap::PSE_ID, PriceobservatorycrLogTableMap::MESSAGE, PriceobservatorycrLogTableMap::HELP, PriceobservatorycrLogTableMap::CREATED_AT, PriceobservatorycrLogTableMap::UPDATED_AT, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'FEED_ID', 'SEPARATION', 'LEVEL', 'PSE_ID', 'MESSAGE', 'HELP', 'CREATED_AT', 'UPDATED_AT', ),
        self::TYPE_FIELDNAME     => array('id', 'feed_id', 'separation', 'level', 'pse_id', 'message', 'help', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'FeedId' => 1, 'Separation' => 2, 'Level' => 3, 'PseId' => 4, 'Message' => 5, 'Help' => 6, 'CreatedAt' => 7, 'UpdatedAt' => 8, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'feedId' => 1, 'separation' => 2, 'level' => 3, 'pseId' => 4, 'message' => 5, 'help' => 6, 'createdAt' => 7, 'updatedAt' => 8, ),
        self::TYPE_COLNAME       => array(PriceobservatorycrLogTableMap::ID => 0, PriceobservatorycrLogTableMap::FEED_ID => 1, PriceobservatorycrLogTableMap::SEPARATION => 2, PriceobservatorycrLogTableMap::LEVEL => 3, PriceobservatorycrLogTableMap::PSE_ID => 4, PriceobservatorycrLogTableMap::MESSAGE => 5, PriceobservatorycrLogTableMap::HELP => 6, PriceobservatorycrLogTableMap::CREATED_AT => 7, PriceobservatorycrLogTableMap::UPDATED_AT => 8, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'FEED_ID' => 1, 'SEPARATION' => 2, 'LEVEL' => 3, 'PSE_ID' => 4, 'MESSAGE' => 5, 'HELP' => 6, 'CREATED_AT' => 7, 'UPDATED_AT' => 8, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'feed_id' => 1, 'separation' => 2, 'level' => 3, 'pse_id' => 4, 'message' => 5, 'help' => 6, 'created_at' => 7, 'updated_at' => 8, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('priceobservatorycr_log');
        $this->setPhpName('PriceobservatorycrLog');
        $this->setClassName('\\PriceObservatoryCR\\Model\\PriceobservatorycrLog');
        $this->setPackage('PriceObservatoryCR.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('FEED_ID', 'FeedId', 'INTEGER', 'priceobservatorycr_feed', 'ID', true, null, null);
        $this->addColumn('SEPARATION', 'Separation', 'BOOLEAN', true, 1, null);
        $this->addColumn('LEVEL', 'Level', 'INTEGER', true, null, null);
        $this->addForeignKey('PSE_ID', 'PseId', 'INTEGER', 'product_sale_elements', 'ID', false, null, null);
        $this->addColumn('MESSAGE', 'Message', 'LONGVARCHAR', true, null, null);
        $this->addColumn('HELP', 'Help', 'LONGVARCHAR', false, null, null);
        $this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('PriceobservatorycrFeed', '\\PriceObservatoryCR\\Model\\PriceobservatorycrFeed', RelationMap::MANY_TO_ONE, array('feed_id' => 'id', ), 'CASCADE', 'RESTRICT');
        $this->addRelation('ProductSaleElements', '\\Thelia\\Model\\ProductSaleElements', RelationMap::MANY_TO_ONE, array('pse_id' => 'id', ), 'CASCADE', 'RESTRICT');
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', ),
        );
    } // getBehaviors()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {

            return (int) $row[
                            $indexType == TableMap::TYPE_NUM
                            ? 0 + $offset
                            : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
                        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? PriceobservatorycrLogTableMap::CLASS_DEFAULT : PriceobservatorycrLogTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     * @return array (PriceobservatorycrLog object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PriceobservatorycrLogTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PriceobservatorycrLogTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PriceobservatorycrLogTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PriceobservatorycrLogTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PriceobservatorycrLogTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = PriceobservatorycrLogTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PriceobservatorycrLogTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PriceobservatorycrLogTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(PriceobservatorycrLogTableMap::ID);
            $criteria->addSelectColumn(PriceobservatorycrLogTableMap::FEED_ID);
            $criteria->addSelectColumn(PriceobservatorycrLogTableMap::SEPARATION);
            $criteria->addSelectColumn(PriceobservatorycrLogTableMap::LEVEL);
            $criteria->addSelectColumn(PriceobservatorycrLogTableMap::PSE_ID);
            $criteria->addSelectColumn(PriceobservatorycrLogTableMap::MESSAGE);
            $criteria->addSelectColumn(PriceobservatorycrLogTableMap::HELP);
            $criteria->addSelectColumn(PriceobservatorycrLogTableMap::CREATED_AT);
            $criteria->addSelectColumn(PriceobservatorycrLogTableMap::UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.FEED_ID');
            $criteria->addSelectColumn($alias . '.SEPARATION');
            $criteria->addSelectColumn($alias . '.LEVEL');
            $criteria->addSelectColumn($alias . '.PSE_ID');
            $criteria->addSelectColumn($alias . '.MESSAGE');
            $criteria->addSelectColumn($alias . '.HELP');
            $criteria->addSelectColumn($alias . '.CREATED_AT');
            $criteria->addSelectColumn($alias . '.UPDATED_AT');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(PriceobservatorycrLogTableMap::DATABASE_NAME)->getTable(PriceobservatorycrLogTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(PriceobservatorycrLogTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(PriceobservatorycrLogTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new PriceobservatorycrLogTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a PriceobservatorycrLog or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or PriceobservatorycrLog object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PriceobservatorycrLogTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \PriceObservatoryCR\Model\PriceobservatorycrLog) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PriceobservatorycrLogTableMap::DATABASE_NAME);
            $criteria->add(PriceobservatorycrLogTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = PriceobservatorycrLogQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { PriceobservatorycrLogTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { PriceobservatorycrLogTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the priceobservatorycr_log table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PriceobservatorycrLogQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a PriceobservatorycrLog or Criteria object.
     *
     * @param mixed               $criteria Criteria or PriceobservatorycrLog object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PriceobservatorycrLogTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from PriceobservatorycrLog object
        }

        if ($criteria->containsKey(PriceobservatorycrLogTableMap::ID) && $criteria->keyContainsValue(PriceobservatorycrLogTableMap::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.PriceobservatorycrLogTableMap::ID.')');
        }


        // Set the correct dbName
        $query = PriceobservatorycrLogQuery::create()->mergeWith($criteria);

        try {
            // use transaction because $criteria could contain info
            // for more than one table (I guess, conceivably)
            $con->beginTransaction();
            $pk = $query->doInsert($con);
            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $pk;
    }

} // PriceobservatorycrLogTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PriceobservatorycrLogTableMap::buildTableMap();
