<?php

namespace Melk\TreeBuilderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Melk\TreeBuilderBundle\Entity\TreeFile;
use Melk\TreeBuilderBundle\Form\Type\TreeFileType;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $form = $this->buildForm(new TreeFile());
        return $this->render('MelkTreeBuilderBundle:Default:index.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
    public function treeAction(Request $request) {
        $treeFile = new TreeFile();
        $form = $this->buildForm($treeFile);
        
        $form->handleRequest($request);
        
        if (!$form->isValid()) {
            return $this->render('MelkTreeBuilderBundle:Default:index.html.twig', [
                'form' => $form->createView(),
                'errorText' => 'Fill form correctly',
                'error' => true
            ]);
        }
        
        $treeBuilder = $this->get('melk.tree.builder');
        
        try {
            $tree = $treeBuilder->buildTree($treeFile->getFilePath());
        } catch (\Exception $e) {
            return $this->render('MelkTreeBuilderBundle:Default:index.html.twig', [
                'form' => $form->createView(),
                'errorText' => $e->getMessage(),
                'error' => true
            ]);
        }
        
        return $this->render('MelkTreeBuilderBundle:Default:tree.html.twig', [
            'tree' => $tree
        ]);
    }
    
    private function buildForm(TreeFile $entity) {
        return $this->createForm(new TreeFileType(), $entity, [
            'action' => $this->generateUrl('melk_tree_builder_tree'),
            'method' => 'POST'
        ]);
    }
}
