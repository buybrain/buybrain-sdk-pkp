<?php
namespace Buybrain\Buybrain\Api\Mock;

use Buybrain\Buybrain\Api\Message\AdviseRequest;
use Buybrain\Buybrain\Util\DateTimes;
use PHPUnit_Framework_TestCase;

class FileSystemMockStorageTest extends PHPUnit_Framework_TestCase
{
    public function testStorage()
    {
        $SUT = new FileSystemMockStorage();

        $id = '00000000-0000-0000-0000-000000000000';

        $this->assertNull($SUT->get($id));

        $date = DateTimes::parse('2017-01-01');
        $state = new MockAdviseState($id, 2, new AdviseRequest($date, $date, []));

        $SUT->set($id, $state);

        $this->assertEquals($state, $SUT->get($id));

        $SUT->set($id, null);

        $this->assertNull($SUT->get($id));
    }
}
