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

        <div class="max-w-4xl mx-auto p-6 bg-base-100 shadow-lg rounded-lg flex gap-6">
            <!-- Bloc images -->
            <div class="flex gap-4">
                <div class="flex flex-col gap-2 h-72"> <!-- Assure que la hauteur de la colonne est égale à la grande image -->
                    <div class="w-24 h-24 bg-gray-300"></div>
                    <div class="w-24 h-24 bg-gray-300"></div>
                    <div class="w-24 h-24 bg-gray-300"></div>
                </div>
                <div class="w-72 h-72 bg-gray-300">
                    <img src="<?= htmlspecialchars($this->article->getImg()) ?>" alt="<?= htmlspecialchars($this->article->getTitle()) ?>" class="w-full h-full object-cover">
                </div> <!-- Image principale carrée -->
            </div>

            <!-- Contenu article -->
            <div class="flex-1 flex flex-col justify-between">
                <div>
                    <h2 class="text-2xl font-bold"><?= htmlspecialchars($this->article->getTitle()) ?></h2>
                    <p class="text-gray-600 mt-2"><?= substr($this->article->getContent(), 0, 50) . '...' ?></p>
                </div>

                <!-- Section avec quantité, prix et bouton alignés à droite -->
                <div class="flex justify-end items-center gap-4 mt-4">
                    <!-- Sélection quantité -->
                    <select id="quantity" class="select select-bordered w-20">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                    
                    <!-- Prix -->
                    <span id="price" class="text-green-600 text-xl font-bold">10€</span>
                    
                    <!-- Bouton lien -->
                    <button class="btn btn-primary text-white w-32">Lien vers l'article</button>
                </div>
            </div>
        </div>


        <!-- Section Articles associés -->
        <div class="mt-8">
            <h3 class="text-xl font-semibold">Produits associés :</h3>
            <div class="flex flex-wrap gap-4 mt-4">
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                    <!-- Produit -->
                    <?php if(count($this->associatedProducts) !== 0): ?>
                        <?php 
                        foreach ($this->associatedProducts as $productId){
                        $productModel = new ProductModel();
                        $productEntity = $productModel->getProductById($productId);
                        $firstImage = $productEntity->getFirstImage();
                        $imageSrc = $firstImage !== null ? htmlspecialchars($firstImage, ENT_QUOTES, 'UTF-8') : '';?>
                            <div class="overflow-hidden border h-40 border-gray-200 rounded-lg shadow-lg shadow-black-950 relative group">
                                <a href="/produit/<?= $productEntity->getProductId() ?>">
                                    <img src="<?= $imageSrc ?>" alt="<?= $productEntity->getProduct() ?>" class="object-cover w-full h-full">
                                    <!-- Overlay avec les détails du produit -->
                                    <div class="absolute inset-0 bg-black bg-opacity-60 flex flex-col justify-end p-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <h3 class="font-semibold text-sm md:text-base font-supreme truncate text-white"><?= $productEntity->getProduct() ?></h3>
                                        <p class="text-xs md:text-sm font-supreme line-clamp-2 my-1 text-white"><?= $productEntity->getDescription() ?></p>
                                        <p class="font-bold text-sm md:text-base font-supreme text-white"><?= $productEntity->getPrice() ?> €</p>
                                    </div>
                                </a>
                            </div>
                        <?php } ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>


        <!-- Section Tuto -->
        <div class="mt-8">
            <!-- <h3 class="text-xl font-semibold">Tuto : Comment utiliser cet article ?</h3> -->
            <?= htmlspecialchars_decode($this->article->getContent()) ?>
        </div>

<script>
    document.getElementById('quantity').addEventListener('change', function() {
        let basePrice = 10;
        let quantity = this.value;
        document.getElementById('price').textContent = (basePrice * quantity) + '€';
    });
</script>

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
