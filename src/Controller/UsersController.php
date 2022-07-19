<?php
namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class UsersController extends AbstractController{

    private $userRepository;

    public function __construct(EntityManagerInterface $em,UserRepository $userRepository)
    {
        $this->em = $em;
        $this->userRepository = $userRepository;
    }

    #[Route(path: '/users',methods: ['GET'], name: 'user_management')]
    public function users(): Response
    {
        $users = $this->userRepository->findAll();
        $email = $this->getUser()->getUserIdentifier();
        return $this->render('security/users.html.twig',[
            'users' => $users,'current_email' => $email
        ]);
    }

    #[Route(path: '/users/delete/{email}', name: 'delete_user')]
    public function delete($email): Response
    {
        if ($this->getUser() && $this->isGranted('ROLE_SUPER_ADMIN')){
            $user = $this->userRepository->findBy(array('email' => $email));
            $this->userRepository->remove($user[0]);
            $this->em->flush();
            return $this->redirectToRoute('user_management');
        }
        return $this->redirectToRoute('user_management');
    }

    #[Route(path: '/upgrade', name: 'account_upgrade')]
    public function upgrade(Request $request): Response
    {
        $defaultData = ['message' => 'Type your message here'];

        $form = $this->createFormBuilder($defaultData)
        ->add('password',IntegerType::class, [
            'attr' => array(
                'class' => 'bg-transparent block mt-10 border-b-2 w-full h-20 text-6xl outline-none',
                'placeholder' => 'Input the admin password'
            ),
            'required' => false
        ])
        ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            if($data["password"] == "1023958645"){
                $email = $this->getUser()->getUserIdentifier();
                $user = $this->userRepository->findBy(array('email' => $email));
                if ($this->getUser() && (strcmp($user[0]->getRoles()[0],"ROLE_USER") == 0)) {
                    $user[0]->setRoles(array("ROLE_ADMIN"));
                    $this->em->flush();
                    return $this->redirectToRoute('home');
                }
                elseif ($this->getUser() && (strcmp($user[0]->getRoles()[0],"ROLE_ADMIN") == 0)){
                    $user[0]->setRoles(array("ROLE_SUPER_ADMIN"));
                    $this->em->flush();
                    return $this->redirectToRoute('home');
                }
            }
            return $this->redirectToRoute('home');
        }
        return $this->render('security/upgrade.html.twig',[
            'form' => $form->createView()
        ]);
    }
}

