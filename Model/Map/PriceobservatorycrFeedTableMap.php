<?php

namespace PriceObservatoryCR\Model\Map;

use PriceObservatoryCR\Model\PriceobservatorycrFeed;
use PriceObservatoryCR\Model\PriceobservatorycrFeedQuery;
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
 * This class defines the structure of the 'priceobservatorycr_feed' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class PriceobservatorycrFeedTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'PriceObservatoryCR.Model.Map.PriceobservatorycrFeedTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'priceobservatorycr_feed';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\PriceObservatoryCR\\Model\\PriceobservatorycrFeed';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'PriceObservatoryCR.Model.PriceobservatorycrFeed';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 5;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 5;

    /**
     * the column name for the ID field
     */
    const ID = 'priceobservatorycr_feed.ID';

    /**
     * the column name for the LABEL field
     */
    const LABEL = 'priceobservatorycr_feed.LABEL';

    /**
     * the column name for the LANG_ID field
     */
    const LANG_ID = 'priceobservatorycr_feed.LANG_ID';

    /**
     * the column name for the CURRENCY_ID field
     */
    const CURRENCY_ID = 'priceobservatorycr_feed.CURRENCY_ID';

    /**
     * the column name for the COUNTRY_ID field
     */
    const COUNTRY_ID = 'priceobservatorycr_feed.COUNTRY_ID';

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
        self::TYPE_PHPNAME       => array('Id', 'Label', 'LangId', 'CurrencyId', 'CountryId', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'label', 'langId', 'currencyId', 'countryId', ),
        self::TYPE_COLNAME       => array(PriceobservatorycrFeedTableMap::ID, PriceobservatorycrFeedTableMap::LABEL, PriceobservatorycrFeedTableMap::LANG_ID, PriceobservatorycrFeedTableMap::CURRENCY_ID, PriceobservatorycrFeedTableMap::COUNTRY_ID, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'LABEL', 'LANG_ID', 'CURRENCY_ID', 'COUNTRY_ID', ),
        self::TYPE_FIELDNAME     => array('id', 'label', 'lang_id', 'currency_id', 'country_id', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Label' => 1, 'LangId' => 2, 'CurrencyId' => 3, 'CountryId' => 4, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'label' => 1, 'langId' => 2, 'currencyId' => 3, 'countryId' => 4, ),
        self::TYPE_COLNAME       => array(PriceobservatorycrFeedTableMap::ID => 0, PriceobservatorycrFeedTableMap::LABEL => 1, PriceobservatorycrFeedTableMap::LANG_ID => 2, PriceobservatorycrFeedTableMap::CURRENCY_ID => 3, PriceobservatorycrFeedTableMap::COUNTRY_ID => 4, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'LABEL' => 1, 'LANG_ID' => 2, 'CURRENCY_ID' => 3, 'COUNTRY_ID' => 4, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'label' => 1, 'lang_id' => 2, 'currency_id' => 3, 'country_id' => 4, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
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
        $this->setName('priceobservatorycr_feed');
        $this->setPhpName('PriceobservatorycrFeed');
        $this->setClassName('\\PriceObservatoryCR\\Model\\PriceobservatorycrFeed');
        $this->setPackage('PriceObservatoryCR.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('LABEL', 'Label', 'VARCHAR', false, 255, null);
        $this->addForeignKey('LANG_ID', 'LangId', 'INTEGER', 'lang', 'ID', true, null, null);
        $this->addForeignKey('CURRENCY_ID', 'CurrencyId', 'INTEGER', 'currency', 'ID', true, null, null);
        $this->addForeignKey('COUNTRY_ID', 'CountryId', 'INTEGER', 'country', 'ID', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Lang', '\\Thelia\\Model\\Lang', RelationMap::MANY_TO_ONE, array('lang_id' => 'id', ), 'CASCADE', 'RESTRICT');
        $this->addRelation('Currency', '\\Thelia\\Model\\Currency', RelationMap::MANY_TO_ONE, array('currency_id' => 'id', ), 'CASCADE', 'RESTRICT');
        $this->addRelation('Country', '\\Thelia\\Model\\Country', RelationMap::MANY_TO_ONE, array('country_id' => 'id', ), 'CASCADE', 'RESTRICT');
        $this->addRelation('PriceobservatorycrLog', '\\PriceObservatoryCR\\Model\\PriceobservatorycrLog', RelationMap::ONE_TO_MANY, array('id' => 'feed_id', ), 'CASCADE', 'RESTRICT', 'PriceobservatorycrLogs');
    } // buildRelations()
    /**
     * Method to invalidate the instance pool of all tables related to priceobservatorycr_feed     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in ".$this->getClassNameFromBuilder($joinedTableTableMapBuilder)." instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
                PriceobservatorycrLogTableMap::clearInstancePool();
            }

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
        return $withPrefix ? PriceobservatorycrFeedTableMap::CLASS_DEFAULT : PriceobservatorycrFeedTableMap::OM_CLASS;
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
     * @return array (PriceobservatorycrFeed object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PriceobservatorycrFeedTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PriceobservatorycrFeedTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PriceobservatorycrFeedTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PriceobservatorycrFeedTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PriceobservatorycrFeedTableMap::addInstanceToPool($obj, $key);
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
            $key = PriceobservatorycrFeedTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PriceobservatorycrFeedTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PriceobservatorycrFeedTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(PriceobservatorycrFeedTableMap::ID);
            $criteria->addSelectColumn(PriceobservatorycrFeedTableMap::LABEL);
            $criteria->addSelectColumn(PriceobservatorycrFeedTableMap::LANG_ID);
            $criteria->addSelectColumn(PriceobservatorycrFeedTableMap::CURRENCY_ID);
            $criteria->addSelectColumn(PriceobservatorycrFeedTableMap::COUNTRY_ID);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.LABEL');
            $criteria->addSelectColumn($alias . '.LANG_ID');
            $criteria->addSelectColumn($alias . '.CURRENCY_ID');
            $criteria->addSelectColumn($alias . '.COUNTRY_ID');
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
        return Propel::getServiceContainer()->getDatabaseMap(PriceobservatorycrFeedTableMap::DATABASE_NAME)->getTable(PriceobservatorycrFeedTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(PriceobservatorycrFeedTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(PriceobservatorycrFeedTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new PriceobservatorycrFeedTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a PriceobservatorycrFeed or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or PriceobservatorycrFeed object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PriceobservatorycrFeedTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \PriceObservatoryCR\Model\PriceobservatorycrFeed) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PriceobservatorycrFeedTableMap::DATABASE_NAME);
            $criteria->add(PriceobservatorycrFeedTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = PriceobservatorycrFeedQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { PriceobservatorycrFeedTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { PriceobservatorycrFeedTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the priceobservatorycr_feed table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PriceobservatorycrFeedQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a PriceobservatorycrFeed or Criteria object.
     *
     * @param mixed               $criteria Criteria or PriceobservatorycrFeed object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PriceobservatorycrFeedTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from PriceobservatorycrFeed object
        }

        if ($criteria->containsKey(PriceobservatorycrFeedTableMap::ID) && $criteria->keyContainsValue(PriceobservatorycrFeedTableMap::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.PriceobservatorycrFeedTableMap::ID.')');
        }


        // Set the correct dbName
        $query = PriceobservatorycrFeedQuery::create()->mergeWith($criteria);

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

} // PriceobservatorycrFeedTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PriceobservatorycrFeedTableMap::buildTableMap();
