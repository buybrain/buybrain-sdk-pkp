<?php
namespace Buybrain\Buybrain\Entity;

/**
 * Represents the sale of a particular article at a particular date.
 * Can represent a cancellation by using a negative quantity.
 *
 * @see CustomerOrder
 */
class Sale extends TemporalSkuQuantity
{

}
