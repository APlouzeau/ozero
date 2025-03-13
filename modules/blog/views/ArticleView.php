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
                <?php endforeach; ?>
            </div>
        </div>

<?php
        $contentPage = ob_get_clean();
        (new FrontPageView($contentPage, 'Articles de Blog', "Découvrez nos articles de blog pour un mode de vie plus écologique", ['diy']))->show();
    }
}

?>
