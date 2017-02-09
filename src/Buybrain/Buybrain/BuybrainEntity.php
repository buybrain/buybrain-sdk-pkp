<?php
namespace Buybrain\Buybrain;

use Buybrain\Nervus\Entity;
use JsonSerializable;

/**
 * Interface for every type of business object that can be synced with the buybrain system
 */
interface BuybrainEntity extends JsonSerializable
{
    /**
     * @return string
     */
    public function getId();

    /**
     * @return Entity
     */
    public function asNervusEntity();
}