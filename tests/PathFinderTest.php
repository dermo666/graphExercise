<?php

require_once __DIR__.'/../classes/PathFinder.php';

class PathFinderTest extends PHPUnit_Framework_TestCase
{
    
    private $lines = [
        ['A', 'B', 10],
    ];

    private $pathList = [
        'A' => [
             'B' => 10, 
        ]
    ];
    
    
    public function testPathFinderConfiguresCorrectPathList()
    {
        $pathFinder = new PathFinder($this->lines);
        
        $this->assertEquals($this->pathList, $pathFinder->getPathList());
    }
}