<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use App\Entity\Categoria;

class CategoriaController extends AbstractController
{
    /**
     * @Route("/categoria", name="categoria_create", methods={"POST"})
     */
    public function create(Request $request, ValidatorInterface $validator)
    {
        $nome = ($request->get('nome')) ?: '';
        $descricao = ($request->get('descricao')) ?: '';
        
        $categoria = new Categoria();
        $categoria->setNome($nome);
        $categoria->setDescricao($descricao);
        
        $errors = $validator->validate($categoria);
        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            
            return $this->json([
                'message' => $errorsString
            ], 400);
        }
        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($categoria);
        $entityManager->flush();
        
        return $this->json([
            'message' => 'Categoria cadastrada com sucesso.'
        ], 200);
    }
    
    /**
     * @Route("/categoria/{id}", name="categoria_delete", methods={"DELETE"})
     */
    public function delete(int $id)
    {
        $categoria = $this->getDoctrine()->getRepository(Categoria::class)->find($id);

        if (!$categoria) {
            return $this->json([
                'message' => 'Categoria não encontrada.'
            ], 400);
        }
        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($categoria);
        $entityManager->flush();
        
        return $this->json([
            'message' => 'Categoria excluída com sucesso.'
        ], 200);
    }
    
    /**
     * @Route("/categoria/{id}", name="categoria_update", methods={"PUT"})
     */
    public function update(Request $request, ValidatorInterface $validator, int $id)
    {
        $categoria = $this->getDoctrine()->getRepository(Categoria::class)->find($id);

        if (!$categoria) {
            return $this->json([
                'message' => 'Categoria não encontrada.'
            ], 400);
        }
        
        $nome = ($request->get('nome')) ?: '';
        $descricao = ($request->get('descricao')) ?: '';
        
        if(!empty($nome)){
            $categoria->setNome($nome);
        }
        
        $categoria->setDescricao($descricao);
        
        $errors = $validator->validate($categoria);
        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            
            return $this->json([
                'message' => $errorsString
            ], 400);
        }
        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($categoria);
        $entityManager->flush();
        
        return $this->json([
            'message' => 'Categoria atualizada com sucesso.'
        ], 200);
    }
    
    /**
     * @Route("/categoria/{id}", name="categoria_read", methods={"GET","HEAD"})
     */
    public function read(int $id)
    {
        $categoria = $this->getDoctrine()->getRepository(Categoria::class)->find($id);
        
        if (!$categoria) {
            return $this->json([
                'message' => 'Categoria não encontrada.'
            ], 400);
        }
        
        $normalizer = new ObjectNormalizer();
        $encoder = new JsonEncoder();

        $serializer = new Serializer([$normalizer], [$encoder]);
        $jsonContent = $serializer->serialize($categoria, 'json');

        return $this->json([
            $jsonContent
        ], 200);
    }
}
