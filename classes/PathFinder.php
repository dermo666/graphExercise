<?php


class PathFinder
{
    private $pathList = [];
    
    public function __construct($lines)
    {
        $this->processNodes($lines);
    }
    
    private function processNodes($lines)
    {
        foreach ($lines as $line) {
            $from    = $line[0];
            $to      = $line[1];
            $latency = $line[2];
            
            if (!isset($this->pathList[$from])) {
                $this->pathList[$from] = [];
            }
            
            $this->pathList[$from][$to] = $latency; 
        }
    }
    
    public function getPathList()
    {
        return $this->pathList;
    }
}