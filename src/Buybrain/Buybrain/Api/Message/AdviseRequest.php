<?php
namespace Buybrain\Buybrain\Api\Message;

use Buybrain\Buybrain\Util\DateTimes;
use DateTimeInterface;
use JsonSerializable;

/**
 * API message for requesting the creation a new purchase order advise
 */
class AdviseRequest implements JsonSerializable
{
    /** @var DateTimeInterface */
    private $deliveryDate;
    /** @var DateTimeInterface */
    private $targetDate;
    /** @var AdviseRequestSku[] */
    private $skus;

    /**
     * @param DateTimeInterface $deliveryDate the date when the purchase order is expected to be delivered
     * @param DateTimeInterface $targetDate the date until when stock should be sufficient (i.e. next planned delivery)
     * @param AdviseRequestSku[] $skus the SKUs that can potentially included in the order
     */
    public function __construct(DateTimeInterface $deliveryDate, DateTimeInterface $targetDate, array $skus)
    {
        $this->deliveryDate = $deliveryDate;
        $this->targetDate = $targetDate;
        $this->skus = array_values($skus);
    }

    /**
     * @return DateTimeInterface
     */
    public function getDeliveryDate()
    {
        return $this->deliveryDate;
    }

    /**
     * @return DateTimeInterface
     */
    public function getTargetDate()
    {
        return $this->targetDate;
    }

    /**
     * @return AdviseRequestSku[]
     */
    public function getSkus()
    {
        return $this->skus;
    }

    /**
     * @param array $json
     * @return AdviseRequest
     */
    public static function fromJson(array $json)
    {
        return new self(
            DateTimes::parse($json['deliveryDate']),
            DateTimes::parse($json['targetDate']),
            array_map([AdviseRequestSku::class, 'fromJson'], $json['skus'])
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
            'skus' => $this->skus
        ];
    }
}
