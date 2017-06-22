<?php
namespace Buybrain\Buybrain\Api\Mock;

interface MockStorage
{
    /**
     * @param string $adviseId
     * @param MockAdviseState|null $state
     */
    public function set($adviseId, MockAdviseState $state = null);

    /**
     * @param string $adviseId
     * @return MockAdviseState|null
     */
    public function get($adviseId);
}
