<?php

class ArticleView
{

    private ?ArticleEntity $article;
    private ?array $associatedProducts;

    public function __construct(?ArticleEntity $article = null, ?array $associatedProducts = null)
    private ?array $associatedProducts;

    public function __construct(?ArticleEntity $article = null, ?array $associatedProducts = null)
    {
        $this->article = $article;
        $this->associatedProducts = $associatedProducts;
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
                <div class="max-w-4xl mx-auto p-6 bg-base-100 rounded-lg">
                <div class="max-w-4xl mx-auto p-6 bg-base-100 rounded-lg">
                    <figure class="w-full h-64 overflow-hidden rounded-lg">
                        <img src="<?= htmlspecialchars($this->article->getImg()) ?>" alt="<?= htmlspecialchars($this->article->getTitle()) ?>" class="w-full h-full object-cover">
                    </figure>
                    <!-- Contenu de l'article -->
                    <!-- Contenu de l'article -->
                    <div class="mt-6">
                        <!-- Titre -->
                        <!-- Titre -->
                        <h1 class="text-4xl font-bold"><?= htmlspecialchars($this->article->getTitle()) ?></h1>
                        <p class="text-gray-500 mt-2">
                            Par <span class="font-semibold"><?= htmlspecialchars($this->article->getAuthorName()) ?></span> - <?= $this->article->getArticleDate()->format('d M Y') ?>
                        </p>
                        <!-- Contenu (description) -->
                        <!-- Contenu (description) -->
                        <div class="mt-4 text-lg leading-relaxed">
                            <?= html_entity_decode($this->article->getContent()) ?>
                        </div>
                        <!-- Produits liés à l'article -->
                         <div class="mt-6">
                            <h2 class="text-2xl font-bold mt-6">Produits associés</h2>
                            <?php if(count($this->associatedProducts) !== 0): ?>
                                <div class="grid md:grid-cols-3 gap-3 mt-4">
                                    <?php 
                                    foreach ($this->associatedProducts as $productId){
                                        $productModel = new ProductModel();
                                        $productEntity = $productModel->getProductById($productId);
                                    ?>
                                        <div class="card bg-base-100 shadow-lg p-2 items-center">
                                            <!-- <figure> -->
                                            <img src="<?= htmlspecialchars($productEntity->getFirstImage()) ?>" 
                                            alt="<?= htmlspecialchars($productEntity->getProduct()) ?>" 
                                            class="rounded-lg h-40 w-40 object-cover">
                                            <!-- </figure> -->
                                            <div class="card-body text-center p-2">
                                                <h3 class="text-xl font-semibold"><?= htmlspecialchars($productEntity->getProduct()) ?></h3>
                                                <p class="text-gray-600"><?= substr($productEntity->getDescription(), 0, 50) . '...' ?></p>
                                                <a href="/produit/<?= $productEntity->getProductId() ?>" class="btn btn-primary m-4">Voir le produit</a>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php endif; ?>
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
        (new FrontPageView($contentPage, 'Articles de Blog', "Découvrez nos articles de blog pour un mode de vie plus écologique", ['blog']))->show();
    }

    public function showBlog($articleBlog)
    {
        ob_start();
    ?>

        <!-- Hero Section -->
        <div class="max-w-5xl mx-auto my-8 md:my-16 px-4 hero min-h-2xl">
            <div class="hero-content flex-col lg:flex-row">
                <img
                    src="https://plus.unsplash.com/premium_photo-1663952767504-12f8170f3835?q=80&w=3175&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                    class="max-w-sm rounded-lg shadow-2xl" />
                <div>
                    <h1 class="text-5xl font-bold">La démarche zéro déchets, qu'est ce que c'est ?</h1>
                    <p class="py-6">
                        Explorez ce blog pour découvrir des conseils, des astuces et des idées pour un mode de vie plus écologique.
                    </p>
                </div>
            </div>
        </div>


        <!-- Section : Article de Blog -->
        <div class="max-w-5xl mx-auto my-8 md:my-16 px-4">
            <div class="p-8 pt-0 bg-base-100 shadow-xl rounded-lg">
                <div class="">
                    <h1 class="text-2xl font-bold"><?= htmlspecialchars($articleBlog->getTitle()) ?></h1>
                    <img src="<?= htmlspecialchars($articleBlog->getImg()) ?>" alt="<?= htmlspecialchars($articleBlog->getTitle()) ?>" 
                    class="w-full h-64 mt-6 mb-6 object-cover rounded-lg">
                    <div id="blog-content"><?= htmlspecialchars_decode($articleBlog->getContent()) ?></div>

                </div>
            </div>
        </div>

    <?php
        $contentPage = ob_get_clean();
        (new FrontPageView($contentPage, 'Articles de Blog', "Découvrez nos articles de blog pour un mode de vie plus écologique", ['blog']))->show();
    }

    public function showDiy($articles)
    {

        //Catégories disponibles
        $categories = [
            'all' => 'Tous les Tutos',
            'jardin' => 'Jardin & Nature',
            'cosmetiques' => 'Cosmétiques Naturels',
            'entretien' => 'Maison & Entretien',
            'energie' => 'Énergie & Upcycling'
            'energie' => 'Énergie & Upcycling'
        ];

        ob_start();
?>
        <div class="bg-white min-h-screen">
            <!-- Section: Qu'est-ce que le DIY -->
            <div class="max-w-6xl mx-auto my-8 md:my-12 px-4">
                <h1 class="text-2xl md:text-3xl font-semibold text-primary mb-6 text-center font-supreme">Le DIY, qu'est ce que c'est ?</h1>
                
                <div class="bg-white p-6 rounded-lg shadow-lg shadow-black-950 mb-12">
                    <div class="max-w-3xl mx-auto">
                        <p class="text-sm md:text-base mb-4 font-supreme">
                            Ici, nous vous proposons des <span class="font-bold text-primary">kits DIY</span> (conçus pour vous aider à fabriquer vos propres solutions écologiques), réduire votre empreinte carbone et adopter un <span class="font-bold">mode de vie plus responsable</span>.
                        </p>
                        <p class="text-sm md:text-base mb-4 font-supreme">
                            Nos coffrets contiennent tout le matériel et les instructions nécessaires pour vous guider dans la <span class="font-bold">fabrication de vos produits du quotidien</span>, tout en privilégiant des matériaux <span class="font-bold">durables et respectueux</span> de l'environnement.
                        </p>
                    </div>
?>
        <div class="bg-white min-h-screen">
            <!-- Section: Qu'est-ce que le DIY -->
            <div class="max-w-6xl mx-auto my-8 md:my-12 px-4">
                <h1 class="text-2xl md:text-3xl font-semibold text-primary mb-6 text-center font-supreme">Le DIY, qu'est ce que c'est ?</h1>
                
                <div class="bg-white p-6 rounded-lg shadow-lg shadow-black-950 mb-12">
                    <div class="max-w-3xl mx-auto">
                        <p class="text-sm md:text-base mb-4 font-supreme">
                            Ici, nous vous proposons des <span class="font-bold text-primary">kits DIY</span> (conçus pour vous aider à fabriquer vos propres solutions écologiques), réduire votre empreinte carbone et adopter un <span class="font-bold">mode de vie plus responsable</span>.
                        </p>
                        <p class="text-sm md:text-base mb-4 font-supreme">
                            Nos coffrets contiennent tout le matériel et les instructions nécessaires pour vous guider dans la <span class="font-bold">fabrication de vos produits du quotidien</span>, tout en privilégiant des matériaux <span class="font-bold">durables et respectueux</span> de l'environnement.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Section: Catégories -->
            <div class="max-w-6xl mx-auto my-8 px-4">
                <div class="relative mb-2">
                    <h2 class="text-xl md:text-2xl font-semibold text-center mb-4 font-supreme">Catégories</h2>
                    <div class="text-center mb-8">
                        <a href="?category=all" class="inline-block bg-primary text-white px-4 py-2 rounded-lg font-supreme font-semibold hover:bg-primary/80 transition-colors">
                            Voir toutes les catégories
                        </a>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-12">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-12">
                    <?php foreach ($categories as $key => $category): ?>
                        <?php if ($key !== 'all'): ?>
                            <a href="?category=<?= $key ?>" class="bg-white p-4 rounded-lg shadow-box text-center hover:shadow-lg transition-shadow">
                                <div class="h-32 bg-gray-100 rounded-lg mb-2 flex items-center justify-center">
                                    <!-- Placeholder pour l'image de catégorie -->
                                </div>
                                <h3 class="font-semibold font-supreme"><?= $category ?></h3>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Section: Tutoriels -->
            <div class="max-w-6xl mx-auto my-8 px-4">
                <?php 
                $selectedCategory = isset($_GET['category']) ? $_GET['category'] : 'all';
                $viewMode = isset($_GET['view']) ? $_GET['view'] : 'grid';
                
                // Filtrer les tutoriels par catégorie
                $filteredTutorials = array_filter($articles, function($tutorial) use ($selectedCategory) {
                    return $selectedCategory === 'all' || $tutorial['category'] === $selectedCategory;
                });
                ?>
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl md:text-2xl font-semibold font-supreme">
                        <?= $selectedCategory === 'all' ? 'Tous les Tutos' : $categories[$selectedCategory] ?>
                    </h2>
                    <div class="flex items-center">
                        <span class="mr-2 font-supreme">Trier les Tutos :</span>
                        <div class="flex space-x-2">
                            <a href="?category=<?= $selectedCategory ?>&view=grid" class="<?= (!isset($_GET['view']) || $_GET['view'] === 'grid') ? 'bg-gray-200' : '' ?> p-2 rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="14" width="7" height="7"></rect>
                                    <rect x="3" y="14" width="7" height="7"></rect>
                                </svg>
                            </a>
                            <a href="?category=<?= $selectedCategory ?>&view=list" class="<?= (isset($_GET['view']) && $_GET['view'] === 'list') ? 'bg-gray-200' : '' ?> p-2 rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="8" y1="6" x2="21" y2="6"></line>
                                    <line x1="8" y1="12" x2="21" y2="12"></line>
                                    <line x1="8" y1="18" x2="21" y2="18"></line>
                                    <line x1="3" y1="6" x2="3.01" y2="6"></line>
                                    <line x1="3" y1="12" x2="3.01" y2="12"></line>
                                    <line x1="3" y1="18" x2="3.01" y2="18"></line>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                
                <?php if ($viewMode === 'grid'): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-12">
                    <?php foreach ($filteredTutorials as $tutorial): ?>
                        <div class="bg-white rounded-lg shadow-box overflow-hidden flex">
                            <div class="w-1/3 bg-gray-200">
                                <?php if (!empty($tutorial->getImg())): ?>
                                    <img src="<?= $tutorial->getImg() ?>" alt="<?= $tutorial->getTitle() ?>" class="w-full h-full object-cover">
                                <?php endif; ?>
                            </div>
                            <div class="w-2/3 p-4">
                                <h3 class="text-lg font-semibold mb-2 font-supreme"><?= $tutorial->getTitle() ?></h3>
                                <p class="text-sm text-gray-600 mb-4 font-supreme"><?= $tutorial->getContent() ?></p>
                            </div>
                            <a href="/articles/<?= $tutorial->getArticleId() ?>" class="btn btn-primary">Lire plus</a>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <div class="mb-12">
                    <?php foreach ($filteredTutorials as $tutorial): ?>
                        <div class="bg-white rounded-lg shadow-box overflow-hidden flex mb-4">
                            <div class="w-1/6 bg-gray-200">
                                <?php if (!empty($tutorial->getImg())): ?>
                                    <img src="<?= $tutorial->getImg() ?>" alt="<?= $tutorial->getTitle() ?>" class="w-full h-full object-cover">
                                <?php endif; ?>
                            </div>
                            <div class="w-4/6 p-4">
                                <h3 class="text-lg font-semibold mb-2 font-supreme"><?= $tutorial->getTitle() ?></h3>
                                <p class="text-sm text-gray-600 font-supreme"><?= $tutorial->getContent() ?></p>
                            </div>
                            <a href="/articles/<?= $tutorial->getArticleId() ?>" class="btn btn-primary">Lire plus</a>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
                    </div>
                </div>
                
                <?php if ($viewMode === 'grid'): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-12">
                    <?php foreach ($filteredTutorials as $tutorial): ?>
                        <div class="bg-white rounded-lg shadow-box overflow-hidden flex">
                            <div class="w-1/3 bg-gray-200">
                                <?php if (!empty($tutorial->getImg())): ?>
                                    <img src="<?= $tutorial->getImg() ?>" alt="<?= $tutorial->getTitle() ?>" class="w-full h-full object-cover">
                                <?php endif; ?>
                            </div>
                            <div class="w-2/3 p-4">
                                <h3 class="text-lg font-semibold mb-2 font-supreme"><?= $tutorial->getTitle() ?></h3>
                                <p class="text-sm text-gray-600 mb-4 font-supreme"><?= $tutorial->getContent() ?></p>
                            </div>
                            <a href="/articles/<?= $tutorial->getArticleId() ?>" class="btn btn-primary">Lire plus</a>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <div class="mb-12">
                    <?php foreach ($filteredTutorials as $tutorial): ?>
                        <div class="bg-white rounded-lg shadow-box overflow-hidden flex mb-4">
                            <div class="w-1/6 bg-gray-200">
                                <?php if (!empty($tutorial->getImg())): ?>
                                    <img src="<?= $tutorial->getImg() ?>" alt="<?= $tutorial->getTitle() ?>" class="w-full h-full object-cover">
                                <?php endif; ?>
                            </div>
                            <div class="w-4/6 p-4">
                                <h3 class="text-lg font-semibold mb-2 font-supreme"><?= $tutorial->getTitle() ?></h3>
                                <p class="text-sm text-gray-600 font-supreme"><?= $tutorial->getContent() ?></p>
                            </div>
                            <a href="/articles/<?= $tutorial->getArticleId() ?>" class="btn btn-primary">Lire plus</a>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
        <?php
        $contentPage = ob_get_clean();
        (new FrontPageView($contentPage, 'Articles de Blog', "Découvrez nos articles de blog pour un mode de vie plus écologique", []))->show();
    }






}

?>