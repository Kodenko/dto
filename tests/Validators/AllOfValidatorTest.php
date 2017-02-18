<?php
namespace DtoTest\Validators;

use Dto\ServiceContainer;
use Dto\Validators\AllOfValidator;
use Dto\Validators\ValidatorInterface;
use DtoTest\TestCase;

class AllOfValidatorTest extends TestCase
{
    protected function getInstance()
    {
        return new AllOfValidator(new ServiceContainer());
    }

    public function testInstantiation()
    {
        $v = $this->getInstance();
        $this->assertInstanceOf(ValidatorInterface::class, $v);
    }

    public function testMatchNumberPassesThrough()
    {
        $v = $this->getInstance();

        $schema = [
            'allOf' => [
                [
                    'type' => 'integer',
                    'minimum' => 5
                ],
                [
                    'type' => 'integer',
                    'maximum' => 10
                ]
            ]
        ];

        $result = $v->validate(7, $schema);

        $this->assertEquals(7, $result);
    }

    /**
     * @expectedException \Dto\Exceptions\InvalidAllOfException
     */
    public function testExceptionThrownWhenOneSchemaDoesNotValidate()
    {
        $v = $this->getInstance();

        $schema = [
            'allOf' => [
                [
                    'type' => 'integer',
                    'minimum' => 5
                ],
                [
                    'type' => 'integer',
                    'maximum' => 10
                ]
            ]
        ];

        $v->validate(11, $schema);
    }
}