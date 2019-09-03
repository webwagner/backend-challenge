<?php
/**
 * @SWG\Swagger(schemes={"http"}, basePath="/", @SWG\Info(version="1.0.0", title="Api Exemplo API"))
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use App\Entity\Aula;
use App\Entity\Categoria;

class AulaController extends AbstractController
{
    /**   
    * @Route("/aula", name="aula_create", methods={"POST"})
    */
    public function create(Request $request, ValidatorInterface $validator)
    {
        $titulo = ($request->get('titulo')) ?: '';
        $descricao = ($request->get('descricao')) ?: '';
        $link = ($request->get('link')) ?: '';
        $categorias = ($request->getContent()) ?: '';
        
        $aula = new Aula();
        $aula->setTitulo($titulo);
        $aula->setDescricao($descricao);
        $aula->setLink($link);
        
        $errors = $validator->validate($aula);
        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            
            return $this->json([
                'message' => $errorsString
            ], 400);
        }
        
        if(!empty($categorias)){
            $rows = json_decode($categorias);
            
            foreach ($rows as $row){
                if($categoria = $this->getDoctrine()->getRepository(Categoria::class)->findOneBy(array('nome' => $row))){
                    $aula->addIdcategorium($categoria);
                }
            }
        } 
        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($aula);
        $entityManager->flush();
        
        return $this->json([
            'message' => 'Aula cadastrada com sucesso.'
        ], 200);
    }
    
    /**
    * @Route("/aula/{id}", name="aula_delete", methods={"DELETE"})
    */
    public function delete(int $id)
    {
        $aula = $this->getDoctrine()->getRepository(Aula::class)->find($id);

        if (!$aula) {
            return $this->json([
                'message' => 'Aula não encontrada.'
            ], 400);
        }
        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($aula);
        $entityManager->flush();
        
        return $this->json([
            'message' => 'Aula excluída com sucesso.'
        ], 200);
    }
    
    /**
    * @Route("/aula/{id}", name="aula_update", methods={"PUT"})
    */
    public function update(Request $request, ValidatorInterface $validator, int $id)
    {
        $aula = $this->getDoctrine()->getRepository(Aula::class)->find($id);

        if (!$aula) {
            return $this->json([
                'message' => 'Aula não encontrada.'
            ], 400);
        }
        
        $titulo = ($request->get('titulo')) ?: '';
        $descricao = ($request->get('descricao')) ?: '';
        $link = ($request->get('link')) ?: '';
        $categorias = ($request->getContent()) ?: '';
        
        if(!empty($titulo)){
            $aula->setTitulo($titulo);
        }
         
        if(!empty($link)){
            $aula->setLink($link);
        }

        $aula->setDescricao($descricao);
        
        $errors = $validator->validate($aula);
        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            
            return $this->json([
                'message' => $errorsString
            ], 400);
        }
        
        if(!empty($categorias)){
            $categoriasAula = $aula->getIdcategoria();
            foreach ($categoriasAula as $categoriaAula){
                $aula->removeIdcategorium($categoriaAula);
            }
            
            $rows = json_decode($categorias);
            foreach ($rows as $row){
                if($categoria = $this->getDoctrine()->getRepository(Categoria::class)->findOneBy(array('nome' => $row))){
                    $aula->addIdcategorium($categoria);
                }
            }
        }
        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($aula);
        $entityManager->flush();
        
        return $this->json([
            'message' => 'Aula atualizada com sucesso.'
        ], 200);
    }
    
    /**
    * @Route("/aula/{id}", name="aula_read", methods={"GET","HEAD"})
    */
    public function read(int $id)
    {
        $aula = $this->getDoctrine()->getRepository(Aula::class)->find($id);
        
        if (!$aula) {
            return $this->json([
                'message' => 'Aula não encontrada.'
            ], 400);
        }
        
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);
        $normalizer->setCircularReferenceHandler(function($object){
            return $object->getIdcategoria();
        });
        $encoder = new JsonEncoder();

        $serializer = new Serializer([$normalizer], [$encoder]);
        $jsonContent = $serializer->serialize($aula, 'json');

        return $this->json([
            $jsonContent
        ], 200);
    }
}
