<?php


namespace PriceObservatoryCR\Events;



use PriceObservatoryCR\Model\PriceobservatorycrFeed;
use Thelia\Core\Event\ActionEvent;

class IsItemValidEvent extends ActionEvent
{
    const IS_ITEM_VALID_EVENT = "IS_ITEM_VALID_EVENT";

    /** @var PriceobservatorycrFeed */
    protected $feed;

    /** @var int */
    protected $productSaleElementsId;

    /** @var bool */
    protected $isValid = true;

    public function __construct(PriceobservatorycrFeed $feed, $productSaleElementsId)
    {
        $this->feed = $feed;
        $this->productSaleElementsId = $productSaleElementsId;
    }

    /**
     * @return PriceobservatorycrFeed
     */
    public function getFeed()
    {
        return $this->feed;
    }

    /**
     * @return int
     */
    public function getProductSaleElementsId()
    {
        return $this->productSaleElementsId;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return $this->isValid;
    }

    /**
     * @param bool $isValid
     * @return \PriceobservatoryCR\Events\IsItemValidEvent
     */
    public function setIsValid($isValid)
    {
        $this->isValid = $isValid;
        return $this;
    }
}