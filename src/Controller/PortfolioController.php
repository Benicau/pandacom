<?php

namespace App\Controller;

use App\Entity\Portfolio;
use App\Form\PortfolioType;
use App\Entity\GaleryPortfolio;
use App\Repository\PortfolioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class PortfolioController extends AbstractController
{
    #[Route('/portfolio', name: 'admin_portfolio')]
    #[IsGranted("ROLE_ADMIN")]
    public function index(PortfolioRepository $repo): Response
    {
        $projects= $repo->findAll();

        return $this->render('portfolio/index.html.twig', [
            'projects' => $projects,
        ]);
    }

    
    /**
     * Add a project to the portfolio
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/portfolio/add', name:"admin_add_portfolio")]
    #[IsGranted("ROLE_ADMIN")]
    public function addProject(Request $request, EntityManagerInterface $manager):Response
    {
        $projet = new Portfolio();

        $form=$this->createForm(PortfolioType::class, $projet);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            // cover image gestion 
            $file=$form['coverImage']->getData();
            if (!empty($file)) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin;Latin-ASCII;[^A-Za-z0-9_]remove;Lower()', $originalFilename);
                $newFilename = $safeFilename . "-" . uniqid() . "." . $file->guessExtension();
                try {
                    $file->move(
                        $this->getParameter('uploads_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    return $e->getMessage();
                }
                $projet->setCoverImage($newFilename);
            }

            $images = $form->get('galeryImages')->getData();
            foreach($images as $image){
                $file = md5(uniqid()).'.'.$image->guessExtension();
                $image->move(
                    $this->getParameter('uploads_directory'),
                    $file
                );
                $img = new GaleryPortfolio();
                $img->setFile($file);
                $img->setCaptionFr('');
                $img->setCaptionEn('');
                $projet->addGaleryImage($img);

            }

            $manager->persist($projet);
            $manager->flush();

            $this->addFlash(
                'success',
                "Le projet <strong>{$projet->getTitleFr()}</strong> a bien été enregistré!"
            );

            return $this->redirectToRoute('admin_portfolio');
        }

        return $this->render("portfolio/addPortfolio.html.twig",[
            'myform' => $form->createView()
        ]);
    }

    #[Route('deleteImage/{id}', name: 'image_delete', methods: ['GET','POST'])]
    #[IsGranted("ROLE_ADMIN")]
    public function ImageDelete(GaleryPortfolio $image, EntityManagerInterface $manager, Request $request){

        $this->addFlash('success', "L'image {$image->getId()} a bien été supprimée");
       //supression de la cover image
       $url = $image->getFile();
      
            unlink($this ->getParameter('uploads_directory').'/'.$image->getFile());
        
        $manager->remove($image);
        $manager->flush();
        $referer = $request->headers->get('referer');
            
        return new RedirectResponse($referer);
    }
    

    #[Route('portfolio/{id}/edit', name:"admin_edit_portfolio")]
    #[IsGranted("ROLE_ADMIN")]
    public function editProject(Portfolio $project,Request $request, EntityManagerInterface $manager ):Response
    {
    
        $form = $this->createForm(PortfolioType::class, $project);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        { 
            $file = $form['cover']->getData();
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
                $project->setCoverImage($newFilename);
            }
            $images = $form->get('galeryImages')->getData();
            foreach($images as $image){
                $file = md5(uniqid()) . '.' .$image->guessExtension();
                $image->move(
                    $this->getParameter('uploads_directory'),
                    $file
                );

                $img = new GaleryPortfolio();
                $img->setFile($file);
                $img->setCaptionFr('');
                $img->setCaptionEn('');
                $project->addGaleryImage($img);
            }
            $manager->persist($project);
            $manager->flush();
            $this->addFlash('success', "Le projet {$project->getId()} a bien été modifié");
            return $this->redirectToRoute('admin_portfolio');
        }


        return $this->render("portfolio/editPortfolio.html.twig",[
            "project"=>$project,
            "myform"=>$form->createView()
        ]);
    }

    #[Route("/portfolio/{id}/delete", name:"admin_delete_portfolio")]
    #[IsGranted("ROLE_ADMIN")]
    public function delete(Portfolio $project, EntityManagerInterface $manager)
    {
        $this->addFlash('success', "Le projet {$project->getId()} a bien été supprimé");

       //supression de la cover image
        unlink($this ->getParameter('uploads_directory').'/'.$project->getCoverImage());
        
        $manager->remove($project);
        $manager->flush();
        return $this->redirectToRoute('admin_portfolio');
    }
}
