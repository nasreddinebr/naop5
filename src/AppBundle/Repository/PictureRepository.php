<?php

namespace AppBundle\Repository;

/**
 * PictureRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PictureRepository extends \Doctrine\ORM\EntityRepository
{
    public function getAllPicturesObservation($id){

        return $this
            ->createQueryBuilder('pic')
            ->where('pic.observation = :id')
            ->setParameter('id',$id)
            ->getQuery()
            ->getResult();
    }
}
