<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Check if the user is authenticated
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        // Check if the titre session variable is not empty
        if (!empty(session()->get('titre'))) {
            // Access to the user list is allowed
            return;
        }

        // If the titre session variable is empty, redirect to the profile page or handle it as per your requirement
        return redirect()->to('/profiles');
    }



    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Ne rien faire après la requête
    }
}
