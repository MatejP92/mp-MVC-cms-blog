<?php

namespace app\controller;
use app\core\Controller;
use app\core\Request;
use app\core\Response;


class ResetPasswordController extends Controller {
    
    
 
    public function resetPassword(Request $request, Response $response, $args) {
        // Get the token from the query string
        $token = $request->getQueryParameter("token");


        // Validate the token
        if (validateToken($token)) {
            // If the token is valid, get the email address associated with the token
            $email = getEmailFromToken($token);
        }

         // Check if the form has been submitted
        if ($request->isPost()) {

        }

    }
}