<?php

namespace AdminBundle\Controller;
use AdminBundle\Entity\Category;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


/**
 * @Route("/api", name="api")
 *
 */
class ApiController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return array('status'=>'0K');
    }

    /**
     * @param Request $request
     * @return array
     * @ApiDoc(
     *  resource=true,
     *  description="List All categories",
     *  filters={
     *  }
     * )
     * @Route("/categories", name="_get_categories", options={"expose"=true})
     * @Method({"POST","GET"})
     */
    public function getCategoriesAction(Request $request)
    {
        try{
            //Entity manager
            $em = $this->getDoctrine()->getManager();
            //Get Repository
            $repository=$em->getRepository('AdminBundle:Category');

            //Find All categories
            $categories=$repository->findAll();

            //return array data
            return array('error'=>false,'code'=>200,'message'=>'Ok','data'=>$categories);

        }catch (Exception $ex){

            return array('error'=>true,'code'=>$ex->getCode(),'message'=>$ex->getMessage(),'data'=>[]);
        }

    }

    /**
     * @param Request $request
     * @return array
     * @ApiDoc(
     *  resource=true,
     *  description="List All products",
     *  filters={
     *  }
     * )
     * @Route("/categories/{id}/products/{page}", name="_get_products_by_categories",defaults={"page"=1},options={"expose"=true})
     * @Method({"POST","GET"})
     */
    public function getProductsByCategoryAction(Category $category=null,$page=null)
    {
        try{
            $max_per_page=2;

            if(is_null($page) || intval($page)==0)
                $page=1;

            if(!$category instanceof Category){
                return array('error'=>true,'code'=>404,'message'=>'Category not found','data'=>[]);
            }

            //Entity manager
            $em = $this->getDoctrine()->getManager();
            //Get Repository
            $repository=$em->getRepository('AdminBundle:Product');

            //Find All products
            $products=$repository->findProductsByCategory($category->getId(),$page,true,$max_per_page);

            //Count products
            $products_count=count($products);

            $pagination = array(
                'page' => $page,
                'max_per_page' => $max_per_page,
                'pages_count' => ceil( $products_count/ $max_per_page),
                'nb_products' => $products_count
            );
            //return array data
            return array('error'=>false,'code'=>200,'message'=>'Ok','data'=>$products,'pagination'=>$pagination);

        }catch (Exception $ex){

            return array('error'=>true,'code'=>$ex->getCode(),'message'=>$ex->getMessage(),'data'=>[]);
        }

    }
}
