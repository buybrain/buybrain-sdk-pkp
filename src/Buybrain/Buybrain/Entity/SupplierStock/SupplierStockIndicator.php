<?php
namespace Buybrain\Buybrain\Entity\SupplierStock;

use Buybrain\Buybrain\Exception\InvalidArgumentException;

/**
 * Indication of the amount of available supplier stock without knowing about exact quantities.
 *
 * UNKNOWN: there is no information about stock at all
 * SOME: there is stock available, but there is no information about how much
 * LOW: there is stock available, but the quantity of available stock is relatively low
 * HIGH: the quantity of available stock is relatively high
 */
class SupplierStockIndicator implements SupplierStock
{
    const UNKNOWN = 'unknown';
    const SOME = 'some';
    const LOW = 'low';
    const HIGH = 'high';

    /** @var string */
    private $indicator;

    /**
     * @param string $indicator one of the indicator constants of this class
     * @throws InvalidArgumentException
     */
    public function __construct($indicator)
    {
        if (!in_array($indicator, [self::UNKNOWN, self::SOME, self::LOW, self::HIGH])) {
            throw new InvalidArgumentException('Invalid indicator %s', $indicator);
        }
        $this->indicator = $indicator;
    }

    /**
     * @return string
     */
    public function getIndicator()
    {
        return $this->indicator;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'type' => 'indicator',
            'indicator' => $this->indicator,
        ];
    }
}
