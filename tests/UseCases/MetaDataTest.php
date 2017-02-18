<?php
namespace DtoTest\UseCases;

use Dto\Dto;
use DtoTest\TestCase;

class MetaDataTest extends TestCase
{
    public function test()
    {
        $dto = new Dto(null, [
            'type' => 'object',
            'properties' => [
                'x' => [
                    '$ref' => '#/definitions/my_integer'
                ],
                'y' => [
                    'type' => 'object',
                    'properties' => [
                        'z' => [
                            '$ref' => '#/definitions/my_integer'
                        ]
                    ]
                ]
            ],
            'default' => [
                'x' => 0,
                'y' => [
                    'z' => 0
                ]
            ],
            'definitions' => [
                'my_integer' => [
                    'type' => 'integer',
                    'description' => 'Root Definition'
                ]
            ]
        ]);

        $dto->x = '123';
        $this->assertEquals(123, $dto->x->toScalar());
        $this->assertEquals([
            'type' => 'integer',
            'description' => 'Root Definition'
        ], $dto->x->getSchema());

        $dto->y->z = '456';
        $this->assertEquals(456, $dto->y->z->toScalar());
        $this->assertEquals([
            'type' => 'integer',
            'description' => 'Root Definition'
        ], $dto->y->z->getSchema());
    }
}