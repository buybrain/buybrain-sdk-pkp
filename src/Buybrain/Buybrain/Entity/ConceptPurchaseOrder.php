<?php
namespace Buybrain\Buybrain\Entity;

use Buybrain\Buybrain\Util\DateTimes;
use DateTimeInterface;

/**
 * Concept Purchase Order is used to communicate the intent to have a purchase order created. This entity is created
 * in the Buybrain system and synced to the customer. Upon receival, the customer system is expected to create a
 * purchase order with a reference to the source concept.
 *
 * @see PurchaseOrder
 */
class ConceptPurchaseOrder implements BuybrainEntity
{
    const ENTITY_TYPE = 'conceptPurchaseOrder';

    const STATUS_PENDING = 'pending';
    const STATUS_CREATED = 'created';
    const STATUS_PLACED = 'placed';

    use AsNervusEntityTrait;
    use EntityIdFactoryTrait;

    /** @var string */
    private $id;
    /** @var string */
    private $supplierId;
    /** @var DateTimeInterface */
    private $createDate;
    /** @var ConceptPurchaseOrderArticle[] */
    private $articles;
    /** @var Money */
    private $shippingCost;
    /** @var string */
    private $status = self::STATUS_PENDING;

    /**
     * @param string $id
     * @param string $supplierId
     * @param DateTimeInterface $createDate
     * @param ConceptPurchaseOrderArticle[] $articles
     * @param Money $shippingCost
     */
    public function __construct($id, $supplierId, DateTimeInterface $createDate, array $articles, Money $shippingCost)
    {
        $this->id = (string)$id;
        $this->supplierId = (string)$supplierId;
        $this->createDate = $createDate;
        $this->articles = $articles;
        $this->shippingCost = $shippingCost;
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
     * @return ConceptPurchaseOrderArticle[]
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * @return Money
     */
    public function getShippingCost()
    {
        return $this->shippingCost;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'supplierId' => $this->supplierId,
            'createDate' => DateTimes::format($this->createDate),
            'articles' => $this->articles,
            'shippingCost' => $this->shippingCost,
            'status' => $this->status,
        ];
    }

    /**
     * @param array $json
     * @return ConceptPurchaseOrder
     */
    public static function fromJson(array $json)
    {
        $concept = new self(
            $json['id'],
            $json['supplierId'],
            DateTimes::parse($json['createDate']),
            array_map([ConceptPurchaseOrderArticle::class, 'fromJson'], $json['articles']),
            Money::fromJson($json['shippingCost'])
        );
        return $concept->setStatus($json['status']);
    }

    /**
     * @return string
     */
    public function getType()
    {
        return self::ENTITY_TYPE;
    }
}
