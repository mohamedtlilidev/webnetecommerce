<?php

namespace AdminBundle\Repository;

use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * ProductRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProductRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param $id_category
     * @param int $page
     * @param bool $api
     * @param int $maxperpage
     * @return array|Paginator
     */
    public function findProductsByCategory($id_category,$page=1,$api=true,$maxperpage=5){


        $qb=$this->getEntityManager()->createQueryBuilder();
        $qb->select('product','categories')
            ->from('AdminBundle:Product','product')
            ->leftJoin('product.categories','categories')
            ->where('categories.id = :id_categroy')
            ->setParameter('id_categroy',intval($id_category));

        $qb->setFirstResult(($page - 1) * $maxperpage)
            ->setMaxResults($maxperpage);

        if($api)
            return $qb->getQuery()->getResult();

        return new Paginator($qb);

    }

    /**
     * @param $id_category
     * @return array
     */
    public function findAllProducts(){

        $qb=$this->getEntityManager()->createQueryBuilder();
        $qb->select('product','categories')
            ->from('AdminBundle:Product','product')
            ->leftJoin('product.categories','categories');

        return $qb->getQuery()->getResult();
    }
}