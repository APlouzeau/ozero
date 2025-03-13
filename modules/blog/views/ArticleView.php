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