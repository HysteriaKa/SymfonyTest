<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomepageController extends AbstractController
{

    /**
     * @Route("/", name="home")
     * @param  PropertyRepository  $repository
     * @return response
     */

    public function homepage(PropertyRepository $repository):Response
    {

        $properties = $repository->findLatest();
        return $this->render('homePage.html.twig',['properties' => $properties]);
    }

  
}
