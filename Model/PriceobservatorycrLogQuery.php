<?php

namespace PriceObservatoryCR\Model;

use PriceObservatoryCR\Model\Base\PriceobservatorycrLogQuery as BasePriceobservatorycrLogQuery;


/**
 * Skeleton subclass for performing query and update operations on the 'priceobservatorycr_log' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class PriceobservatorycrLogQuery extends BasePriceobservatorycrLogQuery
{
    const LEVEL_INFORMATION = 1;
    const LEVEL_SUCCESS = 2;
    const LEVEL_WARNING = 3;        // Some information may not be exported as expected
    const LEVEL_ERROR = 4;          // At least one PSE has been skipped due to wrong or missing informations.
    const LEVEL_FATAL = 5;          // The XML file couldn't be generated.

    /**
     * @param integer $level
     * @param PriceobservatorycrFeed $feed
     * @param integer $pse_id
     * @param string $message
     * @param string $message
     * @param boolean $separation
     */
    private function log($level, $feed, $pse_id, $message, $help, $separation)
    {
        (new PriceobservatorycrLog())
            ->setLevel($level)
            ->setFeedId($feed->getId())
            ->setPseId($pse_id)
            ->setMessage($message)
            ->setHelp($help)
            ->setSeparation($separation)
            ->save();
    }

    /**
     * @param PriceobservatorycrFeed $feed
     * @param integer $pse_id
     * @param string $message
     * @param string $help
     */
    public function logSuccess($feed, $pse_id, $message, $help = null)
    {
        $this->log(self::LEVEL_SUCCESS, $feed, $pse_id, $message, $help, true);
    }

    /**
     * @param PriceobservatorycrFeed $feed
     * @param integer $pse_id
     * @param string $message
     * @param string $help
     */
    public function logInfo($feed, $pse_id, $message, $help = null)
    {
        $this->log(self::LEVEL_INFORMATION, $feed, $pse_id, $message, $help, false);
    }

    /**
     * @param PriceobservatorycrFeed $feed
     * @param integer $pse_id
     * @param string $message
     * @param string $help
     */
    public function logWarning($feed, $pse_id, $message, $help = null)
    {
        $this->log(self::LEVEL_WARNING, $feed, $pse_id, $message, $help, false);
    }

    /**
     * @param PriceobservatorycrFeed $feed
     * @param integer $pse_id
     * @param string $message
     * @param string $help
     */
    public function logError($feed, $pse_id, $message, $help = null)
    {
        $this->log(self::LEVEL_ERROR, $feed, $pse_id, $message, $help, false);
    }

    /**
     * @param PriceobservatorycrFeed $feed
     * @param integer $pse_id
     * @param string $message
     * @param string $help
     */
    public function logFatal($feed, $pse_id, $message, $help = null, $separation = true)
    {
        $this->log(self::LEVEL_FATAL, $feed, $pse_id, $message, $help, $separation);
    }
}
