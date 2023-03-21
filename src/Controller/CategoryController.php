<?php

namespace App\Controller;

use App\Form\CategoryType;
use App\Entity\CatPortfolio;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CatPortfolioRepository;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    /** Show all category */
    #[Route('/category', name: 'admin_category')]
    #[Security("is_granted('ROLE_ADMIN')")]
    public function index(CatPortfolioRepository $repo): Response
    {
        $categories = $repo->findAll();

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * Add a new category
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/category/add', name:'admin_add_category')]
    #[Security("is_granted('ROLE_ADMIN')")]
    public function addCategory(Request $request, EntityManagerInterface $manager):Response
    {
        $category = new CatPortfolio();

        $form=$this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($category);
            $manager->flush();

            $this->addFlash(
                'success',
                "La catégorie <strong>{$category->getNameFr()}</strong> a bien été enregistrée!"
            );

            return $this->redirectToRoute('admin_category');
        }

        return $this->render("category/addCategory.html.twig",[
            'myform'=>$form->createView()
        ]);
    }

    /**
     * Editing a category
     */
    #[Route('/category/{id}/edit', name:"admin_edit_category")]
    #[Security("is_granted('ROLE_ADMIN')")]
    public function editCategory(CatPortfolio $category, Request $request, EntityManagerInterface $manager ):Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($category);
            $manager->flush();

            $this->addFlash(
                'success',
                "La catégorie <strong>{$category->getNameFr()}</strong> a bien été modifiée!"
            );

            return $this->redirectToRoute('admin_category');
        }

        return $this->render("category/editCategory.html.twig",[
            'category' =>$category,
            "myform"=> $form->createView()
        ]);

    }

    /**
     * Delete a category
     */
    #[Route('/category/{id}/delete', name:"admin_delete_category")]
    #[Security("is_granted('ROLE_ADMIN')")]
    public function categorydelete(CatPortfolio $category, EntityManagerInterface $manager):Response
    {
        $this->addFlash(
            'success',
            "La catégorie <strong>{$category->getId()}</strong> a été supprimée"
        );

        $manager->remove($category);
        $manager->flush();

        return $this->redirectToRoute('admin_category');

    }



}
