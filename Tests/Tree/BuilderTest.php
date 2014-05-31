<?php

namespace Melk\TreeBuilderBundle\Tests\Tree;

use Melk\TreeBuilderBundle\Tree\Builder;

/**
 * Description of BuilderTest
 *
 * @author melk
 */
class BuilderTest extends \PHPUnit_Framework_TestCase{
    
    public function testNoFile() {
        $builder = new Builder();
        try {
            $builder->buildTree('ThereIsNoFile');
        } catch (\Exception $e) {
            $this->assertEquals($e->getCode(), 404);
            return;
        }
        
        $this->assertFalse(true);
    }
    
    public function testBadFile() {
        $builder = new Builder();
        try {
            $builder->buildTree(__DIR__.'/badTree');
        } catch (\Exception $e) {
            $this->assertEquals($e->getCode(), 501);
            return;
        }
        
        $this->assertFalse(true);
    }
    
    public function testTreeRead() {
        $builder = new Builder();
        $tree = $builder->buildTree(__DIR__.'/treeNoSort');
        
        $this->assertEquals($tree,
            [
                ['id' => 1, 'parent_id' => 0, 'text' => 'node1', 
                    'children' => [
                        ['id' => 3, 'parent_id' => 1, 'text' => 'node1-1', 
                            'children' => [['id' => 5, 'parent_id' => 3, 'text' => 'node3-1', 'children' => []]]
                        ],
                        ['id' => 4, 'parent_id' => 1, 'text' => 'node1-2', 'children' => []]
                    ]
                ],
                ['id' => 2, 'parent_id' => -1, 'text' => 'node2', 
                    'children' => [['id' => 6, 'parent_id' => 2, 'text' => 'node2-1', 'children' => []]]
                ]
            ]
        );
    }
    
    public function testTreeReadSort() {
        $builder = new Builder();
        $tree = $builder->buildTree(__DIR__.'/treeSort');
        
        $this->assertEquals($tree,
            [
                ['id' => 1, 'parent_id' => 0, 'text' => 'node1', 
                    'children' => [
                        ['id' => 3, 'parent_id' => 1, 'text' => 'node1-1', 
                            'children' => [['id' => 5, 'parent_id' => 3, 'text' => 'node3-1', 'children' => []]]
                        ],
                        ['id' => 4, 'parent_id' => 1, 'text' => 'node1-2', 'children' => []]
                    ]
                ],
                ['id' => 2, 'parent_id' => 0, 'text' => 'node2', 
                    'children' => [['id' => 6, 'parent_id' => 2, 'text' => 'node2-1', 'children' => []]]
                ]
            ]
        );
    }
    
    public function testTreeReadNodeOrder() {
        $builder = new Builder();
        $tree = $builder->buildTree(__DIR__.'/treeNodeOrder');
        
        $this->assertEquals($tree,
            [
                ['id' => 1, 'parent_id' => 0, 'text' => 'node1', 
                    'children' => [
                        ['id' => 3, 'parent_id' => 1, 'text' => 'node1-1', 
                            'children' => [['id' => 5, 'parent_id' => 3, 'text' => 'node3-1', 'children' => []]]
                        ],
                        ['id' => 4, 'parent_id' => 1, 'text' => 'node1-2', 'children' => []]
                    ]
                ],
                ['id' => 2, 'parent_id' => 0, 'text' => 'node2', 
                    'children' => [['id' => 6, 'parent_id' => 2, 'text' => 'node2-1', 'children' => []]]
                ]
            ]
        );
    }
    
}

?>
