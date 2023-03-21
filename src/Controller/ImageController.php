<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends AbstractController
{
   /**
     * @Route("/images/{filename}", name="app_image")
     */
    public function index(string $filename): Response
    {
        // Récupérer le chemin absolu de l'image
        $path = $this->getParameter('kernel.project_dir') . '/public/uploads/' . $filename;

        // Vérifier que le fichier existe
        if (!file_exists($path)) {
            throw $this->createNotFoundException();
        }

        // Lire le fichier image et renvoyer la réponse
        $response = new Response();
        $response->headers->set('Content-Type', 'image/jpeg');
        $response->setContent(file_get_contents($path));

        return $response;
    }
}
