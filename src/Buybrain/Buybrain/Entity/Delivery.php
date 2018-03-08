<?php
namespace Buybrain\Buybrain\Entity;

/**
 * Represents the delivery from a supplier of a particular article at a particular date.
 * Can represent a dispatched return by using a negative quantity.
 *
 * @see SupplierOrder
 */
class Delivery extends TemporalSkuQuantity
{

}
