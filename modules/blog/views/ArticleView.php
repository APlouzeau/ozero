<?php

class ArticleView
{

    private ?ArticleEntity $article;
    public function __construct(?ArticleEntity $article = null)
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
                    <figure class="w-full h-64 overflow-hidden rounded-lg">
                        <img src="<?= htmlspecialchars($this->article->getImg()) ?>" alt="<?= htmlspecialchars($this->article->getTitle()) ?>" class="w-full h-full object-cover">
                    </figure>
                    <!-- Contenu de l'article -->
                    <div class="mt-6">
                        <!-- Titre -->
                        <h1 class="text-4xl font-bold"><?= htmlspecialchars($this->article->getTitle()) ?></h1>
                        <p class="text-gray-500 mt-2">
                            Par <span class="font-semibold"><?= htmlspecialchars($this->article->getAuthorName()) ?></span> - <?= $this->article->getArticleDate()->format('d M Y') ?>
                        </p>
                        <!-- Contenu (description) -->
                        <div class="mt-4 text-lg leading-relaxed">
                            <?= nl2br($this->article->getContent()) ?>
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

////////
<div class="max-w-4xl mx-auto p-6 bg-base-100 shadow-lg rounded-lg flex gap-6">
    <!-- Bloc images -->
    <div class="flex gap-4">
        <div class="flex flex-col gap-2 h-72"> <!-- Assure que la hauteur de la colonne est égale à la grande image -->
            <div class="w-24 h-24 bg-gray-300"></div>
            <div class="w-24 h-24 bg-gray-300"></div>
            <div class="w-24 h-24 bg-gray-300"></div>
        </div>
        <div class="w-72 h-72 bg-gray-300"></div> <!-- Image principale carrée -->
    </div>

    <!-- Contenu article -->
    <div class="flex-1 flex flex-col justify-between">
        <div>
            <h2 class="text-2xl font-bold">Titre de l'Article</h2>
            <p class="text-gray-600 mt-2">Description courte de l'article qui résume son contenu et attire l'intérêt du lecteur.</p>
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

<!-- Espace texte -->
<div class="mt-8">
    <p class="text-gray-700">Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime mollitia,
molestiae quas vel sint commodi repudiandae consequuntur voluptatum laborum
numquam blanditiis harum quisquam eius sed odit fugiat iusto fuga praesentium
optio, eaque rerum! Provident similique accusantium nemo autem. Veritatis
obcaecati tenetur iure eius earum ut molestias architecto voluptate aliquam
nihil, eveniet aliquid culpa officia aut! Impedit sit sunt quaerat, odit,
tenetur error, harum nesciunt ipsum debitis quas aliquid. Reprehenderit,
quia. Quo neque error repudiandae fuga? Ipsa laudantium molestias eos 
sapiente officiis modi at sunt excepturi expedita sint? Sed quibusdam
recusandae alias error harum maxime adipisci amet laborum. Perspiciatis 
minima nesciunt dolorem! Officiis iure rerum voluptates a cumque velit 
quibusdam sed amet tempora. Sit laborum ab, eius fugit doloribus tenetur 
fugiat, temporibus enim commodi iusto libero magni deleniti quod quam 
consequuntur! Commodi minima excepturi repudiandae velit hic maxime
doloremque. Quaerat provident commodi consectetur veniam similique ad 
earum omnis ipsum saepe, voluptas, hic voluptates pariatur est explicabo 
fugiat, dolorum eligendi quam cupiditate excepturi mollitia maiores labore 
suscipit quas? Nulla, placeat. Voluptatem quaerat non architecto ab laudantium
modi minima sunt esse temporibus sint culpa, recusandae aliquam numquam 
totam ratione voluptas quod exercitationem fuga. Possimus quis earum veniam 
quasi aliquam eligendi, placeat qui corporis!</p>
</div>

<!-- Section Articles associés -->
<div class="mt-8">
    <h3 class="text-xl font-semibold">Articles associés :</h3>
    <div class="flex flex-wrap gap-4 mt-4">
        <div class="w-24 h-24 bg-gray-300"></div>
        <div class="w-24 h-24 bg-gray-300"></div>
        <div class="w-24 h-24 bg-gray-300"></div>
        <div class="w-24 h-24 bg-gray-300"></div>
        <div class="w-24 h-24 bg-gray-300"></div>
        <div class="w-24 h-24 bg-gray-300"></div>
        <div class="w-24 h-24 bg-gray-300"></div>
        <div class="w-24 h-24 bg-gray-300"></div>
        <div class="w-24 h-24 bg-gray-300"></div>
        <div class="w-24 h-24 bg-gray-300"></div>
        <div class="w-24 h-24 bg-gray-300"></div>
        <div class="w-24 h-24 bg-gray-300"></div>
    </div>
</div>

<!-- Section Tuto -->
<div class="mt-8">
    <h3 class="text-xl font-semibold">Tuto : Comment utiliser cet article ?</h3>
    <ol class="list-decimal pl-6 mt-4">
        <li>Étape 1 : Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime mollitia,
molestiae quas vel sint commodi repudiandae consequuntur voluptatum laborum
numquam blanditiis harum quisquam eius sed odit fugiat iusto fuga praesentium
optio, eaque rerum! Provident similique accusantium nemo autem. Veritatis
obcaecati tenetur iure eius earum ut molestias architecto voluptate aliquam
nihil, eveniet aliquid culpa officia aut! Impedit sit sunt quaerat, odit,
tenetur error, harum nesciunt ipsum debitis quas aliquid. Reprehenderit,
quia. Quo neque error repudiandae fuga? Ipsa laudantium molestias eos 
sapiente officiis modi at sunt excepturi expedita sint? Sed quibusdam
recusandae alias error harum maxime adipisci amet laborum. Perspiciatis 
minima nesciunt dolorem! Officiis iure rerum voluptates a cumque velit 
quibusdam sed amet tempora.</li>
        <li>Étape 2 : Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime mollitia,
molestiae quas vel sint commodi repudiandae consequuntur voluptatum laborum
numquam blanditiis harum quisquam eius sed odit fugiat iusto fuga praesentium
optio, eaque rerum! Provident similique accusantium nemo autem. Veritatis
obcaecati tenetur iure eius earum ut molestias architecto voluptate aliquam
nihil, eveniet aliquid culpa officia aut! Impedit sit sunt quaerat, odit,
tenetur error, harum nesciunt ipsum debitis quas aliquid. Reprehenderit,
quia. Quo neque error repudiandae fuga? Ipsa laudantium molestias eos 
sapiente officiis modi at sunt excepturi expedita sint? Sed quibusdam
recusandae alias error harum maxime adipisci amet laborum. Perspiciatis 
minima nesciunt dolorem! Officiis iure rerum voluptates a cumque velit 
quibusdam sed amet tempora.</li>
        <li>Étape 3 : Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime mollitia,
molestiae quas vel sint commodi repudiandae consequuntur voluptatum laborum
numquam blanditiis harum quisquam eius sed odit fugiat iusto fuga praesentium
optio, eaque rerum! Provident similique accusantium nemo autem. Veritatis
obcaecati tenetur iure eius earum ut molestias architecto voluptate aliquam
nihil, eveniet aliquid culpa officia aut! Impedit sit sunt quaerat, odit,
tenetur error, harum nesciunt ipsum debitis quas aliquid. Reprehenderit,
quia. Quo neque error repudiandae fuga? Ipsa laudantium molestias eos 
sapiente officiis modi at sunt excepturi expedita sint? Sed quibusdam
recusandae alias error harum maxime adipisci amet laborum. Perspiciatis 
minima nesciunt dolorem! Officiis iure rerum voluptates a cumque velit 
quibusdam sed amet tempora.</li>
        <li>Étape 4 : Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime mollitia,
molestiae quas vel sint commodi repudiandae consequuntur voluptatum laborum
numquam blanditiis harum quisquam eius sed odit fugiat iusto fuga praesentium
optio, eaque rerum! Provident similique accusantium nemo autem. Veritatis
obcaecati tenetur iure eius earum ut molestias architecto voluptate aliquam
nihil, eveniet aliquid culpa officia aut! Impedit sit sunt quaerat, odit,
tenetur error, harum nesciunt ipsum debitis quas aliquid. Reprehenderit,
quia. Quo neque error repudiandae fuga? Ipsa laudantium molestias eos 
sapiente officiis modi at sunt excepturi expedita sint? Sed quibusdam
recusandae alias error harum maxime adipisci amet laborum. Perspiciatis 
minima nesciunt dolorem! Officiis iure rerum voluptates a cumque velit 
quibusdam sed amet tempora.</li>
        <li>Étape 5 : Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime mollitia,
molestiae quas vel sint commodi repudiandae consequuntur voluptatum laborum
numquam blanditiis harum quisquam eius sed odit fugiat iusto fuga praesentium
optio, eaque rerum! Provident similique accusantium nemo autem. Veritatis
obcaecati tenetur iure eius earum ut molestias architecto voluptate aliquam
nihil, eveniet aliquid culpa officia aut! Impedit sit sunt quaerat, odit,
tenetur error, harum nesciunt ipsum debitis quas aliquid. Reprehenderit,
quia. Quo neque error repudiandae fuga? Ipsa laudantium molestias eos 
sapiente officiis modi at sunt excepturi expedita sint? Sed quibusdam
recusandae alias error harum maxime adipisci amet laborum. Perspiciatis 
minima nesciunt dolorem! Officiis iure rerum voluptates a cumque velit 
quibusdam sed amet tempora.</li>
    </ol>
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
                <?php endforeach; ?>
            </div>
        </div>

<?php
        $contentPage = ob_get_clean();
        (new FrontPageView($contentPage, 'Articles de Blog', "Découvrez nos articles de blog pour un mode de vie plus écologique", []))->show();
    }
}

?>