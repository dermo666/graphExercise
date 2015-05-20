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
    
    public function findPath($from, $to, $timeLimit)
    {
        $currentPath  = [];
        $totalLatency = 0;
        
        $resultNodes = $this->finder($from, $to, $currentPath, $totalLatency);
     
        $resultMessage = '';
        
        if (empty($resultNodes)) {
            $resultMessage = 'Path not found';        
        } else { 
            $resultMessage = implode(' => ', $resultNodes);
        }
        
        return $resultMessage;
    }
    
    private function finder($from, $to, $currentPath, $totalLatency)
    {
        $currentPath[] = $from;
        
        if (isset($this->pathList[$from])) {
            foreach ($this->pathList[$from] as $nextNode => $latency) {
                
                if ($nextNode == $to) {
                    $totalLatency  += $latency;
                    $currentPath[]  =  $to;
                    $currentPath[]  =  $totalLatency;
                    
                    return $currentPath;
                } else { 
                    // TODO: Prevent infinite loop by checking visited nodes.
                    $totalLatency += $latency;
                    $result = $this->finder($nextNode, $to, $currentPath, $totalLatency);
                    if (is_array($result)) {
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