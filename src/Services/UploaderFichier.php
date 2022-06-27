<?php

use App\Repository\CandidatureRepository;

class UploaderFichier
{
    private CandidatureRepository $candidatureRepo;

    public function __construct(CandidatureRepository $candidatureRepo)
    {
        $this->candidatureRepo = $candidatureRepo;
    }

    public function upload()
    {
        $nom = md5(uniqid());

        $fichiers = $request->files->get("candidature")["fichiers"];

        $nouveauNom = $nom . "." . $fichiers->guessExtension();

        $fichiers->move($this->getParameter("fichiers_directory"), $nouveauNom);

    }

}