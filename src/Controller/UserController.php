<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    /**
     * @Route(
     *      "/home",
     *      name="home",
     *      methods={"GET"}
     *  )
     */
    
    public function home(){

        // rechaza usuarios no identificados
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        // CARGA LA VISTA CON LA INFOMRACIÓN DEL USUARIO
        return $this->render('users/home.html.twig');
        
    }


    /**
     * @Route(
     *      "/user/delete/{id}",
     *      name="user_delete",
     *      methods={"GET", "POST"}
     *  )
     */
    
    public function user_delete(User $user){
        
        // rechaza usuarios no identificados
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        $comentarios = $user->getComentarios();
        foreach($comentarios as $comentario){
            $comentario->setUser(null);
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush($comentario);
        }
        
        foreach($lugares as $lugar){
            $lugar->setUser(null);
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush($lugar);
        }

        
        // CARGA LA VISTA CON LA INFORMACIÓN DEL USUARIO
        return $this->render('users/home.html.twig');
        
    }











}
