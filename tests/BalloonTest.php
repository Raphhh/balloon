<?php
namespace Balloon;

use Balloon\Factory\BalloonFactory;

/**
 * Class BalloonTest
 * @package Balloon
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class BalloonTest extends \PHPUnit_Framework_TestCase
{

    public function testGetAll()
    {
        $data = [
            [
                'key1' => 'value1',
                'key2' => 'value2',
            ],
            [
                'key1' => 'value3',
                'key2' => 'value4',
            ],
        ];

        $filePath = __DIR__ . '/resources/data.json';

        file_put_contents($filePath, json_encode($data));

        $balloonFactory = new BalloonFactory();
        $balloon = $balloonFactory->create($filePath);
        $result = $balloon->getAll();
        $this->assertSame($data, $result);

        file_put_contents($filePath, '[]');

        $result = $balloon->getAll();
        $this->assertSame($data, $result);

        $balloon->invalidate();
        $result = $balloon->getAll();
        $this->assertSame([], $result);
    }

    public function testGet()
    {
        $data = [
            [
                'key1' => 'value1',
                'key2' => 'value2',
            ],
            [
                'key1' => 'value3',
                'key2' => 'value4',
            ],
        ];

        $filePath = __DIR__ . '/resources/data.json';

        file_put_contents($filePath, json_encode($data));

        $balloonFactory = new BalloonFactory();
        $balloon = $balloonFactory->create($filePath);
        $result = $balloon->get(0);
        $this->assertSame($data[0], $result);

        file_put_contents($filePath, '[]');

        $result = $balloon->get(0);
        $this->assertSame($data[0], $result);

        $balloon->invalidate();
        $result = $balloon->get(0);
        $this->assertNull($result);
    }

    public function testHas()
    {
        $data = [
            [
                'key1' => 'value1',
                'key2' => 'value2',
            ],
            [
                'key1' => 'value3',
                'key2' => 'value4',
            ],
        ];

        $filePath = __DIR__ . '/resources/data.json';

        file_put_contents($filePath, json_encode($data));

        $balloonFactory = new BalloonFactory();
        $balloon = $balloonFactory->create($filePath);
        $result = $balloon->has(0);
        $this->assertTrue($result);

        file_put_contents($filePath, '[]');

        $result = $balloon->has(0);
        $this->assertTrue($result);

        $balloon->invalidate();
        $result = $balloon->has(0);
        $this->assertFalse($result);
    }

    public function testAdd()
    {
        $data = [
            [
                'key1' => 'value1',
                'key2' => 'value2',
            ],
            [
                'key1' => 'value3',
                'key2' => 'value4',
            ],
        ];

        $additional = [
            'key1' => 'value5',
            'key2' => 'value6',
        ];

        $final = [
            [
                'key1' => 'value1',
                'key2' => 'value2',
            ],
            [
                'key1' => 'value3',
                'key2' => 'value4',
            ],
            [
                'key1' => 'value5',
                'key2' => 'value6',
            ],
        ];

        $filePath = __DIR__ . '/resources/data.json';

        file_put_contents($filePath, json_encode($data));

        $balloonFactory = new BalloonFactory();
        $balloon = $balloonFactory->create($filePath);

        $result = $balloon->getAll();
        $this->assertSame($data, $result);

        $result = $balloon->add($additional);
        $this->assertSame(0, $result);
        $result = $balloon->getAll();
        $this->assertSame($final, $result);

        $result = json_decode(file_get_contents($filePath), true);
        $this->assertSame($data, $result);

        $result = $balloon->flush();
        $this->assertSame(194, $result);
        $result = json_decode(file_get_contents($filePath), true);
        $this->assertSame($final, $result);
    }

    public function testModify()
    {
        $data = [
            [
                'key1' => 'value1',
                'key2' => 'value2',
            ],
            [
                'key1' => 'value3',
                'key2' => 'value4',
            ],
        ];

        $modified = [
            'key1' => 'value5',
            'key2' => 'value6',
        ];

        $final = [
            [
                'key1' => 'value1',
                'key2' => 'value2',
            ],
            [
                'key1' => 'value5',
                'key2' => 'value6',
            ],
        ];

        $filePath = __DIR__ . '/resources/data.json';

        file_put_contents($filePath, json_encode($data));

        $balloonFactory = new BalloonFactory();
        $balloon = $balloonFactory->create($filePath);

        $result = $balloon->getAll();
        $this->assertSame($data, $result);

        $result = $balloon->modify(1, $modified);
        $this->assertSame(0, $result);
        $result = $balloon->getAll();
        $this->assertSame($final, $result);

        $result = json_decode(file_get_contents($filePath), true);
        $this->assertSame($data, $result);

        $result = $balloon->flush();
        $this->assertSame(130, $result);
        $result = json_decode(file_get_contents($filePath), true);
        $this->assertSame($final, $result);
    }

    public function testRemove()
    {
        $data = [
            [
                'key1' => 'value1',
                'key2' => 'value2',
            ],
            [
                'key1' => 'value3',
                'key2' => 'value4',
            ],
        ];

        $final = [
            [
                'key1' => 'value1',
                'key2' => 'value2',
            ],
        ];

        $filePath = __DIR__ . '/resources/data.json';

        file_put_contents($filePath, json_encode($data));

        $balloonFactory = new BalloonFactory();
        $balloon = $balloonFactory->create($filePath);

        $result = $balloon->getAll();
        $this->assertSame($data, $result);

        $result = $balloon->remove(1);
        $this->assertSame(0, $result);
        $result = $balloon->getAll();
        $this->assertSame($final, $result);

        $result = json_decode(file_get_contents($filePath), true);
        $this->assertSame($data, $result);

        $result = $balloon->flush();
        $this->assertSame(66, $result);
        $result = json_decode(file_get_contents($filePath), true);
        $this->assertSame($final, $result);
    }
}
