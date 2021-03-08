<?php

namespace App\Controller\Admin;

use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\property;
use App\Form\PropertyType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class AdminPropertyController extends AbstractController
{

    /**
     * @var PropertyRepository
     *
     * @param PropertyRepository $repository
     */
    private $repository;

    public function __construct(PropertyRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }
    /**
     * @Route("/admin", name="admin.property.index")
     *
     * @return void
     */
    public function index()
    {
        $properties =  $this->repository->findAll();
        return $this->render('admin/property/index.html.twig', compact('properties'));
    }
    /**
     * @Route("/admin/property/create", name="admin.property.new")
     *
     * @return void
     */
    public function new(Request $request)
    {
        $property = new Property();
        //on crée un formulaire 
        $form =  $this->createForm(PropertyType::class, $property);

        //on demande au formulaire de gérer la requête
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($property);
            $this->em->flush();
            $this->addFlash('success','bien ajouté avec succés');
            return $this->redirectToRoute('admin.property.index');
        }
        //si tout va bien on rend la vue (on passe la proriété vide et le formulaire)
        return $this->render('admin/property/new.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/property/{id}", name="admin.property.edit", methods="GET|POST")
     *
     * @return void
     */
    public function edit(Property $property, Request $request)
    {
        $form =  $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success','bien modifié avec succés');
            return $this->redirectToRoute('admin.property.index');
        }

        return $this->render('admin/property/edit.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/property/{id}", name="admin.property.delete", methods="DELETE")
     *
     * @return void
     */
    public function delete(Property $property, Request $request)
    {
        if ($this->isCsrfTokenValid('delete'. $property->getId(), $request->get('token') )) {

        };
        $this->em->remove($property);
        $this->em->flush();
        $this->addFlash('success','bien supprimé avec succés');
        return new Response('suppression');
        return $this->redirectToRoute('admin.property.index');
    }
}
