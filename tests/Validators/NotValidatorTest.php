<?php
namespace DtoTest\Validators;

use Dto\ServiceContainer;
use Dto\Validators\NotValidator;
use Dto\Validators\ValidatorInterface;
use DtoTest\TestCase;

class NotValidatorTest extends TestCase
{
    protected function getInstance()
    {
        return new NotValidator(new ServiceContainer());
    }

    public function testInstantiation()
    {
        $v = $this->getInstance();
        $this->assertInstanceOf(ValidatorInterface::class, $v);
    }

    public function testPassesWhenSchemaDoesNotValidate()
    {
        $v = $this->getInstance();

        $schema = [
            'not' => [
                'type' => 'integer',
                'minimum' => 5,
                'maximum' => 10
            ]
        ];

        $result = $v->validate(12, $schema);

        $this->assertEquals(12, $result);
    }

    /**
     * @expectedException \Dto\Exceptions\InvalidNotException
     */
    public function testFailsWhenSchemaDoesValidate()
    {
        $v = $this->getInstance();

        $schema = [
            'not' => [
                'type' => 'integer',
                'minimum' => 5,
                'maximum' => 10
            ]
        ];

        $v->validate(7, $schema);
    }
}