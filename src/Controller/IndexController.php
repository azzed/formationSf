<?php



namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Books;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\BooksRepository;
use App\Form\BookType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Image;
use App\Entity\Keyword;


class IndexController extends AbstractController
{
    /**
     * @Route("/",name="home")
     */
    public function home(BooksRepository $repo)
    {
        $books = $repo->findAll();
        return $this->render('home.html.twig',[
            'books' => $books
        ]);
    }
    /**
     * 
     * @Route("/add", name="add")
     */
    public function add(EntityManagerInterface $manager,Request $request)
    {

          

        
            $form = $this->createForm(BookType::class);

            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
               //recupere les valeur sous forme d'objet Book
                $path = $this->getParameter('kernel.project_dir').'/public/images';
               $book = $form->getData();
                //recupere l'image
                $image = $book->getImage();
                //recupere l'image soumis
                $file = $image->getFile();
                //creer un nom unique
                $name = md5(uniqid()).'.'.$file->guessExtension();
                //on deplace le fichier
                $file->move($path,$name);
                //donne le nom a l'image
                $image->setName($name);
            
                $manager->persist($book);
                $manager->flush();
                $this->addFlash(
                    'notice',
                    'Super! Le livre a bien été ajouter'
                );
                return $this->redirectToRoute('home');
            }

            return $this->render('add.html.twig',[
                'form' => $form->createView()
            ]);

    }
     /**
     * 
     * @Route("/edit/{id}", name="edit")
     */
    public function edit(Books $book,EntityManagerInterface $manager,Request $request)
    {
        $form = $this->createForm(BookType::class,$book);
       
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->flush();
            $this->addFlash(
                'notice',
                "Super! Le livre a bien été modifié"
            );
            return $this->redirectToRoute('home');
        }
            return $this->render('edit.html.twig',[
                'book' => $book,
                'form' => $form->createView()
            ]);

    }
     /**
     * 
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Books $book,EntityManagerInterface $manager)
    {
        $manager->remove($book);
        $manager->flush();
        return $this->redirectToRoute('home');

    }

    /**
     * @Route("/contact",name="contact")
     */
    public function contact()
    {
      
        return $this->render('contact.html.twig');
    }
     /**
     * @Route("/show/{id}",name="show")
     */
    public function show(Books $book)
    {
     
        return $this->render('show.html.twig',[
            'book' => $book
        ]);
    }
 
}