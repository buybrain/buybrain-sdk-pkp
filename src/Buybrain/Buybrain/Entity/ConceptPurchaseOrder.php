<?php
namespace Buybrain\Buybrain\Entity;

use Buybrain\Buybrain\Util\Cast;
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

    const CREATION_MANUAL = 'manual';
    const CREATION_AUTOMATIC = 'automatic';
    
    const PROCESSING_MANUAL = 'manual';
    const PROCESSING_AUTOMATIC = 'automatic';

    use AsNervusEntityTrait;
    use EntityIdFactoryTrait;

    /** @var string */
    private $id;
    /** @var string */
    private $supplierId;
    /** @var DateTimeInterface */
    private $createDate;
    /** @var string|null */
    private $createdBy;
    /** @var string */
    private $createMethod;
    /** @var ConceptPurchaseOrderArticle[] */
    private $articles;
    /** @var Money */
    private $shippingCost;
    /** @var string */
    private $status;
    /** @var string  */
    private $processing;

    /**
     * @param string $id
     * @param string $supplierId
     * @param DateTimeInterface $createDate
     * @param string|null $createdBy the UUID of the agent that created this concept when created manually, or the UUID
     *        of the responsible agent on whose behalf the order was automatically created by Orderbot. The
     *        corresponding User entity can be obtained with the API.
     * @param string $createMethod one of the CREATION_ constants. Indicates whether this concept was created manually
     *        by an agent, or automatically by the Orderbot system.
     * @param ConceptPurchaseOrderArticle[] $articles
     * @param Money $shippingCost
     * @param string $status one of the STATUS_ constants
     * @param string $processing one of the PROCESSING_ constants. Indicates whether the receiving system is expected
     *        to automatically place the order at the supplier, or if the order should be placed manually.
     */
    public function __construct(
        $id,
        $supplierId,
        DateTimeInterface $createDate,
        $createdBy,
        $createMethod,
        array $articles,
        Money $shippingCost,
        $status,
        $processing
    ) {
        $this->id = (string)$id;
        $this->supplierId = (string)$supplierId;
        $this->createDate = $createDate;
        $this->createdBy = Cast::toString($createdBy);
        $this->createMethod = (string)$createMethod;
        $this->articles = $articles;
        $this->shippingCost = $shippingCost;
        $this->status = (string)$status;
        $this->processing = (string)$processing;
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
     * @return string|null
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @return string
     */
    public function getCreateMethod()
    {
        return $this->createMethod;
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

    /**
     * @return string
     */
    public function getProcessing()
    {
        return $this->processing;
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
            'createdBy' => $this->createdBy,
            'createMethod' => $this->createMethod,
            'articles' => $this->articles,
            'shippingCost' => $this->shippingCost,
            'status' => $this->status,
            'processing' => $this->processing,
        ];
    }

    /**
     * @param array $json
     * @return ConceptPurchaseOrder
     */
    public static function fromJson(array $json)
    {
        return new self(
            $json['id'],
            $json['supplierId'],
            DateTimes::parse($json['createDate']),
            $json['createdBy'],
            $json['createMethod'],
            array_map([ConceptPurchaseOrderArticle::class, 'fromJson'], $json['articles']),
            Money::fromJson($json['shippingCost']),
            $json['status'],
            $json['processing']
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
