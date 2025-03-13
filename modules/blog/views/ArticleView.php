<?php

class ArticleView
{

    private ?ArticleEntity $article;
    private ?array $associatedProducts;

    public function __construct(?ArticleEntity $article = null, array $associatedProducts = [])
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
        <div class="max-w-5xl mx-auto my-12 px-4 sm:px-6 lg:px-8">
            <main>
                <!-- En-tête de l'article avec image -->
                <div class="relative rounded-xl overflow-hidden shadow-2xl mb-10">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent z-10"></div>
                    <img src="<?= htmlspecialchars($this->article->getImg()) ?>" alt="<?= htmlspecialchars($this->article->getTitle()) ?>" class="w-full h-[400px] object-cover object-center">
                    <div class="absolute bottom-0 left-0 right-0 p-8 z-20">
                        <div class="inline-block px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full mb-4">Tutoriel DIY</div>
                        <h1 class="text-4xl md:text-5xl font-bold text-white leading-tight mb-2"><?= htmlspecialchars($this->article->getTitle()) ?></h1>
                        <div class="flex items-center text-white/90 text-sm">
                            <span class="mr-4">Par <span class="font-medium"><?= htmlspecialchars($this->article->getAuthorName()) ?></span></span>
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="white">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                </svg>
                                <?= $this->article->getArticleDate()->format('d M Y') ?>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Contenu principal -->
                <div class="flex flex-col md:flex-row gap-8">
                    <!-- Article -->
                    <div class="md:w-2/3">
                        <div class="bg-white rounded-xl shadow-md p-8">
                            <!-- Contenu (description) -->
                            <div class="prose prose-lg max-w-none">
                                <?= html_entity_decode($this->article->getContent()) ?>
                            </div>
                            
                            <!-- Actions article -->
                            <div class="mt-10 pt-6 border-t border-gray-200 flex flex-wrap gap-4">
                               
                                <a href="/diy" class="flex items-center gap-2 px-4 py-2 border border-gray-300 hover:bg-gray-50 text-gray-700 rounded-lg transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                                    </svg>
                                    Retour aux tutoriels
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Sidebar -->
                    <div class="md:w-1/3">
                        <!-- Produits liés à l'article -->
                        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-600" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M11 17a1 1 0 001.447.894l4-2A1 1 0 0017 15V9.236a1 1 0 00-1.447-.894l-4 2a1 1 0 00-.553.894V17zM15.211 6.276a1 1 0 000-1.788l-4.764-2.382a1 1 0 00-.894 0L4.789 4.488a1 1 0 000 1.788l4.764 2.382a1 1 0 00.894 0l4.764-2.382zM4.447 8.342A1 1 0 003 9.236V15a1 1 0 00.553.894l4 2A1 1 0 009 17v-5.764a1 1 0 00-.553-.894l-4-2z" />
                                </svg>
                                Produits associés
                            </h2>
                            <?php if(count($this->associatedProducts) !== 0): ?>
                                <div class="space-y-4">
                                    <?php 
                                    foreach ($this->associatedProducts as $productId){
                                        $productModel = new ProductModel();
                                        $productEntity = $productModel->getProductById($productId);
                                    ?>
                                        <div class="group flex items-center gap-4 p-3 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer" 
                                             onclick="window.location.href='/produit/<?= $productEntity->getProductId() ?>'">
                                            <img src="<?= htmlspecialchars($productEntity->getFirstImage()) ?>" 
                                                alt="<?= htmlspecialchars($productEntity->getProduct()) ?>" 
                                                class="w-16 h-16 object-cover rounded-md shadow-sm">
                                            <div class="flex-1 min-w-0">
                                                <h3 class="text-sm font-medium text-gray-900 truncate group-hover:text-green-600 transition-colors">
                                                    <?= htmlspecialchars($productEntity->getProduct()) ?>
                                                </h3>
                                                <p class="mt-1 text-xs text-gray-500 truncate">
                                                    <?= number_format($productEntity->getPrice(), 2, ',', ' ') ?> €
                                                </p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <div class="w-8 h-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center group-hover:bg-green-600 group-hover:text-white transition-colors">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php else: ?>
                                <p class="text-gray-500 text-sm">Aucun produit associé à cet article.</p>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Tutoriels similaires (suggestion) -->
                        <div class="bg-white rounded-xl shadow-md p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-600" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z" />
                                </svg>
                                À découvrir aussi
                            </h2>
                            <div class="space-y-4">
                                <p class="text-gray-500 text-sm">D'autres tutoriels qui pourraient vous intéresser.</p>
                                <a href="/diy" class="inline-block w-full text-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg transition-colors">
                                    Voir tous les tutoriels
                                </a>
                            </div>
                        </div>
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

        $categories = [
            'all' => 'Tous les Tutos',
            'jardin' => 'Jardin & Nature',
            'cosmetiques' => 'Cosmétiques Naturels',
            'entretien' => 'Maison & Entretien',
            'energie' => 'Énergie & Upcycling',
            'alimentation' => 'Alimentation & Cuisine',
            'mode' => 'Mode & Accessoires'
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
                
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-12">
                    <?php foreach ($categories as $key => $category): ?>
                        <?php if ($key !== 'all'): ?>
                            <a href="?category=<?= $key ?>" class="bg-white p-4 rounded-lg shadow-box text-center hover:shadow-lg transition-shadow">
                                <div class="h-32 bg-gray-100 rounded-lg mb-2 flex items-center justify-center">
                                    <?php 
                                    // Utiliser les images correspondantes aux catégories
                                    $imageName = $key;
                                    // Correction pour "cosmetiques" car le fichier s'appelle "cosmetique.png"
                                    if ($key === 'cosmetiques') {
                                        $imageName = 'cosmetique';
                                    }
                                    ?>
                                    <img src="/assets/png/<?= $imageName ?>.png" alt="<?= $category ?>" class="h-full object-contain p-2">
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
                            <button type="button" class="bg-gray-200 p-2 rounded" id="gridView">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="14" width="7" height="7"></rect>
                                    <rect x="3" y="14" width="7" height="7"></rect>
                                </svg>
                            </button>
                            <button type="button" class="p-2 rounded" id="listView">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="8" y1="6" x2="21" y2="6"></line>
                                    <line x1="8" y1="12" x2="21" y2="12"></line>
                                    <line x1="8" y1="18" x2="21" y2="18"></line>
                                    <line x1="3" y1="6" x2="3.01" y2="6"></line>
                                    <line x1="3" y1="12" x2="3.01" y2="12"></line>
                                    <line x1="3" y1="18" x2="3.01" y2="18"></line>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12" id="conteneur-grid">
                    <?php foreach ($filteredTutorials as $tutorial): ?>
                        <div class="bg-white rounded-lg shadow-xl overflow-hidden flex transform transition-transform hover:scale-105 hover:cursor-pointer"
                        onclick="window.location.href='/articles/<?= $tutorial->getArticleId() ?>'">
                            <div class="w-1/3 bg-gray-200">
                                <?php if (!empty($tutorial->getImg())): ?>
                                    <img src="<?= $tutorial->getImg() ?>" alt="<?= $tutorial->getTitle() ?>" 
                                    class="w-48 h-48 object-cover">
                                <?php endif; ?>
                            </div>
                            <div class="w-2/3 p-4">
                                <h3 class="text-xl font-semibold mb-2 font-supreme"><?= $tutorial->getTitle() ?></h3>
                                <p class="text-sm text-gray-600 mb-4 font-supreme"><?= substr($tutorial->getContent(), 0, 100) . '...' ?></p> <!-- substr pour limiter le nb de caracteres -->
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="mb-12" id="conteneur-list" style="display: none;">
                    <?php foreach ($filteredTutorials as $tutorial): ?>
                        <div class="bg-white rounded-lg shadow-xl overflow-hidden flex mb-6 transform transition-transform hover:scale-105 hover:cursor-pointer"
                        onclick="window.location.href='/articles/<?= $tutorial->getArticleId() ?>'">
                            <div class="w-1/6 bg-gray-200">
                                <?php if (!empty($tutorial->getImg())): ?>
                                    <img src="<?= $tutorial->getImg() ?>" alt="<?= $tutorial->getTitle() ?>" 
                                    class="w-48 h-48 object-cover">
                                <?php endif; ?>
                            </div>
                            <div class="w-4/6 p-4">
                                <h3 class="text-xl font-semibold mb-2 font-supreme"><?= $tutorial->getTitle() ?></h3>
                                <p class="text-sm text-gray-600 mb-4 font-supreme"><?= substr($tutorial->getContent(), 0, 200) . '...' ?></p> <!-- substr pour limiter le nb de caracteres -->
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php
        $contentPage = ob_get_clean();
        (new FrontPageView($contentPage, 'Articles de Blog', "Découvrez nos articles de blog pour un mode de vie plus écologique", ['diy']))->show();
    }
}

?>
