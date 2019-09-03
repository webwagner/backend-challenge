<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use App\Entity\Aula;
use App\Entity\Curso;

class CursoController extends AbstractController
{
    /**
     * @Route("/curso", name="curso_create", methods={"POST"})
     */
    public function create(Request $request, ValidatorInterface $validator)
    {
        $titulo = ($request->get('titulo')) ?: '';
        $descricao = ($request->get('descricao')) ?: '';
        $tipo = ($request->get('tipo')) ?: '';
        $aulas = ($request->getContent()) ?: '';
        
        $curso = new Curso();
        $curso->setTitulo($titulo);
        $curso->setDescricao($descricao);
        $curso->setTipo($tipo);
        
        if(!empty($aulas)){
            $rows = json_decode($aulas);
            foreach ($rows as $row){
                if($aula = $this->getDoctrine()->getRepository(Aula::class)->findOneBy(array('titulo' => $row))){
                    $curso->addIdaula($aula);
                }
            }
        }
        
        $errors = $validator->validate($curso);
        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            
            return $this->json([
                'message' => $errorsString
            ], 400);
        }
        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($curso);
        $entityManager->flush();
        
        return $this->json([
            'message' => 'Curso cadastrado com sucesso.'
        ], 200);
    }
    
    /**
     * @Route("/curso/{id}", name="curso_delete", methods={"DELETE"})
     */
    public function delete(int $id)
    {
        $curso = $this->getDoctrine()->getRepository(Curso::class)->find($id);

        if (!$curso) {
            return $this->json([
                'message' => 'Curso não encontrado.'
            ], 400);
        }
        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($curso);
        $entityManager->flush();
        
        return $this->json([
            'message' => 'Curso excluído com sucesso.'
        ], 200);
    }
    
    /**
     * @Route("/curso/{id}", name="curso_update", methods={"PUT"})
     */
    public function update(Request $request, ValidatorInterface $validator, int $id)
    {
        $curso = $this->getDoctrine()->getRepository(Curso::class)->find($id);

        if (!$curso) {
            return $this->json([
                'message' => 'Curso não encontrado.'
            ], 400);
        }
        
        $titulo = ($request->get('titulo')) ?: '';
        $descricao = ($request->get('descricao')) ?: '';
        $tipo = ($request->get('tipo')) ?: '';
        $aulas = ($request->getContent()) ?: '';
        
        if(!empty($titulo)){
            $curso->setTitulo($titulo);
        }
         
        if(!empty($tipo)){
            $curso->setTipo($tipo);
        }
        
        if(!empty($aulas)){
            $aulasCurso = $curso->getIdaula();
            foreach ($aulasCurso as $aulaCurso){
                $curso->removeIdaula($aulaCurso);
            }
            
            $rows = json_decode($aulas);
            foreach ($rows as $row){
                if($aula = $this->getDoctrine()->getRepository(Aula::class)->findOneBy(array('titulo' => $row))){
                    $curso->addIdaula($aula);
                }
            }
        }

        $curso->setDescricao($descricao);
        
        $errors = $validator->validate($curso);
        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            
            return $this->json([
                'message' => $errorsString
            ], 400);
        }
                
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($curso);
        $entityManager->flush();
        
        return $this->json([
            'message' => 'Curso atualizado com sucesso.'
        ], 200);
    }
    
    /**
     * @Route("/curso/{id}", name="curso_read", methods={"GET","HEAD"})
     */
    public function read(int $id)
    {
        $curso = $this->getDoctrine()->getRepository(Curso::class)->find($id);
        
        if (!$curso) {
            return $this->json([
                'message' => 'Curso não encontrado.'
            ], 400);
        }
        
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);
        $normalizer->setCircularReferenceHandler(function($object){
            return $object->getIdaula();
        });
        $encoder = new JsonEncoder();

        $serializer = new Serializer([$normalizer], [$encoder]);
        $jsonContent = $serializer->serialize($curso, 'json');

        return $this->json([
            $jsonContent
        ], 200);
    }
}
