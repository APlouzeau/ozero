<?php

class FrontPageView
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

        $navbar = new NavbarView();
        $footer = new FooterView();

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
?>
        <!doctype html>
        <html lang="fr" class="font-supreme">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <meta name="description" content="<?= $this->description ?>">
            <?php foreach ($cssPaths as $cssPath): ?>
                <link href="/<?= $cssPath ?>" rel="stylesheet" />
            <?php endforeach; ?>
            <link rel="icon" href="/assets/favicon.ico" type="image/x-icon" />
            <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon-32x32.png">
            <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon-16x16.png">
            <title><?= $this->title ?></title>
        </head>
        
        <body class="font-supreme bg-white">
            <header>
                <?= $navbar->show(); ?>
            </header>
            
            <main class="main font-supreme bg-white">
                <div class="postContainer font-supreme bg-white">
                    <?= $this->content; ?>
                </div>
            </main>

            <?php foreach ($jsPaths as $jsPath): ?>
                <script src="/<?= $jsPath ?>"></script>
            <?php endforeach; ?>
            
            <footer>
                <?= $footer->show(); ?>
            </footer>
        </body>

        </html>
<?php
    }
}
