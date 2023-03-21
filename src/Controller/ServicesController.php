<?php

namespace App\Controller;

use App\Entity\Services;
use App\Form\ServiceType;
use App\Repository\ServicesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ServicesController extends AbstractController
{
    #[Route('/services', name: 'admin_services')]
    #[IsGranted("ROLE_ADMIN")]
    public function index(ServicesRepository $repo): Response
    {
        $services = $repo->findAll();
        
        return $this->render('services/index.html.twig', [
            'services' => $services,
        ]);
    }

    #[Route('/services/add', name:"admin_add_service")]
    #[IsGranted("ROLE_ADMIN")]
    public function addService(EntityManagerInterface $manager, Request $request):Response
    {
        $service = new Services();

        $form=$this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            
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
                $service->setImage($newFilename);
            }

            $manager->persist($service);
            $manager->flush();

            $this->addFlash(
                'success',
                "Le service <strong>{$service->getTitleFr()}</strong> a bien été enregistrée!"
            );

            return $this->redirectToRoute('admin_services');
        }

        return $this->render("services/addService.html.twig",[
            'myform'=>$form->createView()
        ]);
    }

     /**
     * Delete a page
     */
    #[Route('sercices/{id}/delete', name:"admin_delete_service")]
    #[IsGranted("ROLE_ADMIN")]
    public function deleteService (Services $service, EntityManagerInterface $manager):Response
    {
        $this->addFlash(
            'success',
            "Le service <strong>{$service->getId()}</strong> a été supprimée"
        );

       
        unlink($this ->getParameter('uploads_directory').'/'.$service->getImage());
      

        $manager->remove($service);
        $manager->flush();

        return $this->redirectToRoute('admin_services');
    }

    #[Route('/services/{id}/edit', name:"admin_edit_service")]
    #[IsGranted("ROLE_ADMIN")]
    public function editService (Services $service, EntityManagerInterface $manager, Request $request):Response
    {
        $form=$this->createForm(ServiceType::class, $service);
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
                
                $service->setImage($newFilename);
            }

            $manager->persist($service);
            $manager->flush();
            $this->addFlash(
                'success',
                "Le membre <strong>{$service->getTitleFr()}</strong> a bien été modifié"
            );
            return $this->redirectToRoute('admin_services');
            
        }
        return $this->render("services/editService.html.twig",[
            "service"=>$service,
            "myform"=>$form->createView()
        ]);

    }
}

