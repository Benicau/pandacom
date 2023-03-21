<?php

namespace App\Controller;

use App\Entity\Team;
use App\Form\TeamType;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class TeamController extends AbstractController
{
    /** Show all pages */
    #[Route('/team', name: 'admin_team')]
    #[Security("is_granted('ROLE_ADMIN')")]
    public function index(TeamRepository $repo): Response
    {
        $team = $repo->findAll();

        return $this->render('team/index.html.twig', [
            'team' => $team,
        ]);
    }

    /**
     * Add a new page
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/team/add', name:'admin_add_team')]
    #[Security("is_granted('ROLE_ADMIN')")]
    public function addMember(Request $request, EntityManagerInterface $manager):Response
    {
        $team = new Team();

        $form=$this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $file = $form['image']->getData();
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
                $team->setImage($newFilename);
            }

            $manager->persist($team);
            $manager->flush();

            $this->addFlash(
                'success',
                "Le membre <strong>{$team->getName()}</strong> a bien été enregistrée!"
            );

            return $this->redirectToRoute('admin_team');
        }

        return $this->render("team/addTeam.html.twig",[
            'myform'=>$form->createView()
        ]);
    }


    /**
     * Delete a page
     */
    #[Route('/team/{id}/delete', name:"admin_delete_team")]
    #[Security("is_granted('ROLE_ADMIN')")]
    public function deleteMember(Team $team, EntityManagerInterface $manager):Response
    {
        $this->addFlash(
            'success',
            "Le membre <strong>{$team->getId()}</strong> a été supprimée"
        );

        if(!$team->getImage() == ""){
            unlink($this ->getParameter('uploads_directory').'/'.$team->getImage());
        }

        $manager->remove($team);
        $manager->flush();

        return $this->redirectToRoute('admin_team');

    }


    #[Route('/team/{id}/edit', name:"admin_edit_team")]
    #[Security("is_granted('ROLE_ADMIN')")]
    public function modifMember(Team $team, Request $request, EntityManagerInterface $manager):Response
    {
        $form=$this->createForm(TeamType::class, $team);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $file = $form['image']->getData();
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
                $team->setImage($newFilename);
            }

            $manager->persist($team);
            $manager->flush();
            $this->addFlash(
                'success',
                "Le membre <strong>{$team->getName()}</strong> a bien été modifié"
            );
            return $this->redirectToRoute('admin_team');

        }
        return $this->render("team/editTeam.html.twig",[
            "team"=>$team,
            "myform"=>$form->createView()
        ]);
    }

    
}

