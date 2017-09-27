<?php
namespace Buybrain\Buybrain\Api\Mock;

use Buybrain\Buybrain\Exception\RuntimeException;

class FileSystemMockStorage implements MockStorage
{
    /** @var string */
    private $directory;

    /**
     * @param string|null $directory the directory to store advise state in. Creates a directory in /tmp by default.
     * @throws RuntimeException
     */
    public function __construct($directory = null)
    {
        if ($directory === null) {
            $directory = '/tmp/buybrain-sdk-advise-mocks';
            if (!file_exists($directory)) {
                if (!mkdir($directory)) {
                    throw new RuntimeException('Failed to create dir %s for mock advise storage', $directory);
                }
            }
        }
        if (!is_dir($directory)) {
            throw new RuntimeException('%s is not a directory', $directory);
        }
        $this->directory = $directory;
    }


    /**
     * @param string $adviseId
     * @param MockAdviseState|null $state
     */
    public function set($adviseId, MockAdviseState $state = null)
    {
        if ($state !== null) {
            file_put_contents($this->filename($adviseId), json_encode($state));
        } else {
            unlink($this->filename($adviseId));
        }
    }

    /**
     * @param string $adviseId
     * @return MockAdviseState|null
     */
    public function get($adviseId)
    {
        if (file_exists($this->filename($adviseId))) {
            return MockAdviseState::fromJson(json_decode(file_get_contents($this->filename($adviseId)), true));
        } else {
            return null;
        }
    }

    /**
     * @param string $adviseId
     * @return string
     */
    private function filename($adviseId)
    {
        return rtrim($this->directory, '/') . '/' . $adviseId . '.json';
    }
}
