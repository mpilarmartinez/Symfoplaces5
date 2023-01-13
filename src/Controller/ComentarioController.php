<?php

namespace App\Controller;

use App\Entity\Comentario;
use App\Form\ComentarioType;
use App\Entity\Lugar;
use App\Repository\ComentarioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/comentario')]
class ComentarioController extends AbstractController
{
  

    #[Route('/new{id}', name: 'app_comentario_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ComentarioRepository $comentarioRepository, Lugar $lugar): Response
    {
        $comentario = new Comentario();
        
        $form = $this->createForm(ComentarioType::class, $comentario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comentario->setLugar($lugar);
            $comentarioRepository->add($comentario);
            return $this->redirectToRoute('app_lugar_show', ['id'=> $lugar->getId()]);
        }

        return $this->renderForm('lugar/show.html.twig', [
            'lugar' => $lugar,
            'form' => $form,
        ]);
    }

 
    #[Route('/{id}/{lugar}', name: 'app_comentario_delete', methods: ['POST'])]
    public function delete(Request $request, Comentario $comentario, Lugar $lugar, ComentarioRepository $comentarioRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$comentario->getId(), $request->request->get('_token'))) {
            $comentarioRepository->remove($comentario);
        }

        return $this->redirectToRoute('app_lugar_show', ['id' => $lugar->getId()]);
    }
}
