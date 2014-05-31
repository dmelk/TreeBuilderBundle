<?php

namespace Melk\TreeBuilderBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertTrue($crawler->filter('html:contains("melk.view.FileUpload")')->count() > 0);
    }
    
    public function testEmptyForm() {
        $client = static::createClient();

        $crawler = $client->request('POST', '/show', [], []);
        $content = $client->getResponse()->getContent();
        $this->assertTrue($crawler->filter('html:contains("melk.view.FileUpload")')->count() > 0);
        $this->assertTrue(strpos($content, 'Fill form correctly') !== false);
    }
    
    public function testWrongFile() {
        $client = static::createClient();

        $crawler = $client->request('POST', '/show', [], ['tree_file_type' => ['file' => new UploadedFile(__DIR__.'/badTree', 'badTree')]]);
        $content = $client->getResponse()->getContent();
        
        $this->assertTrue($crawler->filter('html:contains("melk.view.FileUpload")')->count() > 0);
        $this->assertTrue(strpos($content, 'Wrong file format') !== false);
    }
    
    public function testTree() {
        $client = static::createClient();

        $crawler = $client->request('POST', '/show', [], ['tree_file_type' => ['file' => new UploadedFile(__DIR__.'/treeSort', 'treeSort')]]);
        $content = $client->getResponse()->getContent();
        
        $tree = [
            ['id' => '1', 'parent_id' => '0', 'text' => 'node1', 
                'children' => [
                    ['id' => '3', 'parent_id' => '1', 'text' => 'node1-1', 
                        'children' => [['id' => '5', 'parent_id' => '3', 'text' => 'node3-1', 'children' => []]]
                    ],
                    ['id' => '4', 'parent_id' => '1', 'text' => 'node1-2', 'children' => []]
                ]
            ],
            ['id' => '2', 'parent_id' => '0', 'text' => 'node2', 
                'children' => [['id' => '6', 'parent_id' => '2', 'text' => 'node2-1', 'children' => []]]
            ]
        ];
        
        $this->assertTrue($crawler->filter('html:contains("melk.view.Tree")')->count() > 0);
        $this->assertTrue(strpos($content, json_encode($tree)) !== false);
    }
    
}
