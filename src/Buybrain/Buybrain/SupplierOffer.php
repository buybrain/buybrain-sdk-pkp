<?php
namespace Buybrain\Buybrain;

use Buybrain\Buybrain\Util\DateTimes;
use DateTime;
use DateTimeInterface;

/**
 * Representation of the offer prices of a supplier for an article during a period of time.
 *
 * @see SupplierPrice
 */
class SupplierOffer implements BuybrainEntity
{
    const ENTITY_TYPE = 'supplier.offer';

    use AsNervusEntityTrait;
    use EntityIdFactoryTrait;

    /** @var string|null */
    private $id;
    /** @var string */
    private $sku;
    /** @var string */
    private $supplierId;
    /** @var DateTimeInterface */
    private $startDate;
    /** @var DateTimeInterface|null */
    private $endDate;
    /** @var SupplierPrice[] */
    private $prices;

    /**
     * @param string $sku
     * @param string $supplierId
     * @param DateTimeInterface $startDate
     * @param DateTimeInterface|null $endDate optional end date, null if the price is currently active
     * @param SupplierPrice[] $prices one or multiple prices depending on whether price varies for different quantities
     */
    public function __construct($sku, $supplierId, DateTimeInterface $startDate, $endDate, array $prices)
    {
        $this->sku = (string)$sku;
        $this->supplierId = (string)$supplierId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->prices = $prices;
    }

    /**
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @return string
     */
    public function getSupplierId()
    {
        return $this->supplierId;
    }

    /**
     * @return DateTimeInterface
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @return SupplierPrice[]
     */
    public function getPrices()
    {
        return $this->prices;
    }

    /**
     * Set a custom ID for this offer
     *
     * @param string $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getId()
    {
        if ($this->id !== null) {
            return $this->id;
        }

        return sprintf(
            '%s|%s|%s',
            $this->sku,
            $this->supplierId,
            $this->startDate->format(DateTime::W3C)
        );
    }

    /**
     * return array
     */
    public function jsonSerialize()
    {
        return [
            'sku' => $this->sku,
            'supplierId' => $this->supplierId,
            'startDate' => $this->startDate->format(DateTime::W3C),
            'endDate' => DateTimes::format($this->endDate, DateTime::W3C),
            'prices' => $this->prices,
        ];
    }
}