<?php

namespace App\Controller;

use App\Entity\Metier;
use App\Entity\Offre;
use App\Repository\MetierRepository;
use App\Repository\OffreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ImportController
 * @package App\Controller
 */
class ImportController extends AbstractController
{
    private $offre_repository;
    private $metier_repository;
    private $em;

    /**
     * ImportController constructor.
     * @param MetierRepository $metier_repository
     * @param OffreRepository $offre_repository
     */
    public function __construct(MetierRepository $metier_repository, OffreRepository $offre_repository, EntityManagerInterface $em)
    {
        $this->offre_repository  = $offre_repository;
        $this->em                = $em;
        $this->metier_repository = $metier_repository;
    }

    /**
     * @Route("/back", name="import")
     */
    public function index(): Response
    {
        return $this->render('import/index.html.twig');
    }

    /**
     * @Route("/import-action", name="import_action")
     */
    public function importAction(Request $request)
    {
        try {
            $content_file       = simplexml_load_string(file_get_contents($_FILES['xml_file']['tmp_name']));
            $content_file_json  = json_encode($content_file);
            $content_file_array = json_decode($content_file_json, true);
        } catch (FileException $file_exception) {
            print_r($file_exception);
        }
        if (is_array($content_file_array) && is_array($content_file_array['offre'])) {
            foreach ($content_file_array['offre'] as $key => $item) {
                // instance objet metier
                $metier = new Metier();
                $metier->setSalaire($item['metier']['salaire'] ? $item['metier']['salaire'] : '');
                $metier->setContrat($item['metier']['contrat'] ? $item['metier']['contrat'] : '');
                $metier->setCddDuree($item['metier']['cdd_duree'] ? $item['metier']['cdd_duree'] : '');
                $metier->setVisibilite($item['metier']['visibilite'] ? $item['metier']['visibilite'] : '');
                $metier->setEntretient($item['metier']['entretient'] ? $item['metier']['entretient'] : '');
                $metier->setAdresse($item['metier']['adresse'] ? $item['metier']['adresse'] : '');
                $metier->setCp($item['metier']['cp'] ? $item['metier']['cp'] : '');
                $metier->setFacebook($item['metier']['facebook'] ? $item['metier']['facebook'] : '');
                $metier->setTwitter($item['metier']['twitter'] ? $item['metier']['twitter'] : '');
                $metier->setMail($item['metier']['mail'] ? $item['metier']['mail'] : '');
                $metier->setMailSuivi($item['metier']['mail_suivi'] ? $item['metier']['mail_suivi'] : '');
                $metier->setContact($item['metier']['contact'] ? $item['metier']['contact'] : '');
                $metier->setModeReponse($item['metier']['mode_reponse'] ? $item['metier']['mode_reponse'] : '');

                // instance objet offre
                $offre = new Offre();
                $offre->setNomEntreprise($item['nom_entreprise'] ? $item['nom_entreprise'] : '');
                $offre->setRef($item['ref'] ? $item['ref'] : '');
                $offre->setTitre($item['titre'] ? $item['titre'] : '');
                $offre->setLocalisation($item['localisation'] ? $item['localisation'] : '');
                $offre->setPays($item['pays'] ? $item['pays'] : '');
                $offre->setSite($item['site'] ? $item['site'] : '');
                $offre->setDescription($item['description'] ? $item['description'] : []);
                $offre->setSecteur($item['secteur'] ? $item['secteur'] : '');
                $offre->setExperience($item['experience'] ? $item['experience'] : '');
                $offre->setMetier($metier);

                $this->em->persist($metier);
                $this->em->persist($offre);
                $this->em->flush();
            }
        }

        return $this->redirectToRoute('import');
    }
}
