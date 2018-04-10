<?php
namespace Buybrain\Buybrain\Entity;

/**
 * Represents the sale of a particular article at a particular date.
 * Can represent a cancellation by using a negative quantity.
 *
 * @see SalesOrder
 */
class Sale extends TemporalSkuQuantity
{

}
