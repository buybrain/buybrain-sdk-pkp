<?php
namespace Buybrain\Buybrain\Entity;

/**
 * Represents the physical shipment of a particular SKU to a customer at a particular date.
 * Can represent a received return by using a negative quantity.
 *
 * @see CustomerOrder
 */
class Shipment extends TemporalSkuQuantity
{

}
