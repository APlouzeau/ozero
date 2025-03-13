<?php

class ArticleView
{

    private ?ArticleEntity $article;
    private ?array $associatedProducts;

    public function __construct(?ArticleEntity $article = null, array $associatedProducts = [])
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
                        $productEntity = $productModel->getProductById($productId);?>
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
            </div>
        </div>

<?php
        $contentPage = ob_get_clean();
        (new FrontPageView($contentPage, 'Articles de Blog', "Découvrez nos articles de blog pour un mode de vie plus écologique", ['diy']))->show();
    }
}

?>
