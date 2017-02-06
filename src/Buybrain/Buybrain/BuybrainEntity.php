<?php
namespace Buybrain\Buybrain;

use Buybrain\Nervus\Entity;
use JsonSerializable;

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