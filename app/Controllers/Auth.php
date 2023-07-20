<?php

namespace App\Controllers;

use App\Controllers\BaseController;


class Auth extends BaseController
{
    public function index()
    {

        return view('Auth/login');
    }

    public function login()
    {
        // Retrieve form input
        $matricule = $this->request->getPost('matricule');
        $titre = $this->request->getPost('titre');
        $accessCode = $this->request->getPost('access_code');

        // Charger le modèle UsersModel
        $usersModel = new \App\Models\UsersModel();

        // Rechercher un utilisateur correspondant aux informations d'identification fournies
        $user = $usersModel->where('matricule', $matricule)
            ->where('titre', $titre)
            ->where('code_acces', $accessCode)
            ->first();

        // Validate login credentials
        if ($this->validateLogin($matricule, $titre, $accessCode)) {
            // Set the user credentials in the session
            session()->set([
                'isLoggedIn' => true,
                'matricule' => $matricule,
                'titre' => $titre,
                'nom'  => $user['nom'],
                'prenom' => $user['prenoms']

            ]);

            if (empty($titre)) {
                // If the title is empty, redirect to the profile page
                return redirect()->to('/profiles/');
            } else {
                // If the title is not empty, redirect to the users list
                return redirect()->to('/admin/users');
            }
        }
    }

    private function validateLogin($matricule, $titre, $accessCode)
    {
        // Charger le modèle UsersModel
        $usersModel = new \App\Models\UsersModel();

        // Rechercher un utilisateur correspondant aux informations d'identification fournies
        $user = $usersModel->where('matricule', $matricule)
            ->where('titre', $titre)
            ->where('code_acces', $accessCode)
            ->first();

        if ($user) {
            return true; // Les informations d'identification sont valides
        } else {
            echo 'Vous avez entrez un titre ou nom ou matricule invalide, pour se connecter inscrivez s\'il vous plaît';
            //return redirect()->to('/login'); // Les informations d'identification sont invalides
        }
    }

    public function logout()
    {
        // Supprimer les variables de session
        session()->remove(['matricule', 'titre', 'isLoggedIn']);

        // Rediriger vers la page de connexion
        return redirect()->to('/login');
    }

    public function updateProfile($id)
    {
        $userModel = new \App\Models\UsersModel();
        $user = $userModel->find($id);

        if (!$user) {
            // Utilisateur non trouvé, gérer l'erreur
            return redirect()->to('/auth/profiles')->with('error', 'Utilisateur non trouvé');
        }

        // Récupérer les données du formulaire
        $nom = $this->request->getPost('nom');
        $prenom = $this->request->getPost('prenom');
        $email = $this->request->getPost('email');

        // Mettre à jour les données de l'utilisateur
        $updatedData = [
            'nom' => $nom,
            'prenom' => $prenom,
            'mail' => $email
        ];
        $userModel->update($id, $updatedData);

        // Rediriger vers la page des profils avec un message de succès
        return redirect()->to('/profiles')->with('success', 'Profil mis à jour avec succès');
    }

    public function showProfile()
    {
        // Récupérer les données de session pour le profil de l'utilisateur
        $prenom = session('prenom');
        $nom = session('nom');
        $titre = session('titre');
        $matricule = session('matricule');


        // Charger la vue 'profile'
        return view('Auth/profile', [
            'prenom' => $prenom,
            'nom' => $nom,
            'titre' => $titre,
            'matricule' => $matricule
        ]);
    }
}
