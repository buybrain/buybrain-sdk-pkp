<?php
namespace Buybrain\Buybrain\Entity;

use Buybrain\Buybrain\Util\Assert;
use Buybrain\Buybrain\Util\DateTimes;
use DateTimeInterface;

class PoAdvice implements BuybrainEntity
{
    const ENTITY_TYPE = 'poAdvice';

    use AsNervusEntityTrait;
    use EntityIdFactoryTrait;

    /** @var string */
    private $id;
    /** @var string */
    private $supplierId;
    /** @var DateTimeInterface */
    private $createDate;
    /** @var DateTimeInterface */
    private $deliveryDate;
    /** @var DateTimeInterface */
    private $nextDeliveryDate;
    /** @var Money */
    private $shippingCost;
    /** @var PoAdviceArticle[] */
    private $articles;
    /** @var float */
    private $efficiency;
    /** @var float */
    private $zeroItemsEfficiency;

    /**
     * @param string $id
     * @param string $supplierId
     * @param DateTimeInterface $createDate
     * @param DateTimeInterface $deliveryDate
     * @param DateTimeInterface $nextDeliveryDate
     * @param Money $shippingCost
     * @param PoAdviceArticle[] $articles
     * @param float $efficiency
     * @param float $zeroItemsEfficiency
     */
    public function __construct(
        $id,
        $supplierId,
        DateTimeInterface $createDate,
        DateTimeInterface $deliveryDate,
        DateTimeInterface $nextDeliveryDate,
        Money $shippingCost,
        array $articles,
        $efficiency,
        $zeroItemsEfficiency
    ) {
        Assert::instancesOf($articles, PoAdviceArticle::class);

        $this->id = (string)$id;
        $this->supplierId = (string)$supplierId;
        $this->createDate = $createDate;
        $this->deliveryDate = $deliveryDate;
        $this->nextDeliveryDate = $nextDeliveryDate;
        $this->shippingCost = $shippingCost;
        $this->articles = $articles;
        $this->efficiency = $efficiency;
        $this->zeroItemsEfficiency = $zeroItemsEfficiency;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
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
    public function getCreateDate()
    {
        return $this->createDate;
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
    public function getNextDeliveryDate()
    {
        return $this->nextDeliveryDate;
    }

    /**
     * @return Money
     */
    public function getShippingCost()
    {
        return $this->shippingCost;
    }

    /**
     * @return PoAdviceArticle[]
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * @return float
     */
    public function getEfficiency()
    {
        return $this->efficiency;
    }

    /**
     * @return float
     */
    public function getZeroItemsEfficiency()
    {
        return $this->zeroItemsEfficiency;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'supplierId' => $this->supplierId,
            'createDate' => DateTimes::format($this->createDate),
            'deliveryDate' => DateTimes::format($this->deliveryDate),
            'nextDeliveryDate' => DateTimes::format($this->nextDeliveryDate),
            'shippingCost' => $this->shippingCost,
            'articles' => $this->articles,
            'efficiency' => $this->efficiency,
            'zeroItemsEfficiency' => $this->zeroItemsEfficiency,
        ];
    }

    /**
     * @param array $json
     * @return PoAdvice
     */
    public static function fromJson(array $json)
    {
        return new self(
            $json['id'],
            $json['supplierId'],
            DateTimes::parse($json['createDate']),
            DateTimes::parse($json['deliveryDate']),
            DateTimes::parse($json['nextDeliveryDate']),
            Money::fromJson($json['shippingCost']),
            array_map([PoAdviceArticle::class, 'fromJson'], $json['articles']),
            $json['efficiency'],
            $json['zeroItemsEfficiency']
        );
    }

    /**
     * @return string
     */
    public function getType()
    {
        return self::ENTITY_TYPE;
    }
}
