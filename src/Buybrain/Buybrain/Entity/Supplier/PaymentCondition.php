<?php
namespace Buybrain\Buybrain\Entity\Supplier;

use Buybrain\Buybrain\Entity\Supplier;
use Buybrain\Buybrain\Exception\InvalidArgumentException;
use JsonSerializable;

/**
 * A supplier may have one or multiple payment conditions. A payment condition is the agreement on the number of
 * calendar days within which the supplier should receive payment for delivered orders, counting from the date of
 * delivery.
 *
 * Optionally, a payment condition may include a discount. For example, for a given supplier, the maximum payment term
 * may be 30 days without discount, and additionally a 2% payment discount might be applied when payment is settled
 * within 7 days. In this case the supplier gets two PaymentCondition entries.
 *
 * @see Supplier
 */
class PaymentCondition implements JsonSerializable
{
    /** @var int */
    private $paymentPeriodDays;
    /** @var float */
    private $discount;

    /**
     * PaymentCondition constructor.
     * @param int $paymentPeriodDays
     * @param float $discount
     * @throws InvalidArgumentException
     */
    public function __construct($paymentPeriodDays, $discount = 0.0)
    {
        $this->paymentPeriodDays = (int)$paymentPeriodDays;
        $this->discount = (float)$discount;
        if ($this->discount < 0.0) {
            throw new InvalidArgumentException('Discount cannot be negative (got %f)', $this->discount);
        }
        if ($this->discount > 1.0) {
            throw new InvalidArgumentException('Discount cannot be greater than 1.0 (got %f)', $this->discount);
        }
    }

    /**
     * @return int
     */
    public function getPaymentPeriodDays()
    {
        return $this->paymentPeriodDays;
    }

    /**
     * @return float
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    public function jsonSerialize(): array
    {
        return [
            'period' => $this->paymentPeriodDays,
            'discount' => $this->discount,
        ];
    }

    /**
     * @param array $json
     * @return PaymentCondition
     */
    public static function fromJson(array $json)
    {
        return new self($json['period'], $json['discount']);
    }
}
