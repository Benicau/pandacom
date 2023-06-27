<?php

namespace App\Controller;

use App\Entity\Pages;
use App\Form\PageType;
use App\Repository\PagesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PagesController extends AbstractController
{
    /** Show all pages */
    #[Route('/dashboard/pages', name: 'admin_pages')]
    
    public function index(PagesRepository $repo): Response
    {
        $pages = $repo->findAll();

        return $this->render('pages/index.html.twig', [
            'pages' => $pages,
        ]);
    }

    /**
     * Add a new page
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/dashboard/pages/add', name:'admin_add_page')]
    
    public function addPages(Request $request, EntityManagerInterface $manager):Response
    {
        $page = new Pages();

        $form=$this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($page);
            $manager->flush();

            $this->addFlash(
                'success',
                "La page <strong>{$page->getTitleFr()}</strong> a bien été enregistrée!"
            );

            return $this->redirectToRoute('admin_pages');
        }

        return $this->render("pages/addPage.html.twig",[
            'myform'=>$form->createView()
        ]);
    }

    /**
     * Editing a page
     */
    #[Route('/pages/{id}/edit', name:"admin_edit_page")]
   
    public function editPage(Pages $page, Request $request, EntityManagerInterface $manager ):Response
    {
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($page);
            $manager->flush();

            $this->addFlash(
                'success',
                "La page <strong>{$page->getTitleFr()}</strong> a bien été modifiée!"
            );

            return $this->redirectToRoute('admin_pages');
        }

        return $this->render("pages/editPage.html.twig",[
            'page' =>$page,
            "myform"=> $form->createView()
        ]);

    }

    /**
     * Delete a page
     */
    #[Route('pages/{id}/delete', name:"admin_delete_page")]
    
    public function pagedelete(Pages $page, EntityManagerInterface $manager):Response
    {
        $this->addFlash(
            'success',
            "La page <strong>{$page->getId()}</strong> a été supprimée"
        );

        $manager->remove($page);
        $manager->flush();

        return $this->redirectToRoute('admin_pages');

    }

    /**
     * @Route("/articles/{id}", name="article_show")
     */

     #[Route('pages/{id}', name:"admin_delete_page")]
     
    public function show(Pages $pages): Response
    {
        return $this->json([
            'id' => $pages->getId(),
        ]);
    }

}
