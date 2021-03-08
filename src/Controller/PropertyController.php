<?php

namespace App\Controller;

use App\Entity\property;
use App\Repository\PropertyRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class PropertyController extends AbstractController
{
    /**
     * Undocumented variable
     *
     * @var PropertyRepository
     */
    private $repository;
    public function __construct(PropertyRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }
    /**
     * @Route("/biens", name="property.index")
     */

    public function index(): Response
    {



        return $this->render('property/index.html.twig', ['current_menu' => 'Properties']);
    }

    /**
     * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-zA-Z0-9\-]*"})
     *
     * @return Response
     */
    public function show(Property $property, string $slug): Response
    {
        if ($property->getSlug() !== $slug) {

            return $this->redirectToRoute('property.show',[
                'id'=>$property->getId(),
                'slug'=> $property->getSlug()
            ], 301);
        }
        return $this->render('property/show.html.twig', [
            'property' => $property,
            'current_menu' => 'Properties'
        ]);
    }
}
