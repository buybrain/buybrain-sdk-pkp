<?php
namespace Buybrain\Buybrain\Entity\SupplierStock;

use Buybrain\Buybrain\Entity\SupplierArticle;
use Buybrain\Buybrain\Exception\RuntimeException;
use JsonSerializable;

/**
 * Base class for classes that represent a supplier's stock for a certain article
 *
 * @see SupplierArticle
 */
abstract class SupplierStock implements JsonSerializable
{
    const JSON_FIELD_TYPE = 'type';

    /**
     * @param array $json
     * @return SupplierStock
     * @throws RuntimeException
     */
    public static function fromJson(array $json)
    {
        switch ($json[self::JSON_FIELD_TYPE]) {
            case ExactSupplierStock::JSON_TYPE:
                return ExactSupplierStock::fromJson($json);
            case SupplierStockIndicator::JSON_TYPE:
                return SupplierStockIndicator::fromJson($json);
            default:
                throw new RuntimeException('Unsupported supplier stock type %s', $json[self::JSON_FIELD_TYPE]);
        }
    }
}
