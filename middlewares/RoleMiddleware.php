<?php

require_once __DIR__ . '/AuthMiddleware.php';

class RoleMiddleware
{
    private $roleMapping = [
        'utilisateur' => 1,
        'modérateur' => 2,
        'gestionnaire' => 3,
        'admin' => 4,
        'administrateur' => 5
    ];

    public function handle()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Vérifier d'abord si l'utilisateur est authentifié
        $authMiddleware = new AuthMiddleware();
        if (!$authMiddleware->handle()) {
            $this->unauthorizedResponse("Utilisateur non authentifié");
        }

        // Récupérer le rôle de l'utilisateur depuis le JWT
        $jwt = new JWT();
        $userId = $jwt->getUserIdFromJWT();
        
        if (!$userId) {
            $this->unauthorizedResponse("Utilisateur non authentifié");
        }

        // Récupérer le rôle de l'utilisateur
        $userModel = new UserModel();
        $user = $userModel->getUserById($userId);
        
        if (!$user) {
            $this->unauthorizedResponse("Utilisateur non trouvé");
        }

        $userRole = $user->getRoleId();
        
        // Vérifier si l'utilisateur est admin (roleId 4 ou 5)
        if ($userRole < 4) {
            $this->unauthorizedResponse("Accès non autorisé : rôle insuffisant");
        }

        return true;
    }

    private function unauthorizedResponse($message)
    {
        http_response_code(403);
        ob_start();
        ?>
        <!DOCTYPE html>
        <html lang="fr" class="h-full">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Accès Refusé</title>
            <script src="https://cdn.tailwindcss.com"></script>
            <link href="https://fonts.googleapis.com/css2?family=Supreme:wght@400;600;700&display=swap" rel="stylesheet">
        </head>
        <body class="h-full bg-gray-50">
            <main class="min-h-full grid place-items-center px-6 py-24 sm:py-32 lg:px-8">
                <div class="text-center">
                    <div class="flex justify-center mb-8">
                        <div class="rounded-full bg-red-100 p-4">
                            <svg class="h-12 w-12 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                            </svg>
                        </div>
                    </div>
                    <h1 class="font-supreme text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Accès Refusé</h1>
                    <p class="mt-4 text-base leading-7 text-gray-600 font-supreme"><?= htmlspecialchars($message) ?></p>
                    <div class="mt-10 flex items-center justify-center gap-x-6">
                        <a href="/" class="rounded-md bg-primary px-3.5 py-2.5 text-sm font-semibold text-black shadow-sm hover:bg-primary/80 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary font-supreme">
                            Retour à l'accueil
                        </a>
                        <a href="/login" class="text-sm font-semibold text-gray-900 font-supreme">
                            Se connecter <span aria-hidden="true">&rarr;</span>
                        </a>
                    </div>
                </div>
            </main>
        </body>
        </html>
        <?php
        echo ob_get_clean();
        exit;
    }
} 