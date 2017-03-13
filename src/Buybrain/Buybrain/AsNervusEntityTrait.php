<?php
namespace Buybrain\Buybrain;

use Buybrain\Nervus\Entity;

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
        return new Entity(self::id($this->getId()), json_encode($this));
    }
}