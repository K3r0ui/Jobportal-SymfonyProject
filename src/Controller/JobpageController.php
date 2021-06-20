<?php

namespace App\Controller;

use App\Entity\Demploi;
use App\Entity\Oemploi;
use App\Entity\Parametre;
use App\Repository\OemploiRepository;
use App\Repository\DemploiRepository;
use App\Repository\CategorieRepository;
use App\Repository\ParametreRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class JobpageController extends AbstractController
{
    /**
     * @Route("/jobpage/{id}", name="jobpage")
     */
    public function jobpage($id,CategorieRepository $categoRepository): Response
    {
        $categorie = $categoRepository->findAll();
        $oemploi = $this->getDoctrine()->getRepository(Oemploi::class)->find($id);
        return $this->render('index/jobpage.html.twig',  array(
            'oemplois' => $oemploi,
            'categories' => $categorie,
));
    }
        /**
     * @Route("/jobpage/{id}/app", name="jobpage_apply")
     */
    public function applyjobpage(Request $request,$id, DemploiRepository $demploiRepository, ParametreRepository $parametreRepository): Response

    { //verification if existe meme demande ou nn 
        
        $oemploi = $this->getDoctrine()->getRepository(Oemploi::class)->find($id);
        $demm = $demploiRepository->findByExampleField($id,$this->getUser());
        $param = $parametreRepository->findOneBy(['nom' => 'tentativecondidat']);
            if ($param->getNom() == "tentativecondidat"){
                $val = $param->getAttempts();
            }
        
        foreach ( $demm as $d){
            if ($d->getEtat() == "Accepted"){
                $this->addFlash('message','Job Aleardy Applied');
                return $this->redirectToRoute('profile');
            }
        }
        if ( $request->isMethod('POST')){
            
            $date = new \DateTime();
            $dateformat = $date->format('Y-m-d');
            $condidat = $this->getUser();
            if ($condidat->getTentative() == null || $condidat->getLastattempt()->format('Y-m-d') != $dateformat ){
            $condidat->setTentative($val+1);
            }
            if ( $condidat->getTentative() == 1 ){
                $this->addFlash('message','You Reached Max Attempts Today');
                return $this->redirectToRoute('profile');
            }
            //if ($condidat->lastAttempt())
            $tent = $condidat->getTentative();
            $demploi = new Demploi;
            $demploi->setIdcondidat($condidat);
            $demploi->setDate(new \DateTime());
            $demploi->setOemploi($oemploi);
            $demploi->setEtat('Pending');
            $condidat->setTentative($tent-1);
            $datecondidat = new \DateTime();
            $condidat->setLastattempt($datecondidat);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($demploi,$condidat);
            $entityManager->flush();
                $this->addFlash('message',' Job Applied ');
                return $this->redirectToRoute('profile');
            }else{
                $this->addFlash('error',' Password Doesn\'t match ');
            }
            return $this->render('index/index.html.twig');
        }

        
        
    
}
