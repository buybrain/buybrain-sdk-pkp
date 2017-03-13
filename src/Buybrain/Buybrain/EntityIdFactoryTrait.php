<?php
namespace Buybrain\Buybrain;

use Buybrain\Nervus\EntityId;

/**
 * Trait that introduces a static `id($id)` factory method that returns an EntityID instance with the correct type
 */
trait EntityIdFactoryTrait
{
    /**
     * Create an EntityID with the static entity type and the given ID
     *
     * @param mixed $id
     * @return EntityId
     */
    public static function id($id)
    {
        return new EntityId(self::ENTITY_TYPE, (string)$id);
    }
}