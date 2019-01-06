<?php

namespace App\Tests\Unit;

use App\Document\Category;
use App\Service\DocumentManager;
use App\Service\Storage;
use JMS\Serializer\SerializerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * App\Tests\Unit\DocumentManagerTest
 */
class DocumentManagerTest extends TestCase
{
    /**
     * @return array
     */
    public function findOneDataProvider()
    {
        $data = [];

        // case 0
        $documentsMap = [
            'App\\Document\\Category'   => 'category',
            'App\\Document\\Subscriber' => 'subscriber',
        ];

        $expectedResult = (new Category())
            ->setId('id')
            ->setName('name');

        $data[] = [
            'documentMap'     => $documentsMap,
            'callClass'       => 'App\\Document\\Category',
            'callType'        => 'category',
            'serializerCalls' => 1,
            'storageResult'   => [
                'id'   => 'id',
                'name' => 'name',
            ],
            'expectedResult' => $expectedResult,
        ];

        // case 1
        $documentsMap = [
            'App\\Document\\Category'   => 'category',
            'App\\Document\\Subscriber' => 'subscriber',
        ];

        $data[] = [
            'documentMap'     => $documentsMap,
            'callClass'       => 'App\\Document\\Category',
            'callType'        => 'category',
            'serializerCalls' => 0,
            'storageResult'   => [],
            'expectedResult'  => [],
        ];

        return $data;
    }


    /**
     * @param array  $documentsMap
     * @param string $callClass
     * @param string $callType
     * @param int    $serializerCalls
     * @param array  $storageResult
     * @param object $expectedResult
     *
     * @throws \Exception
     *
     * @dataProvider findOneDataProvider
     */
    public function testFindOne(
        array $documentsMap,
        string $callClass,
        string $callType,
        int $serializerCalls,
        array $storageResult,
        $expectedResult
    ) {
        $serializer = $this->getClassMock(SerializerInterface::class);
        $serializer
            ->expects($this->exactly($serializerCalls))
            ->method('deserialize')
            ->with(json_encode($storageResult), $callClass, 'json')
            ->willReturn($expectedResult);

        $storage = $this->getClassMock(Storage::class);
        $storage
            ->expects($this->once())
            ->method('findOne')
            ->with($callType, [])
            ->willReturn($storageResult);

        $documentManager = new DocumentManager($serializer, $storage, $documentsMap);
        $result = $documentManager->findOne($callClass, []);
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @return array
     */
    public function findDataProvider()
    {
        $data = [];

        // case 0
        $documentsMap = [
            'App\\Document\\Category'   => 'category',
            'App\\Document\\Subscriber' => 'subscriber',
        ];

        $expectedResult1 = (new Category())
            ->setId('id-1')
            ->setName('name-1');

        $expectedResult2 = (new Category())
            ->setId('id-2')
            ->setName('name-2');

        $storageResult1 = [
            'id'   => 'id-1',
            'name' => 'name-1',
        ];

        $storageResult2 = [
            'id'   => 'id-2',
            'name' => 'name-2',
        ];

        $data[] = [
            'documentMap'     => $documentsMap,
            'callClass'       => 'App\\Document\\Category',
            'callType'        => 'category',
            'serializerCalls' => [
                [
                    'with'   => $storageResult1,
                    'return' => $expectedResult1,
                ],
                [
                    'with'   => $storageResult2,
                    'return' => $expectedResult2,
                ],
            ],
            'storageResult'   => [
                $storageResult1,
                $storageResult2,
            ],
            'expectedResult'  => [
                'id-1' => $expectedResult1,
                'id-2' => $expectedResult2,
            ],
        ];

        // case 1
        $documentsMap = [
            'App\\Document\\Category'   => 'category',
            'App\\Document\\Subscriber' => 'subscriber',
        ];

        $expectedResult1 = (new Category())
            ->setId('id-1')
            ->setName('name-1');

        $storageResult1 = [
            'id'   => 'id-1',
            'name' => 'name-1',
        ];

        $data[] = [
            'documentMap'     => $documentsMap,
            'callClass'       => 'App\\Document\\Category',
            'callType'        => 'category',
            'serializerCalls' => [
                [
                    'with'   => $storageResult1,
                    'return' => $expectedResult1,
                ],
            ],
            'storageResult'   => [
                $storageResult1,
            ],
            'expectedResult'  => [
                'id-1' => $expectedResult1,
            ],
        ];

        // case 2
        $documentsMap = [
            'App\\Document\\Category'   => 'category',
            'App\\Document\\Subscriber' => 'subscriber',
        ];

        $data[] = [
            'documentMap'     => $documentsMap,
            'callClass'       => 'App\\Document\\Category',
            'callType'        => 'category',
            'serializerCalls' => [],
            'storageResult'   => [],
            'expectedResult'  => [],
        ];

        return $data;
    }

    /**
     * @param array  $documentsMap
     * @param string $callClass
     * @param string $callType
     * @param array  $serializerCalls
     * @param array  $storageResult
     * @param object $expectedResult
     *
     * @throws \Exception
     *
     * @dataProvider findDataProvider
     */
    public function testFind(
        array $documentsMap,
        string $callClass,
        string $callType,
        array $serializerCalls,
        array $storageResult,
        $expectedResult
    ) {
        $serializer = $this->getClassMock(SerializerInterface::class);

        if ($serializerCalls) {
            foreach ($serializerCalls as $key => $serializerCall) {
                $serializer
                    ->expects($this->at($key))
                    ->method('deserialize')
                    ->with(json_encode($serializerCall['with']), $callClass, 'json')
                    ->willReturn($serializerCall['return']);
            }
        } else {
            $serializer
                ->expects($this->never())
                ->method('deserialize');
        }


        $storage = $this->getClassMock(Storage::class);
        $storage
            ->expects($this->once())
            ->method('find')
            ->with($callType, [], [])
            ->willReturn($storageResult);

        $documentManager = new DocumentManager($serializer, $storage, $documentsMap);
        $result = $documentManager->find($callClass, []);
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @param string $class
     *
     * @return MockObject
     */
    protected function getClassMock(string $class)
    {
        $mock = $this->getMockBuilder($class)
            ->disableOriginalConstructor()
            ->getMock();

        return $mock;
    }
}
