<?php

namespace Melk\TreeBuilderBundle\Tests\Form\Type;

use Melk\TreeBuilderBundle\Form\Type\TreeFileType;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Test class for TreeFileType
 *
 * @author melk
 */
class TreeFileTypeTest extends TypeTestCase{
    
    /**
     * @dataProvider getValidTestData
     */
    public function testSubmitValidData($data) {
        $type = new TreeFileType();
        $form = $this->factory->create($type);

        $form->submit($data);
        
        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($data, $form->getData());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($data) as $key) {
            $this->assertArrayHasKey($key, $children);
        }    
    
    }
    
    public function getValidTestData() {
        return [
            [
                'data' => ['file' => new UploadedFile(__DIR__.'/treeSort', 'treeSort')]
            ],
            [
                'data' => ['file' => null]
            ]
        ];
    }
    
}

?>
