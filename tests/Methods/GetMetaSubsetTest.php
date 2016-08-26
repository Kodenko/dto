<?php
class GetMetaSubsetTest extends DtoTest\TestCase
{
    public function testBasicTrimOperations()
    {
        $dto = new \Dto\Dto();
        $reflection = new ReflectionClass(get_class($dto));
        $method = $reflection->getMethod('getMetaSubset');
        $method->setAccessible(true);
        
        // Assume a normalized meta key format w leading dots
        $meta = [
            '.firstname' => 'x',
            '.lastname' => 'y',
            '.mother.firstname' => 'a',
            '.mother.lastname' => 'b',
        ];
        $trimmed = [
            '.firstname' => 'a',
            '.lastname' => 'b',
        ];
        $this->assertEquals($trimmed, $method->invokeArgs($dto, ['mother', $meta]));
        
    }
    
    /**
     * Meta Subset of an existing prefix should resolve to a "." (i.e. global) subset
     */
    public function testGetMetaSubset2()
    {
        $dto = new \Dto\Dto();
        $reflection = new ReflectionClass(get_class($dto));
        $method = $reflection->getMethod('getMetaSubset');
        $method->setAccessible(true);
        
        // Assume a normalized meta key format w leading dots
        $meta = [
            '.somehash' => [
                'type' => 'hash',
                'values' => ['type' =>'boolean']
            ],
        ];
        
        $trimmed = [
            '.' => [
                'type' => 'hash',
                'values' => ['type' =>'boolean']
            ]
        ];
        
        $this->assertEquals($trimmed, $method->invokeArgs($dto, ['somehash', $meta]));
        
    }
    
    /**
     * Meta subset of a non-existing prefix should come back empty
     */
    public function testGetMetaSubset3()
    {
        $dto = new \Dto\Dto();
        $reflection = new ReflectionClass(get_class($dto));
        $method = $reflection->getMethod('getMetaSubset');
        $method->setAccessible(true);
        
        // Assume a normalized meta key format w leading dots
        $meta = [
            '.somehash' => [
                'type' => 'hash',
                'values' => ['type' =>'boolean']
            ],
        ];
        
        $trimmed = [];
        
        $this->assertEquals($trimmed, $method->invokeArgs($dto, ['non_existant', $meta]));
        
    }
    
    public function testGetMetaSubset4()
    {
        $dto = new \Dto\Dto();
        $reflection = new ReflectionClass(get_class($dto));
        $method = $reflection->getMethod('getMetaSubset');
        $method->setAccessible(true);
        
        // Assume a normalized meta key format w leading dots
        $meta = [
            '.array' => [
                'type' => 'array',
                'values' => [
                    'type' => 'scalar'
                ]
            ],
            '.' => [
                'type' => 'hash',
                //'values' => ['type' => 'unknown']
            ]
        ];
        
        $trimmed = [
            '.' => [
                'type' => 'array',
                'values' => [
                    'type' => 'scalar'
                ]
            ]
        ];
        
        $this->assertEquals($trimmed, $method->invokeArgs($dto, ['array', $meta]));
        
    }
    
}