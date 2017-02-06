<?php
namespace Buybrain\Buybrain;

use Buybrain\Nervus\Entity;
use Buybrain\Nervus\EntityId;

/**
 * Trait for converting an instance of BuybrainEntity to a nervus entity.
 *
 * This package does not directly depend on the Nervus SDK since using it is optional.
 */
trait AsNervusEntityTrait
{
    /**
     * @return Entity
     */
    public function asNervusEntity()
    {
        return new Entity(
            new EntityId(self::ENTITY_TYPE, $this->getId()),
            json_encode($this)
        );
    }
}