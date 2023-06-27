<?php

namespace App\Controller;

use App\Entity\Marques;
use App\Form\MarqueType;
use App\Repository\MarquesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class MarquesController extends AbstractController
{
    /** Show all marques */
    #[Route('/dashboard/marques', name: 'admin_marques')]
   
    public function index(MarquesRepository $repo): Response
    {
        $marques = $repo->findAll();

        return $this->render('marques/index.html.twig', [
            'marques' => $marques,
        ]);
    }

    /**
     * Add a new marque
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/dashboard/marques/add', name:'admin_add_marques')]
    
    public function addPages(Request $request, EntityManagerInterface $manager):Response
    {
        $marques = new Marques();

        $form=$this->createForm(MarqueType::class, $marques);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $file = $form['images']->getData();
            if(!empty($file))
            {
                $originalFilename = pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin;Latin-ASCII; [^A-Za-z0-9] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename."-".uniqid().".".$file->guessExtension();
                try{
                    $file->move(
                        $this->getParameter('uploads_directory'),
                        $newFilename
                    );
                }catch(FileException $e)
                {
                    return $e->getMessage();
                }
                $marques->setImages($newFilename);
            }

            $manager->persist($marques);
            $manager->flush();

            $this->addFlash(
                'success',
                "La marque <strong>{$marques->getName()}</strong> a bien été enregistrée!"
            );

            return $this->redirectToRoute('admin_marques');
        }

        return $this->render("marques/addMarque.html.twig",[
            'myform'=>$form->createView()
        ]);
    }

    
    /**
     * Delete a marque
     */
    #[Route('/dashboard/marques/{id}/delete', name:"admin_delete_marques")]
   
    public function pagedelete(Marques $marques, EntityManagerInterface $manager):Response
    {
        $this->addFlash(
            'success',
            "La marque <strong>{$marques->getId()}</strong> a été supprimée"
        );

        unlink($this->getParameter('uploads_directory').'/'.$marques->getImages());

        $manager->remove($marques);
        $manager->flush();

        return $this->redirectToRoute('admin_marques');

    }

}