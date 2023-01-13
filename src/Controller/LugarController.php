<?php

namespace App\Controller;


use App\Entity\Lugar;
use App\Entity\Foto;
use App\Entity\Comentario;
use App\Form\LugarType;
use App\Form\FotoType;
use App\Form\ComentarioType;
use App\Form\SearchFormType;
use App\Service\PaginatorService;
use App\Repository\LugarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;
use App\Service\SimpleSearchService;

#[Route('/lugar')]
class LugarController extends AbstractController
{
    
    #[Route('/index/search/{pagina}', name: 'app_lugar_search', methods: ['GET', 'POST'])]
    public function search(Request $request, PaginatorService $paginator, LugarRepository $lugarRepository, SimpleSearchService $busqueda, int $pagina = 1): Response
    {
        
        $formulario = $this->createForm(SearchFormType::class, $busqueda, [
            'field_choices' => [
                'Nombre' => 'nombre',
                'Pais' => 'pais',
                'Descripcion' => 'descripcion',
                'Tipo' => 'tipo'
             ],
            'order_choices' => [
                'ID' => 'id',
                'Nombre' => 'nombre',
                'Pais' => 'pais',
                'Descripcion' => 'descripcion',
             ]
        ]);
        
        
        // establece el valor selected para los SELECT
        $formulario->get('campo')->setData($busqueda->campo);
        $formulario->get('orden')->setData($busqueda->orden);
        
        // gestiona el formulario y recupera los valores de busqueda
        $formulario->handleRequest($request);
        
        // realiza la busqueda
        $lugars = $busqueda->search('App\Entity\Lugar');
        
        // retorna la vista con los resultados
        return $this->renderForm('lugar/list.html.twig', [
            'formulario' => $formulario,
            'lugars' => $lugars
        ]);
    }
    
    #[Route('/index/{pagina}', name: 'app_lugar_index', methods: ['GET'])]
    public function index(PaginatorService $paginator, LugarRepository $lugarRepository, int $pagina = 1): Response
    {
        
        $paginator->setEntityType('App\Entity\Lugar');
        
        $lugares = $paginator->findAllEntities($pagina);
               
        
        return $this->render('lugar/index.html.twig', [
            'lugars' => $lugares,
            'paginator' => $paginator
        ]);
    }

    #[Route('/new', name: 'app_lugar_new', methods: ['GET', 'POST'])]
    public function new(Request $request, LugarRepository $lugarRepository, LoggerInterface $appInfoLogger): Response
    {
        $lugar = new Lugar();
        $form = $this->createForm(LugarType::class, $lugar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lugarRepository->add($lugar, true);
            $mensaje = 'Lugar '.$lugar->getNombre().' guardada con id '.$lugar->getId();
            $this->addFlash('success', $mensaje);
            $appInfoLogger->info($mensaje);
            return $this->redirectToRoute('app_lugar_index', [], Response::HTTP_SEE_OTHER);
        }


        return $this->renderForm('lugar/new.html.twig', [
            'lugar' => $lugar,
            'form' => $form,
        ]);
    }

    #[Route('/show/{id}', name: 'app_lugar_show', methods: ['GET'])]
    public function show(Lugar $lugar): Response
    {
        $comentario = new Comentario();
        $form = $this->createForm(ComentarioType::class, $comentario);
      
        return $this->renderForm('lugar/show.html.twig', [
            'lugar' => $lugar,
            'form' => $form,
        ]);

    }

    
    #[Route('/{id}/edit', name: 'app_lugar_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Lugar $lugar, LugarRepository $lugarRepository): Response
    {
        $form = $this->createForm(LugarType::class, $lugar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lugarRepository->add($lugar);
            return $this->redirectToRoute('app_lugar_index', [], Response::HTTP_SEE_OTHER);
        }

       
        $foto = new Foto();
        $formFoto = $this->createForm(FotoType::class, $foto);
        
        
        return $this->render('lugar/edit.html.twig', [
            'lugar' => $lugar,
            'form' => $form->createView(),
            'formFoto' => $formFoto->createView()
        ]);
    }


    
    #[Route('/{id}', name: 'app_lugar_delete', methods: ['POST'])]
    public function delete(Request $request, Lugar $lugar, LugarRepository $lugarRepository): Response
    {
      
      if ($this->isCsrfTokenValid('delete'.$lugar->getId(), $request->request->get('_token'))) {
            $lugarRepository->remove($lugar);
        }
        
      
        return $this->redirectToRoute('app_lugar_index', [], Response::HTTP_SEE_OTHER);
    }

    
    
}
