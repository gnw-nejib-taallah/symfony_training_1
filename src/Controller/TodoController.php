<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/todo')]
class TodoController extends AbstractController
{
    #[Route('/', name: 'todo')]
    public function index(Request $request): Response{
        $session = $request->getSession();
        if( ! $session->has(name: 'todos')){
            $todos = [
                'achat' => 'acheter clé usb',
                'cours' => 'finaliser mon cours',
                'correction' =>'corriger mes examens'
            ];
            $session->set('todos' , $todos);
            $this->addFlash(type:'info', message:"La liste des todos viens d'étre initialisée");
        }
        return $this->render('todo/index.html.twig');
    }
    #[Route(
        '/add/{name?test}/{content?test}',
         name: 'todo.add',
         //defaults: ['name' => 'sf6','content' => 'sport']
    )]
    public function addTodo(Request $request, $name, $content): RedirectResponse{
        $session = $request->getSession();
        if($session->has(name: 'todos')){
           $todos = $session->get(name:'todos');
           if(isset($todos[$name])){
                $this->addFlash(type:'error', message:"Le todo d'id $name existe déja dans la liste");
           }else{
                $todos[$name] = $content;
                $session->set('todos', $todos);
                $this->addFlash(type:'success', message:"Le todo d'id $name a été ajouté avec succés");
               
           }
        }else{
            $this->addFlash(type:'error', message:"La liste des todos n'est pas encore initialisée");
        }
        return $this->redirectToRoute(route:'todo');
    } 
    #[Route('/update/{name}/{content}', name: 'todo.update')]
    public function updateTodo(Request $request, $name, $content): RedirectResponse{
        $session = $request->getSession();
        if($session->has(name: 'todos')){
           $todos = $session->get(name:'todos');
           if(!isset($todos[$name])){
                $this->addFlash(type:'error', message:"Le todo d'id $name n'existe pas dans la liste");
           }else{
                $todos[$name] = $content;
                $session->set('todos', $todos);
                $this->addFlash(type:'success', message:"Le todo d'id $name a été modifié avec succés");
               
           }
        }else{
            $this->addFlash(type:'error', message:"La liste des todos n'est pas encore initialisée");
        }
        return $this->redirectToRoute(route:'todo');
    }
    #[Route('/delete/{name}', name: 'todo.delete')]
    public function deleteTodo(Request $request, $name): RedirectResponse{
        $session = $request->getSession();
        if($session->has(name: 'todos')){
           $todos = $session->get(name:'todos');
           if(!isset($todos[$name])){
                $this->addFlash(type:'error', message:"Le todo d'id $name n'existe pas dans la liste");
           }else{
               unset($todos[$name]);
                $session->set('todos', $todos);
                $this->addFlash(type:'success', message:"Le todo d'id $name a été suprimé avec succés");
               
           }
        }else{
            $this->addFlash(type:'error', message:"La liste des todos n'est pas encore initialisée");
        }
        return $this->redirectToRoute(route:'todo');
    }
    #[Route('/reset', name: 'todo.reset')]
    public function resetTodo(Request $request): RedirectResponse{
        $session = $request->getSession();
        $session->remove(name: 'todos');
        return $this->redirectToRoute(route:'todo');
    }
}

