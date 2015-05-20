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
            $this->pathList[$to][$from] = $latency;
        }
    }
    
    public function findPath($from, $to, $timeLimit)
    {
        $currentPath  = [];
        $totalLatency = 0;
        
        $resultNodes = $this->finder($from, $to, $currentPath, $totalLatency, $timeLimit);
     
        $resultMessage = '';
        
        if (empty($resultNodes)) {
            $resultMessage = 'Path not found';        
        } else { 
            $resultMessage = implode(' => ', $resultNodes);
        }
        
        return $resultMessage;
    }
    
    private function finder($from, $to, $currentPath, $totalLatency, $timeLimit)
    {
        $currentPath[] = $from;
        
        if (isset($this->pathList[$from])) {
            foreach ($this->pathList[$from] as $nextNode => $latency) {
                // Return path with total latency when correct node has been found.
                if ($nextNode == $to) {
                    $totalLatency  += $latency;
                    $currentPath[]  =  $to;
                    $currentPath[]  =  $totalLatency;
                    
                    return $currentPath;
                } else { 
                    // Prevent infinite loop by checking visited nodes.
                    if (in_array($nextNode, $currentPath)) {
                        continue;
                    }
                    
                    $result = $this->finder($nextNode, $to, $currentPath, $totalLatency + $latency, $timeLimit);
                    
                    // Check the time limit otherwise continue.
                    if (is_array($result) && end($result) < $timeLimit) {
                        return $result;
                    }
                }
            }
        }
        
        return false;
    }
    
    public function getPathList()
    {
        return $this->pathList;
    }
}