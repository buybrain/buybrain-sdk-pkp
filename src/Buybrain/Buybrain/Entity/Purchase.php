<?php
namespace Buybrain\Buybrain\Entity;

/**
 * Represents the purchase of a particular article at a particular date.
 * Can represent a cancellation by using a negative quantity.
 *
 * @see SupplierOrder
 */
class Purchase extends TemporalSkuQuantity
{

}
