<?php

class BackOfficePageView
{
    public function __construct(private $content, private $title, private $description, private $jsFilesNames = null, private $cssFilesNames = null) {}

    /**
     * @return void
     */
    public function show()
    {
        $config = new PageConfig($this->jsFilesNames, $this->cssFilesNames);
        $cssPaths = $config->getCssPaths();
        $jsPaths = $config->getJsPaths();

?>
        <!doctype html>
        <html lang="fr" class="font-supreme">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <meta name="description" content="<?= $this->description ?>">
            <meta name="csrf-token" content="<?= SessionController::getCSRFToken() ?>">
            <?php foreach ($cssPaths as $cssPath): ?>
                <link href="/<?= $cssPath ?>" rel="stylesheet" />
            <?php endforeach; ?>
            <link rel="icon" href="/assets/favicon.ico" type="image/x-icon" />
            <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon-32x32.png">
            <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon-16x16.png">
            <title><?= $this->title ?></title>
        </head>

        <body class="font-supreme bg-white flex flex-col md:flex-row h-screen">
            <!-- Bouton Burger -->
            <button id="sidebarToggle" class="md:hidden fixed top-4 right-4 z-50 p-2 bg-primary text-white rounded">
                ☰
            </button>


            <div class="w-full md:w-64"></div>
            <aside id="sidebar" class="w-full md:w-64 bg-gray-100 text-gray-800 p-5 flex flex-col justify-between md:h-full transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out border-r border-gray-200">
                <div>
                    <h2 class="text-2xl font-bold font-chillax mb-6 text-primary">Dashboard</h2>
                    <nav class="space-y-2">
                        <a href="/admin/users" class="block p-3 rounded bg-primary text-white hover:bg-primary/80 font-bold">Utilisateurs</a>
                        <a href="/admin/products" class="block p-3 rounded bg-primary text-white hover:bg-primary/80 font-bold">Produits</a>
                        <a href="/admin/articles" class="block p-3 rounded bg-primary text-white hover:bg-primary/80 font-bold">Articles DIY/Blog</a>
                        <a href="/admin/categories" class="block p-3 rounded bg-primary text-white hover:bg-primary/80 font-bold">Catégories</a>
                        <a href="/admin/commandes" class="block p-3 rounded bg-primary text-white hover:bg-primary/80 font-bold">Commandes</a>
                        <a href="/admin/payments" class="block p-3 rounded bg-primary text-white hover:bg-primary/80 font-bold">Paiements</a>
                    </nav>
                </div>
                <a href="/" class="block p-3 rounded bg-primary text-white hover:bg-primary/80 font-bold mt-4">Retour à Ozero</a>
            </aside>
            <main class="flex-1 p-5 overflow-auto font-supreme bg-white">
                <div id="flashMessageContainer"></div>
                <?= $this->content; ?>
            </main>

            <?php foreach ($jsPaths as $jsPath): ?>
                <script src="/<?= $jsPath ?>"></script>
            <?php endforeach; ?>
        </body>

        </html>
<?php
    }
}
