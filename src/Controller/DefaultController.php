<?php

namespace App\Controller;

use App\Entity\Marque;
use App\Repository\CompositionRepository;
use App\Repository\CouleurRepository;
use App\Repository\DesignationRepository;
use App\Repository\EtatRepository;
use App\Repository\MarqueRepository;
use App\Repository\TailleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class DefaultController extends AbstractController
{
    /**
     * @Route("", name="app_index")
     */
    public function indexAction(): Response
    {
        return $this->render('/default/index.html.twig');
    }

	/**
	 * @Route("/options", name="app_options")
	 */
	public function indexOptionsAction(MarqueRepository $marqueRepository, TailleRepository $tailleRepository, EtatRepository $etatRepository, DesignationRepository $designationRepository, CouleurRepository $couleurRepository, CompositionRepository $compositionRepository): Response
	{
		return $this->render('/options/index.html.twig', [
			'marques'       => $marqueRepository->findAll(),
			'tailles'       => $tailleRepository->findAll(),
			'etats'         => $etatRepository->findAll(),
			'designations'  => $designationRepository->findAll(),
			'couleurs'      => $couleurRepository->findAll(),
			'compositions'  => $compositionRepository->findAll()
		]);
	}
}