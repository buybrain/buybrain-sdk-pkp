<?php
namespace Buybrain\Buybrain\Api\Message;

use JsonSerializable;

/**
 * API message in response to both creating a new advise as well as getting an existing advise
 */
class AdviseResponse implements JsonSerializable
{
    const STATUS_PENDING = 'pending';
    const STATUS_COMPLETE = 'complete';
    
    /** @var string */
    private $adviseId;
    /** @var string */
    private $status;
    /** @var float */
    private $progress;
    /** @var AdviseSku[]|null */
    private $skus;

    /**
     * @param string $adviseId v4 UUID
     * @param string $status indicator whether the advise is ready or still being created, one of the STATUS_ constants
     * @param float $progress in case the advise is being created, indicates the progress between 0.0 and 1.0
     * @param AdviseSku[]|null $skus advise per SKU in case the advise is ready, null if it is being created
     */
    public function __construct($adviseId, $status, $progress, array $skus = null)
    {
        $this->adviseId = $adviseId;
        $this->status = $status;
        $this->progress = $progress;
        $this->skus = $skus;
    }

    /**
     * @return string v4 UUID
     */
    public function getAdviseId()
    {
        return $this->adviseId;
    }

    /**
     * @return string indicator whether the advise is ready or still being created, one of the STATUS_ constants
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return bool true if this advise is complete, false if it is still being created
     */
    public function isComplete()
    {
        return $this->status === self::STATUS_COMPLETE;
    }

    /**
     * @return float in case the advise is being created, indicates the progress between 0.0 and 1.0
     */
    public function getProgress()
    {
        return $this->progress;
    }

    /**
     * @return AdviseSku[]|null advise per SKU in case the advise is ready, null if it is being created
     */
    public function getSkus()
    {
        return $this->skus;
    }

    /**
     * @param array $json
     * @return AdviseResponse
     */
    public static function fromJson(array $json)
    {
        return new self(
            $json['adviseId'],
            $json['status'],
            $json['progress'],
            isset($json['skus']) ? array_map([AdviseSku::class, 'fromJson'], $json['skus']) : null
        );
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $res = [
            'adviseId' => $this->adviseId,
            'status' => $this->status,
            'progress' => $this->progress
        ];
        if ($this->status === self::STATUS_COMPLETE) {
            $res['skus'] = $this->skus;
        }
        return $res;
    }
}
