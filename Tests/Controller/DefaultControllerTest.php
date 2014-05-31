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
    
}
