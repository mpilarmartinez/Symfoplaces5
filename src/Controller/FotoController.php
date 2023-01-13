<?php

namespace App\Controller;

use App\Entity\Foto;
use App\Form\FotoType;
use App\Repository\FotoRepository;
use App\Entity\Lugar;
use App\Form\LugarType;
use App\Service\FileService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/foto')]
class FotoController extends AbstractController
{
    #[Route('/', name: 'app_foto_index', methods: ['GET'])]
    public function index(FotoRepository $fotoRepository): Response
    {
        return $this->render('foto/index.html.twig', [
            'fotos' => $fotoRepository->findAll(),
        ]);
    }

    #[Route('/new/{id}', name: 'app_foto_new', methods: ['GET', 'POST'])]
    public function new(Request $request,
        FileService $fileService,
        FotoRepository $fotoRepository,
        Lugar $lugar): Response
    {
        $foto = new Foto();
        $formFoto = $this->createForm(FotoType::class, $foto);
        $formFoto->handleRequest($request);
        $form = $this->createForm(LugarType::class, $lugar);

        
        if ($formFoto->isSubmitted() && $formFoto->isValid()) {
            
            if($uploadedFile = $formFoto->get('archivo')->getData()){
                
                $fileService->setTargetDirectory($this->getParameter('app.photos.root'));
                
                $foto->setArchivo($fileService->upload($uploadedFile, true, 'photo_'));
            }
            
            
            $lugar->addFoto($foto);
            $fotoRepository->add($foto);
           
            
            return $this->redirectToRoute('app_lugar_edit', ['id' => $lugar->getId()]);
        }

        return $this->render('lugar/edit.html.twig', [
            'foto' => $foto,
            'formFoto' => $formFoto->createView(),
            'form' => $form->createView(),
        ]);
    }

  

    #[Route('/show/{id}', name: 'app_foto_show', methods: ['GET'])]
    public function show(Foto $foto): Response
    {
        return $this->render('foto/show.html.twig', [
            'foto' => $foto,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_foto_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Foto $foto, FotoRepository $fotoRepository): Response
    {
        $form = $this->createForm(FotoType::class, $foto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fotoRepository->add($foto);
            return $this->redirectToRoute('app_foto_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('foto/edit.html.twig', [
            'foto' => $foto,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}/{lugar}', name: 'app_foto_delete', methods: ['POST'])]
    public function delete(Request $request, Foto $foto, Lugar $lugar, FotoRepository $fotoRepository, FileService $fileService): Response
    {
       
        
        
        
    if ($this->isCsrfTokenValid('delete'.$foto->getId(), $request->request->get('_token'))) {
           
        $fileService->setTargetDirectory($this->getParameter('app.photos.root'));
        
        $foto->setArchivo($fileService->remove($foto->getArchivo()));
        
        
        $fotoRepository->remove($foto);
        }

        return $this->redirectToRoute('app_lugar_edit', ['id' => $lugar->getId()]);
    }
}
