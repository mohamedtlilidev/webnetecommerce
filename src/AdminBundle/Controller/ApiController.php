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


}
