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
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <meta name="description" content="<?= $this->description ?>">
            <meta name="csrf-token" content="<?= SessionController::getCSRFToken() ?>">
            <?php foreach ($cssPaths as $cssPath): ?>
                <link href="/<?= $cssPath ?>" rel="stylesheet" />
            <?php endforeach; ?>
            <link rel="shortcut icon" href="/assets/yfavicon.ico" type="image/x-icon" />
            <title><?= $this->title ?></title>
        </head>

        <body class="flex flex-col md:flex-row h-screen">
            <!-- Bouton Burger -->
            <button id="sidebarToggle" class="md:hidden fixed top-4 right-4 z-50 p-2 bg-gray-800 text-white rounded">
                ☰
            </button>


            <div class="w-full md:w-64"></div>
            <aside id="sidebar" class="w-full md:w-64 bg-gray-800 text-white p-5 flex flex-col justify-between md:h-full transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">
                <div>
                    <h2 class="text-2xl font-bold mb-6">Back-Office</h2>
                    <nav class="space-y-2">
                        <a href="/admin/users" class="block p-3 rounded bg-gray-700 hover:bg-gray-600">👤 Utilisateurs</a>
                        <a href="/admin/products" class="block p-3 rounded bg-gray-700 hover:bg-gray-600">📦 Produits</a>
                        <a href="/admin/articles" class="block p-3 rounded bg-gray-700 hover:bg-gray-600">Tutos DIY</a>
                        <a href="/admin/categories" class="block p-3 rounded bg-gray-700 hover:bg-gray-600">📂 Catégories</a>
                        <a href="/admin/commandes" class="block p-3 rounded bg-gray-700 hover:bg-gray-600">🛒 Commandes</a>
                        <a href="/admin/payments" class="block p-3 rounded bg-gray-700 hover:bg-gray-600">💳 Paiements</a>
                    </nav>
                </div>
                <a href="/" class="block p-3 rounded bg-gray-700 hover:bg-gray-600"> Ozero</a>
            </aside>
            <main class="flex-1 p-5 overflow-auto">
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
