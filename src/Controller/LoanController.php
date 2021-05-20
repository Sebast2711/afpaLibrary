<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Loan;
use App\Form\LoanType;
use App\Repository\BookRepository;
use App\Repository\LoanRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/loan")
 */
class LoanController extends AbstractController
{
    /**
     * @Route("/", name="loan_index", methods={"GET"})
     * @IsGranted("ROLE_LIBRARIAN", statusCode=401, message="You do not have permission") 
     */
    public function index(LoanRepository $loanRepository): Response
    {
        return $this->render('loan/index.html.twig', [
            'loans' => $loanRepository->findAll(),
        ]);
    }

    /**
     * @Route("/newByLibrarian", name="loan_new", methods={"GET","POST"})
     * @IsGranted("ROLE_LIBRARIAN", statusCode=401, message="You do not have permission") 
     */
    public function new(Request $request): Response
    {
        $loan = new Loan();
        $form = $this->createForm(LoanType::class, $loan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            //Date heure française
            date_default_timezone_set('Europe/Paris');
            $loan->setLoanDate(new DateTime());
            $entityManager->persist($loan);
            $entityManager->persist($loan);
            $entityManager->flush();

            return $this->redirectToRoute('loan_index');
        }

        return $this->render('loan/new.html.twig', [
            'loan' => $loan,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="loan_show", methods={"GET"})
     */
    public function show(Loan $loan): Response
    {
        return $this->render('loan/show.html.twig', [
            'loan' => $loan,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="loan_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_LIBRARIAN", statusCode=401, message="You do not have permission") 
     * 
     */
    public function edit(Request $request, Loan $loan): Response
    {
        $form = $this->createForm(LoanType::class, $loan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('loan_index');
        }

        return $this->render('loan/edit.html.twig', [
            'loan' => $loan,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="loan_delete", methods={"POST"})
     * @IsGranted("ROLE_LIBRARIAN", statusCode=401, message="You do not have permission") 
     */
    public function delete(EntityManagerInterface $manager, Loan $loan): Response
    {
        $manager -> remove($loan);
        $manager -> flush();
        return $this->redirectToRoute('loan_index');
    }


    /**
     * @Route("/{id}/returnLoan", name="loan_return")
     * @IsGranted("ROLE_LIBRARIAN", statusCode=401, message="You do not have permission") 
     * Return a book 
     * Update the return date
     * Update the quantity of this book available
     */
    public function returnLoan(Loan $loan, BookRepository $bookRepo, EntityManagerInterface $manager)
    {

        $book = $bookRepo->findOneBy(['id' => $loan->getBook()->getId()]);
        //Date heure française
        date_default_timezone_set('Europe/Paris');
        $loan->setReturnDate(new DateTime());
        $book->setQuantity($book->getQuantity()+1);
        $manager->persist($book);
        $manager->persist($loan);
        $manager->flush();


        return $this->redirectToRoute("loan_index");
    }

    /**
     * @Route ("/{id}/newLoan", name="loan_newByUser")
     * @IsGranted("ROLE_SUBSCRIBER", statusCode=401, message="You do not have permission") 
     */

    public function newLoanByUser(Book $book, EntityManagerInterface $manager){

        if ($book->getQuantity() <= 0 ){
            return $this->redirectToRoute("book_index");    
        }

        $user = $this->getUser();
        // Redirect to the correct route for librarian
        foreach ($user->getRoles() as $role) {
            if ($role == "ROLE_LIBRARIAN") {
                return $this->redirectToRoute("loan_new");
            }
        }

        $loan = new Loan();
        $loan -> setUser($user)
              -> setBook ($book)
              -> setLoanDate(new DateTime());   

        $book->setQuantity($book->getQuantity() - 1);   
        $manager -> persist($book);
        $manager -> persist($loan);
        $manager -> flush();


        return $this->redirectToRoute("book_index");
    }
}
