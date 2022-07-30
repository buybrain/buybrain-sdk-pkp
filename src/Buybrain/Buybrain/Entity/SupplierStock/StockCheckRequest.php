<?php
namespace Buybrain\Buybrain\Entity\SupplierStock;

use Buybrain\Buybrain\Entity\AsNervusEntityTrait;
use Buybrain\Buybrain\Entity\BuybrainEntity;
use Buybrain\Buybrain\Entity\EntityIdFactoryTrait;
use Buybrain\Buybrain\Util\Cast;
use Buybrain\Buybrain\Util\DateTimes;
use DateTimeInterface;

/**
 * Stock check requests are created by the Buybrain system and synced to the customer in order to request performing
 * a real-time supplier stock update.
 */
class StockCheckRequest implements BuybrainEntity
{
    const ENTITY_TYPE = 'supplier.stockCheckRequest';

    use AsNervusEntityTrait;
    use EntityIdFactoryTrait;

    /** @var string */
    private $id;
    /** @var string */
    private $supplierId;
    /** @var string[] */
    private $skus = [];
    /** @var DateTimeInterface */
    private $createDate;

    /**
     * @param string $id
     * @param string $supplierId
     * @param string[] $skus
     * @param DateTimeInterface $createDate
     */
    public function __construct($id, $supplierId, array $skus, DateTimeInterface $createDate)
    {
        $this->id = (string)$id;
        $this->supplierId = (string)$supplierId;
        $this->skus = Cast::toString($skus);
        $this->createDate = $createDate;
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
     * @return string[]
     */
    public function getSkus()
    {
        return $this->skus;
    }

    /**
     * @return DateTimeInterface
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'supplierId' => $this->supplierId,
            'skus' => $this->skus,
            'createDate' => DateTimes::format($this->createDate),
        ];
    }

    /**
     * @param array $json
     * @return StockCheckRequest
     */
    public static function fromJson(array $json)
    {
        return new self(
            $json['id'],
            $json['supplierId'],
            $json['skus'],
            DateTimes::parse($json['createDate'])
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
