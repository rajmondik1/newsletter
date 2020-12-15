<?php

namespace Tests\Util;

use App\Util\FileHandler;
use PHPUnit\Framework\TestCase;

class FileHandlerTest extends TestCase
{
    public const FILE_DIR = __DIR__ . '/data.json';

    private FileHandler $handler;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->handler = new FileHandler(__DIR__);
        $this->wipeDataFromFile();
    }

    protected function setUp()
    {
        $this->assertFileExists(self::FILE_DIR);
    }

    public function testAppend()
    {
        $array = [
            'id' => '1',
            'name' => 'A',
            'description' => 'text'
        ];

        $array2 = [
            'id' => '2',
            'name' => 'B',
            'description'=> 'text'
        ];

        $this->handler->append($array);
        $this->handler->append($array2);
        $result = $this->handler->read();

        $this->assertEquals('[{"id":"1","name":"A","description":"text"},{"id":"2","name":"B","description":"text"}]', $result);
        $this->assertNotEquals('sdfasdfadsaf', $result);
    }

    public function testWrite()
    {
        $array = [
            'id' => '1',
            'name' => 'A',
            'description' => 'text'
        ];

        $this->handler->write($array);
        $this->testRead();
    }

    public function testRead()
    {
        $result = $this->handler->read();

        $this->assertEquals('{"id":"1","name":"A","description":"text"}', $result);
        $this->assertNotEquals('sdfasdfadsaf', $result);
    }

    private function wipeDataFromFile()
    {
        file_put_contents(self::FILE_DIR, '[]');
    }

}
