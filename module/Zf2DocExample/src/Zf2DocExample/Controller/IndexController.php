<?php

namespace Zf2DocExample\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zf2DocExample\Entity\Product;
use Zf2DocExample\Form\CreateProductForm;

class IndexController extends AbstractActionController
{
    /**
     * @return array
     */
    public function indexAction()
    {
        $form = new CreateProductForm();
        $product = new Product();
        $form->bind($product);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                var_dump($product);
            }
        }

        return array(
            'form' => $form,
        );
    }
}
