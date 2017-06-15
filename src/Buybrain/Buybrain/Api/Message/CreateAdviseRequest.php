<?php
namespace Buybrain\Buybrain\Api\Message;

use Buybrain\Buybrain\Util\DateTimes;
use DateTimeInterface;
use JsonSerializable;

/**
 * API message for requesting the creation a new purchase advise
 */
class CreateAdviseRequest implements JsonSerializable
{
    /** @var DateTimeInterface */
    private $deliveryDate;
    /** @var DateTimeInterface */
    private $targetDate;
    /** @var bool */
    private $sellableWithoutStock;
    /** @var string[][] */
    private $skusPerChannel;

    /**
     * @param DateTimeInterface $deliveryDate the date when the order is expected to be delivered
     * @param DateTimeInterface $targetDate the date until when there should be enough stock
     * @param bool $sellableWithoutStock whether the articles can be sold when not in stock
     * @param string[][] $skusPerChannel arrays of SKUs indexed by the channel to use for demand forecasting
     *
     * When using multiple channels for one SKU, include the SKU for every required channel. For example:
     * [
     *     'channelA' => ['123', '234,' 345'],
     *     'channelB' => ['345', '456']
     * ]
     */
    public function __construct(
        DateTimeInterface $deliveryDate,
        DateTimeInterface $targetDate,
        $sellableWithoutStock,
        array $skusPerChannel
    ) {
        $this->deliveryDate = $deliveryDate;
        $this->targetDate = $targetDate;
        $this->sellableWithoutStock = $sellableWithoutStock;
        $this->skusPerChannel = $skusPerChannel;
    }

    /**
     * @param array $json
     * @return CreateAdviseRequest
     */
    public static function fromJson(array $json)
    {
        return new self(
            DateTimes::parse($json['deliveryDate']),
            DateTimes::parse($json['targetDate']),
            $json['sellableWithoutStock'],
            $json['skusPerChannel']
        );
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'deliveryDate' => DateTimes::format($this->deliveryDate),
            'targetDate' => DateTimes::format($this->targetDate),
            'sellableWithoutStock' => $this->sellableWithoutStock,
            'skusPerChannel' => $this->skusPerChannel
        ];
    }
}
