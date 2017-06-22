<?php
namespace Buybrain\Buybrain\Api\Mock;

class InMemoryMockStorage implements MockStorage
{
    /** @var MockAdviseState[] */
    private $storage = [];

    /**
     * @param string $adviseId
     * @param MockAdviseState|null $state
     */
    public function set($adviseId, MockAdviseState $state = null)
    {
        if ($state !== null) {
            $this->storage[$adviseId] = $state;
        } else {
            unset($this->storage[$adviseId]);
        }
    }

    /**
     * @param string $adviseId
     * @return MockAdviseState|null
     */
    public function get($adviseId)
    {
        return isset($this->storage[$adviseId]) ? $this->storage[$adviseId] : null;
    }
}
