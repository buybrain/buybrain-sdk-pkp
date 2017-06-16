<?php
namespace Buybrain\Buybrain\Entity;

/**
 * Represents the physical shipment of a particular SKU at a particular date.
 * Can represent a received return by using a negative quantity.
 *
 * @see CustomerOrder
 */
class Shipment extends TemporalSkuQuantity
{

}
