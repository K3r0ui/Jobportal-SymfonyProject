<?php

namespace App\Controller\Backend;

use App\Entity\Rdv;
use App\Entity\Demploi;
use App\Entity\Condidat;
use App\Repository\CondidatRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CondidatController extends AbstractController
{
   /**
     * @Route("/backend/condidat", name="backend_condidat_home")
     */
    public function index(CondidatRepository $condidatRepo): Response
    {
        
        return $this->render('backend/condidat/index.html.twig', [
            'condidat' => $condidatRepo->findAll()
        ]);
    }
        /**
     * @Route("/backend/condidat/delete/{id}", name="backend_condidat_del")
     */
    public function delete(Request $request, $id) {
        $condidat = $this->getDoctrine()->getRepository(Condidat::class)->find($id);
        $demploi = $this->getDoctrine()->getRepository(Demploi::class)->findOneBy(["idcondidat" => $id]);
        $vv = $demploi->getId();
        $rdv = $this->getDoctrine()->getRepository(Rdv::class)->findOneBy(["demploi" => $vv]);
        $ss = $condidat->getId();
        $cc = $demploi->getIdcondidat()->getId();
        $hh = $rdv->getDemploi()->getId();
        $entityManager = $this->getDoctrine()->getManager();
        if($ss == $cc )
        { 
            if($vv == $hh ){
                $entityManager->remove($rdv);
            }
            $entityManager->remove($demploi);
            $entityManager->remove($condidat);
        }else{
        $entityManager->remove($condidat);
        }
        $entityManager->flush();
  
        return $this->redirectToRoute('backend_condidat_home');
      }
}
