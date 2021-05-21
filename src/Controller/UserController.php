<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\LoanRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     * @IsGranted("ROLE_LIBRARIAN", statusCode=401, message="You do not have permission")
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     * @IsGranted("ROLE_LIBRARIAN", statusCode=401, message="You do not have permission")
     */
    public function new(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            //Encodage password
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setpassword($hash);

            //Save dans la bdd
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     * @IsGranted("ROLE_SUBSCRIBER", statusCode=401, message="You do not have permission") 
     */
    public function show(User $user, LoanRepository $loanRepository): Response
    {   
        // dd($loanRepository->findBy(['user'=> $user->getId()]));
        // dd($user);
        // dd($loanRepository->findAll());

        return $this->render('user/show.html.twig', [
            'user' => $user,
            'loan' => $loanRepository->findBy(['user'=> $user->getId()]),
            'allBookLoan' => $loanRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_LIBRARIAN", statusCode=401, message="You do not have permission")
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="user_delete", methods={"GET"})
     * @IsGranted("ROLE_LIBRARIAN", statusCode=401, message="You do not have permission")
     */
    public function delete(Request $request, User $user): Response
    {
        //Condition only use for button utilisation in file _delete_form
        // if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        // }

        return $this->redirectToRoute('user_index');
    }
}
