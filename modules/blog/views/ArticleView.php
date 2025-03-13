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
                    <?php if (count($this->associatedProducts) !== 0): ?>
                        <?php
                        foreach ($this->associatedProducts as $productId) {
                            $productModel = new ProductModel();
                            $productEntity = $productModel->getProductById($productId); ?>
                            <div class="overflow-hidden border h-40 border-gray-200 rounded-lg shadow-lg shadow-black-950 relative group">
                                <a href="/produit/<?= $productEntity->getProductId() ?>">
                                    <img src="<?= $productEntity->getFirstImage() ?>" alt="<?= $productEntity->getProduct() ?>" class="object-cover w-full h-full">
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

    public function showDiy($articles, $categories)
    {

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

                <div class="mb-6">
                    <h3 class="text-sm font-medium text-gray-900 mb-2">Catégories</h3>
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <input id="category-all" name="category" type="radio" value="all" class="h-4 w-4 text-green-600 focus:ring-green-500" checked>
                            <label for="category-all" class="ml-2 text-sm text-gray-700">Toutes les catégories</label>
                        </div>
                        <?php foreach ($categories as $category) { ?>
                            <div class="flex items-center">
                                <input id="category-<?= $category->getCategoryId() ?>" name="category" type="radio" value="<?= $category->getCategoryId() ?>" class="h-4 w-4 text-green-600 focus:ring-green-500 category-filter">
                                <label for="category-<?= $category->getCategoryId() ?>" class="ml-2 text-sm text-gray-700"><?= $category->getName() ?></label>
                            </div>
                        <?php } ?>
                    </div>
                    <button id="apply-filters" class="w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors">
                        Appliquer les filtres
                    </button>
                </div>

                <!-- Section: Tutoriels -->
                <div class="lg:w-3/4">
                    <!-- Contrôles de tri et d'affichage -->
                    <div class="bg-white rounded-lg shadow-md p-4 mb-6 flex flex-col sm:flex-row justify-between items-center">
                        <div class="flex items-center mb-4 sm:mb-0">
                            <span class="text-gray-700 mr-2">Trier par:</span>
                            <select id="sort-options" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 p-2">
                                <option value="default">Pertinence</option>
                                <option value="price-asc">Prix croissant</option>
                                <option value="price-desc">Prix décroissant</option>
                                <option value="name-asc">Nom (A-Z)</option>
                                <option value="name-desc">Nom (Z-A)</option>
                            </select>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button id="grid-view" class="p-2 rounded-md bg-green-100 text-green-600 hover:bg-green-200 focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                </svg>
                            </button>
                            <button id="list-view" class="p-2 rounded-md text-gray-500 hover:bg-gray-100 focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="listButton h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Grille de produits -->
                    <!-- Grille de produits -->
                    <div id="products-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach ($articles as $articleData):
                            $article = $articleData[0]; // Get the article entity
                            $categories = $articleData[1];
                        ?>
                            <div class="product-card bg-white rounded-lg shadow-md overflow-hidden transition-transform hover:shadow-lg hover:-translate-y-1"
                                data-category="<?= !empty($categories) ? $categories[0] : '' ?>"
                                data-name="<?= strtolower($article->getTitle()) ?>">
                                <div class="relative h-48 bg-gray-200">
                                    <?php if (!empty($article->getImg())): ?>
                                        <img src="<?= htmlspecialchars($article->getImg()) ?>" alt="<?= htmlspecialchars($article->getTitle()) ?>" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <div class="flex items-center justify-center h-full bg-gray-200">
                                            <svg class="h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($categories)):
                                        foreach ($categories as $category): ?>
                                            <span class="absolute top-2 right-2 bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                                <?= htmlspecialchars($category['name']) ?>
                                            </span>
                                    <?php break; // Show only the first category
                                        endforeach;
                                    endif; ?>
                                </div>
                                <div class="p-4">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2"><?= htmlspecialchars($article->getTitle()) ?></h3>
                                    <p class="text-sm text-gray-600 mb-4 line-clamp-2"><?= htmlspecialchars(substr($article->getContent(), 0, 100)) ?>...</p>
                                    <div class="flex justify-between items-center">
                                        <div class="flex space-x-2">
                                            <a href="/articles/<?= $article->getArticleId() ?>" class="inline-flex items-center px-3 py-1.5 border border-green-600 text-xs font-medium rounded text-green-600 bg-white hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                Détails
                                            </a>
                                            <form action="/panier/add" method="post" class="inline-block">
                                                <input type="hidden" name="product[]" value="<?= htmlspecialchars($article->getTitle()) ?>">
                                                <input type="hidden" name="articleId[]" value="<?= $article->getArticleId() ?>">
                                                <input type="hidden" name="quantity[]" value="1">
                                                <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-white" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                                                    </svg>
                                                    Ajouter
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Message "Aucun produit trouvé" (caché par défaut) -->
                    <div id="no-products-message" class="hidden bg-white rounded-lg shadow-md p-8 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun produit ne correspond à vos critères</h3>
                        <p class="text-gray-600 mb-4">Essayez de modifier vos filtres pour voir plus de produits.</p>
                        <button id="reset-filters" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Réinitialiser les filtres
                        </button>
                    </div>
                </div>
            </div>
    <?php
        $contentPage = ob_get_clean();
        (new FrontPageView($contentPage, 'Articles de Blog', "Découvrez nos articles de blog pour un mode de vie plus écologique", ['diy']))->show();
    }
}

    ?>