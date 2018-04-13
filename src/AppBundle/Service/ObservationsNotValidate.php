<?php

namespace AppBundle\Service;


use Doctrine\ORM\EntityManager;

class ObservationsNotValidate
{
    private $doctrine;

    public function __construct(EntityManager $doctrine) {
        $this->doctrine = $doctrine;
    }

    public function pendingObservations() {
        $observations = $this->doctrine
            ->getRepository('AppBundle:Observation')
            ->findAllObservationsNotValidate();

        $observationsNotValidated = array();
        // Retrieving all observations pending validation with their images.
        foreach ($observations as $observation){
            $user = $this->doctrine
                ->getRepository('AppBundle:Users')
                ->findOneById($observation->getUsers());

            $bird = $this->doctrine
                ->getRepository('AppBundle:Aves')
                ->findById($observation->getAves());

            $images = $this->doctrine
                ->getRepository('AppBundle:Picture')
                ->findOneByObservation($observation->getId());

            // We create an array that contains all observations waiting for validation with their images
            // (null if the image does not exist).
            $observationsNotValidated [] = array('observation'=>$observation, 'picture'=>$images);
        }

        return $observationsNotValidated;
    }

}