<?php

require_once __DIR__.'/../classes/PathFinder.php';

class PathFinderTest extends PHPUnit_Framework_TestCase
{
    
    private $lines = [
        ['A', 'B', 10],
        ['A', 'C', 20],
        ['B', 'D', 100],
        ['C', 'D', 30],
        ['D', 'E', 10],
        ['E', 'F', 1000],
    ];

    private $pathList = [
        'A' => [
            'B' => 10, 
            'C' => 20,
        ],
        'B' => [
            'A' => 10,
            'D' => 100,
        ],
        'C' => [
            'A' => 20,
            'D' => 30,
        ],
        'D' => [
            'C' => 30,
            'B' => 100,
            'E' => 10,
        ],
        'E' => [
            'D' => 10,
            'F' => 1000,
        ],
        'F' => [
            'E' => 1000,
        ]
    ];
    
    private $pathFinder;
    
    public function setUp()
    {
        $this->pathFinder = new PathFinder($this->lines);
    }
    
    public function testPathFinderConfiguresCorrectPathList()
    {
        $this->assertEquals($this->pathList, $this->pathFinder->getPathList());
    }
    
    public function testPathFinderFindsImmediateNode()
    {
        $path = $this->pathFinder->findPath('A', 'B', 100);
    
        $this->assertEquals('A => B => 10', $path);
    }
    
    public function testPathFinderFindsRemoteNode()
    {
        $path = $this->pathFinder->findPath('A', 'D', 200);
    
        $this->assertEquals('A => B => D => 110', $path);
    }    

    public function testPathFinderFindsNoRemoteNodeWithingLimit()
    {
        $path = $this->pathFinder->findPath('A', 'D', 50);
    
        $this->assertEquals('Path not found', $path);
    }
    
    public function testPathFinderFindsPathTheOtherWayRoundToo()
    {
        $path = $this->pathFinder->findPath('F', 'D', 2000);
        
        $this->assertEquals('F => E => D => 1010', $path);        
    }
    
    public function testAllTheSampleEntries()
    {
        $path = $this->pathFinder->findPath('A', 'F', 1000);
        $this->assertEquals('Path not found', $path);

        $path = $this->pathFinder->findPath('A', 'F', 1200);
        $this->assertEquals('A => B => D => E => F => 1120', $path);
        
        $path = $this->pathFinder->findPath('A', 'D', 100);
        $this->assertEquals('A => C => D => 50', $path);

        $path = $this->pathFinder->findPath('E', 'A', 400);
        $this->assertEquals('E => D => B => A => 120', $path);
        
        $path = $this->pathFinder->findPath('E', 'A', 80);
        $this->assertEquals('E => D => C => A => 60', $path);
    } 
}