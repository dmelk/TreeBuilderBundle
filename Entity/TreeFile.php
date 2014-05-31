<?php

namespace Melk\TreeBuilderBundle\Entity;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Entity for handling file upload
 *
 * @author melk
 */
class TreeFile {
    /**
     * File with tree info
     * @var UploadedFile
     */
    private $file;
    
    /**
     * Get file
     * @return UploadedFile
     */
    public function getFile(){
        return $this->file;
    }
    
    /**
     * Set file
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @return TreeFile
     */
    public function setFile(UploadedFile $file = null) {
        $this->file = $file;
        return $this;
    }
    
    /**
     * Get path to file
     * @return string
     */
    public function getFilePath() {
        return $this->file->getPathname();
    }
}

?>
