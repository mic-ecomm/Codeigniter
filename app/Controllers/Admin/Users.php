<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Users extends BaseController
{
    public function index()
    {
        $usersModel = new \App\Models\UsersModel();

        // Récupérer la page actuelle à partir des paramètres de l'URL
        $activeUsers = $usersModel->where('deleted', 0)->orderBy('id')->findAll();

        return view('admin/users/list', [
            'users' => $activeUsers,
        ]);
    }

    public function inactiveUsers()
    {

        $usersModel = new \App\Models\UsersModel();
        $inactiveUsers = $usersModel->where('deleted', 1)->orderBy('id')->findAll();

        return view('admin/users/inactive_list', [
            'users' => $inactiveUsers,
        ]);
    }

    // Méthode pour réactiver un employé (utilisateur inactif)
    public function reactivateUser($userId)
    {
        $usersModel = new \App\Models\UsersModel();
        $user = $usersModel->find($userId);

        if (!$user) {
            // Utilisateur non trouvé, gérer l'erreur
            return redirect()->to('/admin/users/inactive')->with('error', 'Utilisateur non trouvé');
        }

        // Réactiver l'utilisateur en mettant 'deleted' à 0
        $updatedData = ['deleted' => 0];
        $usersModel->update($userId, $updatedData);

        // Rediriger vers la liste des utilisateurs inactifs avec un message de succès
        return redirect()->to('/admin/users/inactive')->with('success', 'Utilisateur réactivé avec succès');
    }


    public function add()
    {
        // Vérification des autorisations d'administration ici
        // Si l'utilisateur n'est pas administrateur, redirigez-le vers une autre page

        $userModel = new \App\Models\UsersModel();

        $validationRules = [
            'matricule' => 'required|integer',
            'nom' => 'required|string',
            'prenoms' => 'permit_empty|string',
            'titre' => 'permit_empty|string',
            'mail' => 'required|valid_email',
        ];

        $validation = \Config\Services::validation();
        $validation->setRules($validationRules);

        $data = []; // Initialize the $data variable

        if ($this->request->getMethod() === 'post') {
            $data = [
                'matricule' => $this->request->getPost('matricule'),
                'nom' => $this->request->getPost('nom'),
                'prenoms' => $this->request->getPost('prenoms'),
                'titre' => $this->request->getPost('titre'),
                'mail' => $this->request->getPost('email'), // Ajout du champ email
                'date_embauche' => $this->request->getPost('date_embauche'),
                'date_creation' => date('Y-m-d H:i:s'),
                'date_modification' => date('Y-m-d H:i:s'),
                'deleted' => 0
            ];

            // Check if user already exists
            $existingUser = $userModel->where('matricule', $data['matricule'])
                ->orWhere('mail', $data['mail'])
                ->first();

            if ($existingUser) {
                // User already exists, handle accordingly
                $validation->setError('matricule', 'Matricule existe déjà');
                $validation->setError('mail', 'Email déjà enregistré');
                $data['validation'] = $validation;
                return redirect()->to('admin/users')->with('error', 'Matricule et (ou) existe déjà');
            } else {
                // Save the user data to the database
                $data['code_acces'] = $this->generate_access_code(); // Generate an access code
                $userModel->insert($data);
                $emailSent = $this->send_registration_email($data['mail'], $data['code_acces']);

                if ($emailSent) {
                    return redirect()->to('admin/users')->with('success', 'Utilisateur ajouté avec succès !');
                } else {
                    // Error sending email
                    $validation->setError('mail', 'Error sending registration email.');
                    $data['validation'] = $validation;
                    return view('/users/email_err');
                }
            }
        }
        // Load the view with the form and validation errors (if any)
        return view('admin/users/add', $data);
    }

    private function generate_access_code()
    {
        $symbols = '!@#$%^&*()';
        $numbers = '0123456789';
        $lowercaseLetters = 'abcdefghijklmnopqrstuvwxyz';
        $uppercaseLetters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $accessCode = '';

        // Add a symbol
        $accessCode .= $symbols[rand(0, strlen($symbols) - 1)];

        // Add a number
        $accessCode .= $numbers[rand(0, strlen($numbers) - 1)];

        // Add a lowercase letter
        $accessCode .= $lowercaseLetters[rand(0, strlen($lowercaseLetters) - 1)];

        // Add an uppercase letter
        $accessCode .= $uppercaseLetters[rand(0, strlen($uppercaseLetters) - 1)];

        // Generate the remaining characters
        $remainingLength = 4; // The remaining length will be 4 since we have already added 4 characters
        $allCharacters = $symbols . $numbers . $lowercaseLetters . $uppercaseLetters;

        for ($i = 0; $i < $remainingLength; $i++) {
            $accessCode .= $allCharacters[rand(0, strlen($allCharacters) - 1)];
        }

        // Shuffle the access code to randomize the positions of the characters
        $accessCode = str_shuffle($accessCode);

        return $accessCode;
    }

    private function send_registration_email($recipientEmail, $accessCode)
    {
        // Load the Email library
        $email = \Config\Services::email();

        // Email configuration for Gmail SMTP
        $email->initialize([
            'protocol' => 'smtp',
            'SMTPHost' => 'smtp.gmail.com',
            'SMTPPort' => 587,
            'SMTPUser' => 'jmslfoo@gmail.com',
            'SMTPPass' => 'entrez ici le mot de passe dans la configuration de smtp',
            'SMTPCrypto' => 'tls',
            'mailType' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        ]);

        // Set the email parameters
        $email->setTo($recipientEmail);
        $email->setFrom('jmslfoo@gmail.com', 'Jean Michel');
        $email->setSubject('Votre inscription est confirmée avec succés');
        $email->setMessage('Merci pour l\'inscription! Voici votre code d\'accès : ' . $accessCode . '. Cliquez <a href="http://localhost:8080/login">ici</a> pour vous connecter.');


        // Send the email
        if ($email->send()) {
            // Email sent successfully
            return true;
        } else {
            // Error sending email
            return false;
        }
    }


    public function edit($id)
    {
        $userModel = new \App\Models\UsersModel();
        $user = $userModel->find($id);

        if ($this->request->getMethod() === 'post') {
            $data = [
                'nom' => $this->request->getPost('nom'),
                'prenoms' => $this->request->getPost('prenoms'),
                'titre' => $this->request->getPost('titre'),
                'date_modification' => date('Y-m-d H:i:s'),
                'date_embauche' => $this->request->getPost('date_embauche'),
            ];

            $userModel->update($id, $data);

            return redirect()->to('admin/users')->with('success', 'Utilisateur modifié avec succès !');
        }

        $data['user'] = $user;
        return view('admin/users/edit', $data);
    }

    public function delete($id)
    {
        $userModel = new \App\Models\UsersModel();
        $userModel->update($id, ['deleted' => 1]);

        return redirect()->to('admin/users')->with('success', 'Utilisateur supprimé avec succès !');
    }

    public function restore($id)
    {
        $userModel = new \App\Models\UsersModel();
        $userModel->update($id, ['deleted' => 0]);

        return redirect()->to('admin/users')->with('success', 'Utilisateur restauré avec succès !');
    }

    // app/Controllers/ProfileController.php

}
