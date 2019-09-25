<?php

namespace PriceObservatoryCR\Model\Base;

use \Exception;
use \PDO;
use PriceObservatoryCR\Model\PriceobservatorycrLog as ChildPriceobservatorycrLog;
use PriceObservatoryCR\Model\PriceobservatorycrLogQuery as ChildPriceobservatorycrLogQuery;
use PriceObservatoryCR\Model\Map\PriceobservatorycrLogTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Thelia\Model\ProductSaleElements;

/**
 * Base class that represents a query for the 'priceobservatorycr_log' table.
 *
 *
 *
 * @method     ChildPriceobservatorycrLogQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPriceobservatorycrLogQuery orderByFeedId($order = Criteria::ASC) Order by the feed_id column
 * @method     ChildPriceobservatorycrLogQuery orderBySeparation($order = Criteria::ASC) Order by the separation column
 * @method     ChildPriceobservatorycrLogQuery orderByLevel($order = Criteria::ASC) Order by the level column
 * @method     ChildPriceobservatorycrLogQuery orderByPseId($order = Criteria::ASC) Order by the pse_id column
 * @method     ChildPriceobservatorycrLogQuery orderByMessage($order = Criteria::ASC) Order by the message column
 * @method     ChildPriceobservatorycrLogQuery orderByHelp($order = Criteria::ASC) Order by the help column
 * @method     ChildPriceobservatorycrLogQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildPriceobservatorycrLogQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildPriceobservatorycrLogQuery groupById() Group by the id column
 * @method     ChildPriceobservatorycrLogQuery groupByFeedId() Group by the feed_id column
 * @method     ChildPriceobservatorycrLogQuery groupBySeparation() Group by the separation column
 * @method     ChildPriceobservatorycrLogQuery groupByLevel() Group by the level column
 * @method     ChildPriceobservatorycrLogQuery groupByPseId() Group by the pse_id column
 * @method     ChildPriceobservatorycrLogQuery groupByMessage() Group by the message column
 * @method     ChildPriceobservatorycrLogQuery groupByHelp() Group by the help column
 * @method     ChildPriceobservatorycrLogQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildPriceobservatorycrLogQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildPriceobservatorycrLogQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPriceobservatorycrLogQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPriceobservatorycrLogQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPriceobservatorycrLogQuery leftJoinPriceobservatorycrFeed($relationAlias = null) Adds a LEFT JOIN clause to the query using the PriceobservatorycrFeed relation
 * @method     ChildPriceobservatorycrLogQuery rightJoinPriceobservatorycrFeed($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PriceobservatorycrFeed relation
 * @method     ChildPriceobservatorycrLogQuery innerJoinPriceobservatorycrFeed($relationAlias = null) Adds a INNER JOIN clause to the query using the PriceobservatorycrFeed relation
 *
 * @method     ChildPriceobservatorycrLogQuery leftJoinProductSaleElements($relationAlias = null) Adds a LEFT JOIN clause to the query using the ProductSaleElements relation
 * @method     ChildPriceobservatorycrLogQuery rightJoinProductSaleElements($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ProductSaleElements relation
 * @method     ChildPriceobservatorycrLogQuery innerJoinProductSaleElements($relationAlias = null) Adds a INNER JOIN clause to the query using the ProductSaleElements relation
 *
 * @method     ChildPriceobservatorycrLog findOne(ConnectionInterface $con = null) Return the first ChildPriceobservatorycrLog matching the query
 * @method     ChildPriceobservatorycrLog findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPriceobservatorycrLog matching the query, or a new ChildPriceobservatorycrLog object populated from the query conditions when no match is found
 *
 * @method     ChildPriceobservatorycrLog findOneById(int $id) Return the first ChildPriceobservatorycrLog filtered by the id column
 * @method     ChildPriceobservatorycrLog findOneByFeedId(int $feed_id) Return the first ChildPriceobservatorycrLog filtered by the feed_id column
 * @method     ChildPriceobservatorycrLog findOneBySeparation(boolean $separation) Return the first ChildPriceobservatorycrLog filtered by the separation column
 * @method     ChildPriceobservatorycrLog findOneByLevel(int $level) Return the first ChildPriceobservatorycrLog filtered by the level column
 * @method     ChildPriceobservatorycrLog findOneByPseId(int $pse_id) Return the first ChildPriceobservatorycrLog filtered by the pse_id column
 * @method     ChildPriceobservatorycrLog findOneByMessage(string $message) Return the first ChildPriceobservatorycrLog filtered by the message column
 * @method     ChildPriceobservatorycrLog findOneByHelp(string $help) Return the first ChildPriceobservatorycrLog filtered by the help column
 * @method     ChildPriceobservatorycrLog findOneByCreatedAt(string $created_at) Return the first ChildPriceobservatorycrLog filtered by the created_at column
 * @method     ChildPriceobservatorycrLog findOneByUpdatedAt(string $updated_at) Return the first ChildPriceobservatorycrLog filtered by the updated_at column
 *
 * @method     array findById(int $id) Return ChildPriceobservatorycrLog objects filtered by the id column
 * @method     array findByFeedId(int $feed_id) Return ChildPriceobservatorycrLog objects filtered by the feed_id column
 * @method     array findBySeparation(boolean $separation) Return ChildPriceobservatorycrLog objects filtered by the separation column
 * @method     array findByLevel(int $level) Return ChildPriceobservatorycrLog objects filtered by the level column
 * @method     array findByPseId(int $pse_id) Return ChildPriceobservatorycrLog objects filtered by the pse_id column
 * @method     array findByMessage(string $message) Return ChildPriceobservatorycrLog objects filtered by the message column
 * @method     array findByHelp(string $help) Return ChildPriceobservatorycrLog objects filtered by the help column
 * @method     array findByCreatedAt(string $created_at) Return ChildPriceobservatorycrLog objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return ChildPriceobservatorycrLog objects filtered by the updated_at column
 *
 */
abstract class PriceobservatorycrLogQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \PriceObservatoryCR\Model\Base\PriceobservatorycrLogQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\PriceObservatoryCR\\Model\\PriceobservatorycrLog', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPriceobservatorycrLogQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPriceobservatorycrLogQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \PriceObservatoryCR\Model\PriceobservatorycrLogQuery) {
            return $criteria;
        }
        $query = new \PriceObservatoryCR\Model\PriceobservatorycrLogQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildPriceobservatorycrLog|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PriceobservatorycrLogTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PriceobservatorycrLogTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return   ChildPriceobservatorycrLog A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, FEED_ID, SEPARATION, LEVEL, PSE_ID, MESSAGE, HELP, CREATED_AT, UPDATED_AT FROM priceobservatorycr_log WHERE ID = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            $obj = new ChildPriceobservatorycrLog();
            $obj->hydrate($row);
            PriceobservatorycrLogTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildPriceobservatorycrLog|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return ChildPriceobservatorycrLogQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PriceobservatorycrLogTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildPriceobservatorycrLogQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PriceobservatorycrLogTableMap::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPriceobservatorycrLogQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PriceobservatorycrLogTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PriceobservatorycrLogTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PriceobservatorycrLogTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the feed_id column
     *
     * Example usage:
     * <code>
     * $query->filterByFeedId(1234); // WHERE feed_id = 1234
     * $query->filterByFeedId(array(12, 34)); // WHERE feed_id IN (12, 34)
     * $query->filterByFeedId(array('min' => 12)); // WHERE feed_id > 12
     * </code>
     *
     * @see       filterByPriceobservatorycrFeed()
     *
     * @param     mixed $feedId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPriceobservatorycrLogQuery The current query, for fluid interface
     */
    public function filterByFeedId($feedId = null, $comparison = null)
    {
        if (is_array($feedId)) {
            $useMinMax = false;
            if (isset($feedId['min'])) {
                $this->addUsingAlias(PriceobservatorycrLogTableMap::FEED_ID, $feedId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($feedId['max'])) {
                $this->addUsingAlias(PriceobservatorycrLogTableMap::FEED_ID, $feedId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PriceobservatorycrLogTableMap::FEED_ID, $feedId, $comparison);
    }

    /**
     * Filter the query on the separation column
     *
     * Example usage:
     * <code>
     * $query->filterBySeparation(true); // WHERE separation = true
     * $query->filterBySeparation('yes'); // WHERE separation = true
     * </code>
     *
     * @param     boolean|string $separation The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPriceobservatorycrLogQuery The current query, for fluid interface
     */
    public function filterBySeparation($separation = null, $comparison = null)
    {
        if (is_string($separation)) {
            $separation = in_array(strtolower($separation), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PriceobservatorycrLogTableMap::SEPARATION, $separation, $comparison);
    }

    /**
     * Filter the query on the level column
     *
     * Example usage:
     * <code>
     * $query->filterByLevel(1234); // WHERE level = 1234
     * $query->filterByLevel(array(12, 34)); // WHERE level IN (12, 34)
     * $query->filterByLevel(array('min' => 12)); // WHERE level > 12
     * </code>
     *
     * @param     mixed $level The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPriceobservatorycrLogQuery The current query, for fluid interface
     */
    public function filterByLevel($level = null, $comparison = null)
    {
        if (is_array($level)) {
            $useMinMax = false;
            if (isset($level['min'])) {
                $this->addUsingAlias(PriceobservatorycrLogTableMap::LEVEL, $level['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($level['max'])) {
                $this->addUsingAlias(PriceobservatorycrLogTableMap::LEVEL, $level['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PriceobservatorycrLogTableMap::LEVEL, $level, $comparison);
    }

    /**
     * Filter the query on the pse_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPseId(1234); // WHERE pse_id = 1234
     * $query->filterByPseId(array(12, 34)); // WHERE pse_id IN (12, 34)
     * $query->filterByPseId(array('min' => 12)); // WHERE pse_id > 12
     * </code>
     *
     * @see       filterByProductSaleElements()
     *
     * @param     mixed $pseId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPriceobservatorycrLogQuery The current query, for fluid interface
     */
    public function filterByPseId($pseId = null, $comparison = null)
    {
        if (is_array($pseId)) {
            $useMinMax = false;
            if (isset($pseId['min'])) {
                $this->addUsingAlias(PriceobservatorycrLogTableMap::PSE_ID, $pseId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pseId['max'])) {
                $this->addUsingAlias(PriceobservatorycrLogTableMap::PSE_ID, $pseId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PriceobservatorycrLogTableMap::PSE_ID, $pseId, $comparison);
    }

    /**
     * Filter the query on the message column
     *
     * Example usage:
     * <code>
     * $query->filterByMessage('fooValue');   // WHERE message = 'fooValue'
     * $query->filterByMessage('%fooValue%'); // WHERE message LIKE '%fooValue%'
     * </code>
     *
     * @param     string $message The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPriceobservatorycrLogQuery The current query, for fluid interface
     */
    public function filterByMessage($message = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($message)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $message)) {
                $message = str_replace('*', '%', $message);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PriceobservatorycrLogTableMap::MESSAGE, $message, $comparison);
    }

    /**
     * Filter the query on the help column
     *
     * Example usage:
     * <code>
     * $query->filterByHelp('fooValue');   // WHERE help = 'fooValue'
     * $query->filterByHelp('%fooValue%'); // WHERE help LIKE '%fooValue%'
     * </code>
     *
     * @param     string $help The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPriceobservatorycrLogQuery The current query, for fluid interface
     */
    public function filterByHelp($help = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($help)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $help)) {
                $help = str_replace('*', '%', $help);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PriceobservatorycrLogTableMap::HELP, $help, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPriceobservatorycrLogQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(PriceobservatorycrLogTableMap::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(PriceobservatorycrLogTableMap::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PriceobservatorycrLogTableMap::CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query on the updated_at column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $updatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPriceobservatorycrLogQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(PriceobservatorycrLogTableMap::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(PriceobservatorycrLogTableMap::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PriceobservatorycrLogTableMap::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \PriceObservatoryCR\Model\PriceobservatorycrFeed object
     *
     * @param \PriceObservatoryCR\Model\PriceobservatorycrFeed|ObjectCollection $priceobservatorycrFeed The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPriceobservatorycrLogQuery The current query, for fluid interface
     */
    public function filterByPriceobservatorycrFeed($priceobservatorycrFeed, $comparison = null)
    {
        if ($priceobservatorycrFeed instanceof \PriceObservatoryCR\Model\PriceobservatorycrFeed) {
            return $this
                ->addUsingAlias(PriceobservatorycrLogTableMap::FEED_ID, $priceobservatorycrFeed->getId(), $comparison);
        } elseif ($priceobservatorycrFeed instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PriceobservatorycrLogTableMap::FEED_ID, $priceobservatorycrFeed->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByPriceobservatorycrFeed() only accepts arguments of type \PriceObservatoryCR\Model\PriceobservatorycrFeed or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PriceobservatorycrFeed relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildPriceobservatorycrLogQuery The current query, for fluid interface
     */
    public function joinPriceobservatorycrFeed($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PriceobservatorycrFeed');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'PriceobservatorycrFeed');
        }

        return $this;
    }

    /**
     * Use the PriceobservatorycrFeed relation PriceobservatorycrFeed object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \PriceObservatoryCR\Model\PriceobservatorycrFeedQuery A secondary query class using the current class as primary query
     */
    public function usePriceobservatorycrFeedQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPriceobservatorycrFeed($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PriceobservatorycrFeed', '\PriceObservatoryCR\Model\PriceobservatorycrFeedQuery');
    }

    /**
     * Filter the query by a related \Thelia\Model\ProductSaleElements object
     *
     * @param \Thelia\Model\ProductSaleElements|ObjectCollection $productSaleElements The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPriceobservatorycrLogQuery The current query, for fluid interface
     */
    public function filterByProductSaleElements($productSaleElements, $comparison = null)
    {
        if ($productSaleElements instanceof \Thelia\Model\ProductSaleElements) {
            return $this
                ->addUsingAlias(PriceobservatorycrLogTableMap::PSE_ID, $productSaleElements->getId(), $comparison);
        } elseif ($productSaleElements instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PriceobservatorycrLogTableMap::PSE_ID, $productSaleElements->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByProductSaleElements() only accepts arguments of type \Thelia\Model\ProductSaleElements or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ProductSaleElements relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildPriceobservatorycrLogQuery The current query, for fluid interface
     */
    public function joinProductSaleElements($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ProductSaleElements');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'ProductSaleElements');
        }

        return $this;
    }

    /**
     * Use the ProductSaleElements relation ProductSaleElements object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Thelia\Model\ProductSaleElementsQuery A secondary query class using the current class as primary query
     */
    public function useProductSaleElementsQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinProductSaleElements($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ProductSaleElements', '\Thelia\Model\ProductSaleElementsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPriceobservatorycrLog $priceobservatorycrLog Object to remove from the list of results
     *
     * @return ChildPriceobservatorycrLogQuery The current query, for fluid interface
     */
    public function prune($priceobservatorycrLog = null)
    {
        if ($priceobservatorycrLog) {
            $this->addUsingAlias(PriceobservatorycrLogTableMap::ID, $priceobservatorycrLog->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the priceobservatorycr_log table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PriceobservatorycrLogTableMap::DATABASE_NAME);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PriceobservatorycrLogTableMap::clearInstancePool();
            PriceobservatorycrLogTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildPriceobservatorycrLog or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildPriceobservatorycrLog object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public function delete(ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PriceobservatorycrLogTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PriceobservatorycrLogTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        PriceobservatorycrLogTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PriceobservatorycrLogTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     ChildPriceobservatorycrLogQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(PriceobservatorycrLogTableMap::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     ChildPriceobservatorycrLogQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(PriceobservatorycrLogTableMap::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     ChildPriceobservatorycrLogQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(PriceobservatorycrLogTableMap::UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     ChildPriceobservatorycrLogQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(PriceobservatorycrLogTableMap::UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     ChildPriceobservatorycrLogQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(PriceobservatorycrLogTableMap::CREATED_AT);
    }

    /**
     * Order by create date asc
     *
     * @return     ChildPriceobservatorycrLogQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(PriceobservatorycrLogTableMap::CREATED_AT);
    }

} // PriceobservatorycrLogQuery
