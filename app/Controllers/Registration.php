<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Email\Email;

class Registration extends BaseController
{
    public function index()
    {
        // Load the view
        return view('Registration/registration_form');
    }

    public function process_registration()
    {
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

        if (!$validation->withRequest($this->request)->run()) {
            // Form validation failed, reload the registration form with errors
            $data['validation'] = $validation;
            return view('Registration/registration_form', $data);
        } else {
            // Form validation succeeded, process the registration
            $data = [
                'matricule' => $this->request->getPost('matricule'),
                'nom' => $this->request->getPost('nom'),
                'prenoms' => $this->request->getPost('prenoms'),
                'titre' => $this->request->getPost('titre'),
                'mail' => $this->request->getPost('mail')
            ];

            // Check if user already exists
            $usersModel = new \App\Models\UsersModel();
            $existingUser = $usersModel->where('matricule', $data['matricule'])
                ->orWhere('mail', $data['mail'])
                ->first();

            if ($existingUser) {
                // User already exists, handle accordingly
                $validation->setError('matricule', 'Matricule existe déjà');
                $validation->setError('mail', 'Email déjà enregistré');
                $data['validation'] = $validation;
                return view('Registration/registration_form', $data);
            }

            // Save the user data to the database
            $data['code_acces'] = $this->generate_access_code(); // Generate an access code
            $usersModel->insert($data);

            // Send email notification with the access code
            $emailSent = $this->send_registration_email($data['mail'], $data['code_acces']);

            if ($emailSent) {
                // Email sent successfully
                // Redirect to a success page or any other desired action
                return redirect()->to('registration/success');
            } else {
                // Error sending email
                $validation->setError('mail', 'Error sending registration email.');
                $data['validation'] = $validation;
                return view('Registration/registration_form', $data);
            }
        }
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
            'SMTPPass' => 'entrez ici votre mot de passe dans la configuration de smtp',
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

    public function success()
    {
        return view('Registration/registration_success');
    }
}
