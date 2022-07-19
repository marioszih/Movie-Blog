<?php

namespace App\Controller;

use App\Entity\Actor;
use App\Form\ActorFormType;
use App\Repository\ActorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActorController extends AbstractController
{
    private $actorRepository;
    private $em;

    public function __construct(ActorRepository $actorRepository,EntityManagerInterface $em)
    {
        $this->actorRepository = $actorRepository;
        $this->em = $em;
    }

    #[Route(path: '/actors', name: 'actors')]
    public function index(): Response
    {
        $actors = $this->actorRepository->findAll();
        
        return $this->render('actors/indexActor.html.twig',[
            'actors' => $actors
        ]);
    }

    #[Route('/actors/create', name: 'create_actor')]
    public function create(Request $request): Response
    {
        $actor = new Actor();
        $form = $this->createForm(ActorFormType::class, $actor);
        $form ->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $newActor = $form->getData();
            $this->em->persist($newActor);
            $this->em->flush();
            return $this->redirectToRoute('actors');
        }
        return $this->render('actors/createActor.html.twig',[
            'form' => $form->createView()
        ]);
    }

    #[Route('/actors/edit/{id}', name: 'edit_actor')]
    public function edit($id, Request $request): Response
    {
       $actor = $this->actorRepository->find($id);
       $form = $this->createForm(ActorFormType::class,$actor);
       $form ->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
        $actor->setName($form->get('name')->getData());
        $actor->setBirthYear($form->get('birthYear')->getData());
        $actor->setImagePath($form->get('imagePath')->getData());
        $this->em->flush();
        return $this->redirectToRoute('actors');
       }
       return $this->render('actors/editActor.html.twig',[
        'actor' => $actor,
        'form' => $form->createView()
    ]);
    }

    #[Route('/actors/delete/{id}',methods: ['GET','DELETE'],name: 'delete_actor')]
    public function delete($id): Response
    {
        if($this->isGranted('ROLE_ADMIN') || $this->isGranted('ROLE_SUPER_ADMIN')){
            $actor = $this->actorRepository->find($id);
            $this->em->remove($actor);
            $this->em->flush();
            return $this->redirectToRoute('actors');
        }
        return $this->redirectToRoute('actors');
    }
}
