<?php

class DiyView extends View
{
    public function __construct() {
        parent::__construct();
    }

    public function show()
    {
        // Données des tutoriels DIY
        $tutorials = [
            [
                'id' => 1,
                'title' => 'Jardin Urbain',
                'description' => 'Faites pousser vos propres herbes aromatiques et légumes sur votre balcon.',
                'price' => 14.45,
                'category' => 'jardin',
                'image' => '/assets/png/jardin-urbain.png'
            ],
            [
                'id' => 2,
                'title' => 'Bombes à Graines',
                'description' => 'Faites pousser vos propres herbes aromatiques et légumes sur votre balcon.',
                'price' => 14.45,
                'category' => 'jardin',
                'image' => '/assets/png/bombes-graines.png'
            ],
            [
                'id' => 3,
                'title' => 'Hôtel à Insectes',
                'description' => 'Faites pousser vos propres herbes aromatiques et légumes sur votre balcon.',
                'price' => 14.45,
                'category' => 'jardin',
                'image' => '/assets/png/hotel-insectes.png'
            ],
            [
                'id' => 4,
                'title' => 'Compost Maison',
                'description' => 'Faites pousser vos propres herbes aromatiques et légumes sur votre balcon.',
                'price' => 14.45,
                'category' => 'jardin',
                'image' => '/assets/png/compost-maison.png'
            ],
            [
                'id' => 5,
                'title' => 'Savon Naturel',
                'description' => 'Fabriquez votre propre savon avec des ingrédients naturels et sans produits chimiques.',
                'price' => 12.99,
                'category' => 'cosmetiques',
                'image' => '/assets/png/savon-naturel.png'
            ],
            [
                'id' => 6,
                'title' => 'Shampoing Solide',
                'description' => 'Un shampoing écologique sans emballage plastique, facile à réaliser chez soi.',
                'price' => 9.99,
                'category' => 'cosmetiques',
                'image' => '/assets/png/shampoing-solide.png'
            ],
            [
                'id' => 7,
                'title' => 'Éponge Réutilisable',
                'description' => 'Créez des éponges écologiques et durables pour votre cuisine.',
                'price' => 7.50,
                'category' => 'entretien',
                'image' => '/assets/png/eponge-reutilisable.png'
            ],
            [
                'id' => 8,
                'title' => 'Lessive Maison',
                'description' => 'Une lessive naturelle et économique, sans produits chimiques nocifs.',
                'price' => 8.75,
                'category' => 'entretien',
                'image' => '/assets/png/lessive-maison.png'
            ]
        ];

        // Catégories disponibles
        $categories = [
            'all' => 'Tous les Tutos',
            'jardin' => 'Jardin & Nature',
            'cosmetiques' => 'Cosmétiques Naturels',
            'entretien' => 'Maison & Entretien',
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
                $filteredTutorials = array_filter($tutorials, function($tutorial) use ($selectedCategory) {
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
                                <?php if (!empty($tutorial['image'])): ?>
                                    <img src="<?= $tutorial['image'] ?>" alt="<?= $tutorial['title'] ?>" class="w-full h-full object-cover">
                                <?php endif; ?>
                            </div>
                            <div class="w-2/3 p-4">
                                <h3 class="text-lg font-semibold mb-2 font-supreme"><?= $tutorial['title'] ?></h3>
                                <p class="text-sm text-gray-600 mb-4 font-supreme"><?= $tutorial['description'] ?></p>
                                <div class="text-right">
                                    <span class="text-primary font-bold"><?= number_format($tutorial['price'], 2) ?> €</span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <div class="mb-12">
                    <?php foreach ($filteredTutorials as $tutorial): ?>
                        <div class="bg-white rounded-lg shadow-box overflow-hidden flex mb-4">
                            <div class="w-1/6 bg-gray-200">
                                <?php if (!empty($tutorial['image'])): ?>
                                    <img src="<?= $tutorial['image'] ?>" alt="<?= $tutorial['title'] ?>" class="w-full h-full object-cover">
                                <?php endif; ?>
                            </div>
                            <div class="w-4/6 p-4">
                                <h3 class="text-lg font-semibold mb-2 font-supreme"><?= $tutorial['title'] ?></h3>
                                <p class="text-sm text-gray-600 font-supreme"><?= $tutorial['description'] ?></p>
                            </div>
                            <div class="w-1/6 p-4 flex items-center justify-center">
                                <span class="text-primary font-bold"><?= number_format($tutorial['price'], 2) ?> €</span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>

<?php
        $contentPage = ob_get_clean();
        (new FrontPageView($contentPage, 'DIY - Faites-le vous-même', "Découvrez nos tutoriels DIY pour adopter un mode de vie plus écologique", ['debug']))->show();
    }
} 