<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Product controller.
 *
 * @Route("/")
 */
class ProductController extends Controller
{


    /**
     * Creates a new product entity.
     *
     * @Route("/products", name="product_list")
     * @Method({"GET", "POST"})
     */
    public function listProductsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('AdminBundle:Product')->findAllProducts();

        $product = new Product();
        $form = $this->createForm('AdminBundle\Form\ProductType', $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($product);
            $em->flush();
            $this->addFlash('success', 'Product Added successfully');
            return $this->redirectToRoute('product_list');
        }

        return $this->render('product/index.html.twig', array(
            'products' => $products,
            'form' => $form->createView(),
        ));
    }


}
