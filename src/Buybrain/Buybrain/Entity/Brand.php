<?php
namespace Buybrain\Buybrain\Entity;

/**
 * Representation of a brand.
 */
class Brand implements BuybrainEntity
{
    const ENTITY_TYPE = 'brand';

    use AsNervusEntityTrait;
    use EntityIdFactoryTrait;

    /** @var string */
    private $id;
    /** @var string */
    private $name;

    /**
     * @param string $id
     * @param string $name
     */
    public function __construct($id, $name)
    {
        $this->id = (string)$id;
        $this->name = (string)$name;
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
    public function getName()
    {
        return $this->name;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }

    /**
     * @param array $json
     * @return Brand
     */
    public static function fromJson(array $json)
    {
        return new self($json['id'], $json['name']);
    }

    /**
     * @return string
     */
    public function getType()
    {
        return self::ENTITY_TYPE;
    }
}
