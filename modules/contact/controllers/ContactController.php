<?php

class ContactController
{
    /**
     * Envoie un email de contact
     * 
     * @return void
     */
    public function sendEmail()
    {
        // Vérifier si la requête est de type POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
            return;
        }

        // Récupérer les données JSON de la requête
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        // Vérifier si les données requises sont présentes
        if (!isset($data['name']) || !isset($data['email']) || !isset($data['message'])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Données manquantes']);
            return;
        }

        // Récupérer les données
        $name = htmlspecialchars($data['name']);
        $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
        $message = htmlspecialchars($data['message']);
        $to = isset($data['to']) ? filter_var($data['to'], FILTER_SANITIZE_EMAIL) : 'egaube0494@gmail.com';

        // Vérifier l'email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Email invalide']);
            return;
        }

        // Préparer l'email
        $subject = "Nouveau message de contact de $name";
        $headers = "From: $email" . "\r\n" .
                   "Reply-To: $email" . "\r\n" .
                   "X-Mailer: PHP/" . phpversion() . "\r\n" .
                   "Content-Type: text/html; charset=UTF-8";

        $emailContent = "
        <html>
        <head>
            <title>Nouveau message de contact</title>
        </head>
        <body>
            <h2>Nouveau message de contact</h2>
            <p><strong>Nom:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Message:</strong></p>
            <p>$message</p>
        </body>
        </html>
        ";

        // Envoyer l'email
        $mailSent = mail($to, $subject, $emailContent, $headers);

        // Répondre avec le statut
        if ($mailSent) {
            echo json_encode(['success' => true, 'message' => 'Email envoyé avec succès']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'envoi de l\'email']);
        }
    }
} 