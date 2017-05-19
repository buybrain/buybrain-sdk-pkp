<?php
namespace Buybrain\Buybrain;

use Buybrain\Buybrain\Util\DateTimes;
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
        $this->id = (string)$id;
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
            DateTimes::format($this->startDate)
        );
    }

    /**
     * return array
     */
    public function jsonSerialize()
    {
        $data = [
            'sku' => $this->sku,
            'supplierId' => $this->supplierId,
            'startDate' => DateTimes::format($this->startDate),
            'endDate' => DateTimes::format($this->endDate),
            'prices' => $this->prices,
        ];
        if ($this->id !== null) {
            $data['id'] = $this->id;
        }
        return $data;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return self::ENTITY_TYPE;
    }
}
