<?php

namespace Melk\TreeBuilderBundle\Tree;

/**
 * Tree builder service
 *
 * @author melk
 */
class Builder {
    
    /**
     * List of tree nodes: keys - node_id, data - node info
     * @var array
     */
    private $nodes = [];
    
    /**
     * List of parent (key) and children
     * @var array
     */
    private $children = [];
    
    /**
     * Build tree from file
     * 
     * @param string $filename
     * @return array Tree array
     * @throws \Exception 404 if file not found
     * @throws \Exception 501 if file has wrong format
     */
    public function buildTree($filename) {
        if (!file_exists($filename)) {
            throw new \Exception('File not found', 404);
        }
        
        $rows = explode("\r\n", file_get_contents($filename));
        $this->nodes = [];
        $this->children = [];
        foreach ($rows as $data) {
            $data = explode('|',  $data, 3);
            if (count($data) < 3) throw new \Exception('Wrong file format', 501);
            list($id, $parent_id, $name) = $data;
            $this->nodes[$id] = ['id' => $id, 'parent_id' => $parent_id, 'text' => $name, 'children' => []];
            if (!isset($this->children[$parent_id])) $this->children[$parent_id] = [];
            $this->children[$parent_id][] = $id;
        }
        
        // get root nodes
        $tree = [];
        foreach ($this->children as $key => $nodes) {
            if (!isset($this->nodes[$key])) {
                // root node found
                foreach ($nodes as $node_id) $tree[] = $this->getNodeContents($node_id);
            }
        }
        usort($tree, [$this, 'sortNode']);

        return $tree;
    }
    
    /**
     * Get node content and children
     * 
     * @param mixed $node_id
     * @return array
     */
    private function getNodeContents($node_id) {
        $node = $this->nodes[$node_id];
        if (isset($this->children[$node_id])) {
            foreach ($this->children[$node_id] as $child_node_id) {
                $node['children'][] = $this->getNodeContents($child_node_id);
            }
            usort($node['children'], [$this, 'sortNode']);
        }
        return $node;
    }
    
    /**
     * Comparison function for node sort
     * 
     * @param array $nodeA
     * @param array $nodeB
     * @return int
     */
    private function sortNode($nodeA, $nodeB) {
        if ($nodeA['text'] == $nodeB['text']) return 0;
        return ($nodeA['text'] > $nodeB['text'])? 1 : -1;
    }
    
}

?>
