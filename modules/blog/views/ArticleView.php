<?php

class ArticleView
{

    private ?ArticleEntity $article;
    public function __construct(?ArticleEntity $article = null)
    {
        if ($article) {
            $this->article = $article;
        }
    }

    public function show()
    {
        if (!$this->article) {
            return "<p class='text-center text-error text-xl'>Article non trouvé.</p>";
        }
        ob_start();
?>

        <div class="max-w-4xl mx-auto p-6 bg-base-100 shadow-lg rounded-lg">
            <main class="container mx-auto p-6">
                <div class="max-w-4xl mx-auto p-6 bg-base-100 shadow-lg rounded-lg">
                    <figure class="w-full h-64 overflow-hidden rounded-lg">
                        <img src="<?= htmlspecialchars($this->article->getImg()) ?>" alt="<?= htmlspecialchars($this->article->getTitle()) ?>" class="w-full h-full object-cover">
                    </figure>
                    <div class="mt-6">
                        <h1 class="text-4xl font-bold"><?= htmlspecialchars($this->article->getTitle()) ?></h1>
                        <p class="text-gray-500 mt-2">
                            Par <span class="font-semibold"><?= htmlspecialchars($this->article->getAuthorName()) ?></span> - <?= $this->article->getArticleDate()->format('d M Y') ?>
                        </p>
                        <div class="mt-4 text-lg leading-relaxed">
                            <?= nl2br($this->article->getContent()) ?>
                        </div>
                    </div>
                    <div class="mt-6 flex flex-col md:flex-row justify-between items-center gap-4">
                        <button class="btn btn-primary">Partager</button>
                        <a href="/diy" class="btn btn-outline">Retour</a>
                    </div>
                </div>
            </main>
        </div>
    <?php
        $contentPage = ob_get_clean();
        (new FrontPageView($contentPage, 'Articles de Blog', "Découvrez nos articles de blog pour un mode de vie plus écologique", ['blog', 'écologie']))->show();
    }

    public function showBlog()
    {
        ob_start();
    ?>

        <!-- Hero Section -->
        <div class="max-w-5xl mx-auto my-8 md:my-16 px-4 hero min-h-2xl">
            <div class="hero-content flex-col lg:flex-row">
                <img
                    src="https://source.unsplash.com/600x400/?blog,writing"
                    class="max-w-sm rounded-lg shadow-2xl" />
                <div>
                    <h1 class="text-5xl font-bold">Articles de Blog</h1>
                    <p class="py-6">
                        Explorez nos articles de blog pour découvrir des conseils, des astuces et des idées pour un mode de vie plus écologique.
                    </p>
                </div>
            </div>
        </div>

        <!-- Section : Articles de Blog -->
        <div class="max-w-5xl mx-auto my-8 md:my-16 px-4">
            <h2 class="text-4xl font-bold text-center mb-8">Derniers Articles</h2>
            <div class="grid md:grid-cols-3 gap-6">
                <!-- Article 1 -->
                <div class="card bg-base-100 shadow-lg p-4">
                    <figure>
                        <img src="https://source.unsplash.com/300x200/?blog,eco" alt="Éco-conseils" class="rounded-lg">
                    </figure>
                    <div class="card-body text-center">
                        <h3 class="text-xl font-semibold">10 Conseils pour un Mode de Vie Écologique</h3>
                        <p class="text-gray-600">Découvrez des astuces simples pour réduire votre empreinte écologique au quotidien.</p>
                        <button class="btn btn-primary">Lire plus</button>
                    </div>
                </div>
                <!-- Article 2 -->
                <div class="card bg-base-100 shadow-lg p-4">
                    <figure>
                        <img src="https://source.unsplash.com/300x200/?blog,energy" alt="Énergie renouvelable" class="rounded-lg">
                    </figure>
                    <div class="card-body text-center">
                        <h3 class="text-xl font-semibold">Les Avantages des Énergies Renouvelables</h3>
                        <p class="text-gray-600">Apprenez comment les énergies renouvelables peuvent transformer notre avenir.</p>
                        <button class="btn btn-primary">Lire plus</button>
                    </div>
                </div>
                <!-- Article 3 -->
                <div class="card bg-base-100 shadow-lg p-4">
                    <figure>
                        <img src="https://source.unsplash.com/300x200/?blog,garden" alt="Jardinage écologique" class="rounded-lg">
                    </figure>
                    <div class="card-body text-center">
                        <h3 class="text-xl font-semibold">Jardinage Écologique : Par où Commencer ?</h3>
                        <p class="text-gray-600">Des conseils pour créer un jardin respectueux de l'environnement.</p>
                        <button class="btn btn-primary">Lire plus</button>
                    </div>
                </div>
                <!-- Article 4 -->
                <div class="card bg-base-100 shadow-lg p-4">
                    <figure>
                        <img src="https://source.unsplash.com/300x200/?blog,recycle" alt="Recyclage" class="rounded-lg">
                    </figure>
                    <div class="card-body text-center">
                        <h3 class="text-xl font-semibold">Le Guide Ultime du Recyclage</h3>
                        <p class="text-gray-600">Tout ce que vous devez savoir pour recycler efficacement.</p>
                        <button class="btn btn-primary">Lire plus</button>
                    </div>
                </div>
                <!-- Article 5 -->
                <div class="card bg-base-100 shadow-lg p-4">
                    <figure>
                        <img src="https://source.unsplash.com/300x200/?blog,vegan" alt="Veganisme" class="rounded-lg">
                    </figure>
                    <div class="card-body text-center">
                        <h3 class="text-xl font-semibold">Pourquoi Adopter un Régime Végétalien ?</h3>
                        <p class="text-gray-600">Les bienfaits du végétalisme pour la santé et la planète.</p>
                        <button class="btn btn-primary">Lire plus</button>
                    </div>
                </div>
                <!-- Article 6 -->
                <div class="card bg-base-100 shadow-lg p-4">
                    <figure>
                        <img src="https://source.unsplash.com/300x200/?blog,transport" alt="Transport écologique" class="rounded-lg">
                    </figure>
                    <div class="card-body text-center">
                        <h3 class="text-xl font-semibold">Les Transports Écologiques : Une Nécessité</h3>
                        <p class="text-gray-600">Comment réduire votre impact environnemental grâce à des choix de transport plus verts.</p>
                        <button class="btn btn-primary">Lire plus</button>
                    </div>
                </div>
            </div>
        </div>

    <?php
        $contentPage = ob_get_clean();
        (new FrontPageView($contentPage, 'Articles de Blog', "Découvrez nos articles de blog pour un mode de vie plus écologique", ['blog', 'écologie']))->show();
    }

    public function showDiy($articles)
    {
        ob_start();
    ?>

        <!-- Hero Section -->
        <div class="max-w-5xl mx-auto my-8 md:my-16 px-4 hero min-h-lg">
            <div class="hero-content flex-col lg:flex-row">
                <img
                    src="https://source.unsplash.com/600x400/?eco,nature"
                    class="max-w-sm rounded-lg shadow-2xl" />
                <div>
                    <h1 class="text-5xl font-bold">DIY Écologiques</h1>
                    <p class="py-6">
                        Découvrez nos guides pour fabriquer vous-même des objets écologiques et réduire votre impact environnemental !
                    </p>
                    <button class="btn btn-primary">Explorer</button>
                </div>
            </div>
        </div>

        <!-- Section : Articles DIY -->
        <div class="max-w-5xl mx-auto my-8 md:my-16 px-4">
            <h2 class="text-4xl font-bold text-center mb-8">Articles DIY</h2>
            <div class="grid md:grid-cols-3 gap-6">
                <!-- Article 1 -->
                <?php foreach ($articles as $article) : ?>
                    <div class="card bg-base-100 shadow-lg p-4">
                        <figure>
                            <img src="<?= htmlspecialchars($article->getImg()) ?>" alt="<?= htmlspecialchars($article->getTitle()) ?>" class="rounded-lg
                        ">
                        </figure>
                        <div class="card-body text-center">
                            <h3 class="text-xl font-semibold"><?= htmlspecialchars($article->getTitle()) ?></h3>
                            <p class="text-gray-600"><?= $article->getContent() ?></p>
                            <a href="/articles/<?= $article->getArticleId() ?>" class="btn btn-primary">Lire plus</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

<?php
        $contentPage = ob_get_clean();
        (new FrontPageView($contentPage, 'Articles de Blog', "Découvrez nos articles de blog pour un mode de vie plus écologique", []))->show();
    }
}

?>