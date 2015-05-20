<?php

require_once __DIR__.'/../classes/PathFinder.php';

class PathFinderTest extends PHPUnit_Framework_TestCase
{
    
    private $lines = [
        ['A', 'B', 10],
        ['A', 'C', 20],
        ['B', 'D', 100]
    ];

    private $pathList = [
        'A' => [
            'B' => 10, 
            'C' => 20,
        ],
        'B' => [
            'D' => 100,
        ]
    ];
    
    public function testPathFinderConfiguresCorrectPathList()
    {
        $pathFinder = new PathFinder($this->lines);
        
        $this->assertEquals($this->pathList, $pathFinder->getPathList());
    }
    
    public function testPathFinderFindsImmediateNode()
    {
        $pathFinder = new PathFinder($this->lines);
        
        $path = $pathFinder->findPath('A', 'B', 100);
    
        $this->assertEquals('A => B => 10', $path);
    }
    
    public function testPathFinderFindRemoteNode()
    {
        $pathFinder = new PathFinder($this->lines);
    
        $path = $pathFinder->findPath('A', 'D', 200);
    
        $this->assertEquals('A => B => D => 110', $path);
    }    
    
}