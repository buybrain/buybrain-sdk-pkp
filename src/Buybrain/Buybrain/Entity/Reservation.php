<?php
namespace Buybrain\Buybrain\Entity;

/**
 * Represents a claim on stock for a customer order. Typically, when an item is sold, the sold quantity is reserved for
 * the related order, decreasing the economic stock. However, in some scenario's like drop shipping directly from a
 * supplier to the end customer, sales might not lead to stock reservations.
 *
 * Positive reservations claim that amount of stock, negative reservations release it.
 *
 * @see CustomerOrder
 */
class Reservation extends TemporalSkuQuantity
{

}
