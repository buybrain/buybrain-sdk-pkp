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

    /**
     * Create an array of EntityId instances  with the static entity type and the given IDs
     *
     * @param mixed $ids, [mixed $ids, ...] either a single array of IDs or multiple IDs as variadic argument
     * @return EntityId[]
     */
    public static function ids($ids)
    {
        if (!is_array($ids)) {
            $ids = func_get_args();
        }
        return array_map([self::class, 'id'], $ids);
    }
}