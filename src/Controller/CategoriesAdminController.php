<?php

namespace App\Controller;

use Framework\Controller;
use GuzzleHttp\Psr7\ServerRequest as Request;

class CategoriesAdminController extends Controller
{
    public function index(Request $request)
    {
        if ($request->getMethod() === "POST") {
            $category = $this->entity->getEntity('categories');

            $data =  $request->getParsedBody();

            $category->entity->setName($data['name']);
            $category->entity->setSlug($this->generateSlug($data['name']));


            
            if ($this->entity->save($category->entity)) {
                $this->setFlash(['type' => 'success', 'message' => 'La catégorie à bien été ajouté']);

                return $this->router->redirect('admin.categoriesIndex');
            }
        }

        $categories = $this->entity->getEntity('categories')->findAll();

        $this->renderview('back/categorie/index.html.twig', ['categories' => $categories]);
    }
    public function edit($id, Request $request)
    {
        $category = $this->entity->getEntity('categories')->findById($id);
        

        if ($request->getMethod() === "POST") {
            $data =  $request->getParsedBody();

            $category->setName($data['name']);
            $category->setSlug($this->generateSlug($data['name']));


            
            if ($this->entity->update($category)) {
                $this->setFlash(['type' => 'success', 'message' => 'La catégorie à bien été modifié']);

                return $this->router->redirect('admin.categoriesIndex');
            }
        }
         

        $this->renderview('back/categorie/edit.html.twig', ['category' => $category]);
    }


    public function delete($id)
    {
        $categorie = $this->entity->getEntity('categories')->findById($id);
        if ($this->entity->delete($categorie)) {
            $this->setFlash(['type' => 'success', 'message' => 'La catégorie à bien été supprimé']);

            return $this->router->redirect('admin.categoriesIndex');
        }
    }
}
