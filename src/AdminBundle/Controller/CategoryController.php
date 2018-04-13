<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Category controller.
 *
 * @Route("/categories")
 */
class CategoryController extends Controller
{

    /**
     * Lists all category entities.
     *
     * @Route("/", name="category_list")
     * @Method({"GET", "POST"})
     */
    public function listAction(Request $request)
    {
        //create new form to add category
        $category = new Category();
        $form_add_category = $this->createForm('AdminBundle\Form\CategoryType', $category);

        //Entity manager
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('AdminBundle:Category')->findAll();

        //Add category
        $form_add_category->handleRequest($request);
        if ($form_add_category->isSubmitted() && $form_add_category->isValid()) {

            $em->persist($category);
            $em->flush();
            $this->addFlash('success', 'Category Added successfully');
            return $this->redirectToRoute('category_list');
        }
        return $this->render('category/index.html.twig', array(
            'categories' => $categories,
            'form'=>$form_add_category->createView()
        ));
    }

    /**
     * @Route("/{id}/products/{page}",name="get_products_categories")
     * @Method({"GET","POST"})
     */
    public function getProductsByCategoryAction(Category $category=null,$page=null){


        if (is_null($page))
            $page = 1;
        //Max product per page
        $max_per_page=3;

        //Init Array products
        $products=array();

        if($category instanceof Category){
            //Entity manager
            $em = $this->getDoctrine()->getManager();

            $products = $em
                ->getRepository('AdminBundle:Product')
                ->findProductsByCategory($category->getId(),$page,false,$max_per_page);

        }else
            $this->addFlash('errors', 'Category not found !');


        //Count products
        $products_count=count($products);

        $pagination = array(
            'page' => $page,
            'max_per_page' => $max_per_page,
            'pages_count' => ceil( $products_count/ $max_per_page),
            'nb_products' => $products_count
        );
        return $this->render('category/list.html.twig', array(
            'products' => $products,
            'category' => $category,
            'pagination' => $pagination,
        ));
    }

}
