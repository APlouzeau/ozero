<?php

class NavbarView extends View
{

    public function show()
    {
        $user = new SessionController();
        $subtotal = 0;
        $products = 0;
        if (isset($_SESSION['cart'])) {
            $products = count($_SESSION['cart']);
            foreach ($_SESSION['cart'] as $product) {
                $subtotal += $product['price'] * $product['quantity'];
            };
        }

        ob_start(); // Commence la mise en mémoire tampon du contenu
?>

        <nav class="bg-white border-gray-200 w-[95%] mx-auto rounded-bl-[10px] shadow-lg shadow-black-950 rounded-br-[10px] font-supreme">
            <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
                <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse pb-2">
                    <img src="/assets/png/Logo.png" alt="Logo" class="w-32 h-15">
                </a>
                <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                    <div class="flex items-center gap-4">
                        <!-- Panier -->
                        <div class="dropdown dropdown-end">
                            <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
                                <div class="indicator">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <span class="badge bg-primary badge-sm indicator-item"><?= $products ?></span>
                                </div>
                            </div>
                            <div tabindex="0" class="card card-compact dropdown-content bg-base-100 z-[1] mt-3 w-52 shadow">
                                <div class="card-body">
                                    <span class="text-lg font-bold font-supreme"><?= $products ?> Articles</span>
                                    <span class="text-info font-supreme">Sous-total: <?= $subtotal ?> €</span>
                                    <div class="card-actions">
                                        <a href="/panier" class="btn bg-primary hover:bg-primary/80 text-white btn-block font-supreme font-semibold">Voir le panier</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Profil utilisateur -->
                        <?php if ($user->isLoggedIn()): ?>
                            <div class="dropdown dropdown-end">
                                <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                                    <div class="w-10 rounded-full relative">
                                        <svg width="24px" height="24px" class="absolute top-1/2 -translate-y-1/2 left-1/2 -translate-x-1/2" viewBox="0 0 24 24" fill="black" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5 21C5 17.134 8.13401 14 12 14C15.866 14 19 17.134 19 21M16 7C16 9.20914 14.2091 11 12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                </div>
                                <ul tabindex="0" class="menu menu-sm dropdown-content bg-white color-black rounded-box z-[1] mt-3 w-52 p-2 shadow">
                                    <li>
                                        <h4 class="font-supreme">Bonjour, <span class="font-bold"><?= ucfirst($user->getFirstName()) ?></span></h4>
                                    </li>
                                    <li><a href="/profile" class="font-supreme font-semibold">Profile</a></li>
                                    <li><a href="/commandes" class="font-supreme font-semibold">Commandes</a></li>
                                    <li><a href="/admin/users" class="font-supreme font-semibold">Liste Utilisateurs</a></li>
                                    <li>
                                        <form id="logoutForm" action="/logout" method="POST" style="display: inline;">
                                            <button type="submit" class="w-full text-left font-supreme font-semibold">Se déconnecter</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        <?php else: ?>
                            <a href="/login" class="text-gray-800 hover:bg-gray-50 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 py-2 md:px-5 md:py-2.5 font-supreme font-semibold">Se connecter</a>
                        <?php endif; ?>
                    </div>
                    <button data-collapse-toggle="mega-menu" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200" aria-controls="mega-menu" aria-expanded="false">
                        <span class="sr-only">Ouvrir le menu</span>
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                        </svg>
                    </button>
                </div>
                <div id="mega-menu" class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1 md:justify-center">
                    <ul class="flex flex-col mt-4 font-medium md:flex-row md:space-x-8 md:mt-0 md:items-center">
                        <li>
                            <?php if ($_SERVER['REQUEST_URI'] === '/'): ?>
                                <a href="/" class="block bg-primary text-white rounded !p-1 font-supreme font-semibold">Accueil</a>
                            <?php else: ?>
                                <a href="/" class="block py-2 px-3 md:p-0 text-gray-900 hover:text-primary font-supreme font-semibold">Accueil</a>
                            <?php endif; ?>
                        </li>
                        <li>
                            <?php if ($_SERVER['REQUEST_URI'] === '/blog'): ?>
                                <a href="/blog" class="block bg-primary text-white rounded !p-1 font-supreme font-semibold">Zéro-déchet</a>
                            <?php else: ?>
                                <a href="/blog" class="block py-2 px-3 md:p-0 text-gray-900 hover:text-primary font-supreme font-semibold">Zéro-déchet</a>
                            <?php endif; ?>
                        </li>
                        <li>
                            <?php if ($_SERVER['REQUEST_URI'] === '/diy'): ?>
                                <a href="/diy" class="block bg-primary text-white rounded !p-1 font-supreme font-semibold">DIY</a>
                            <?php else: ?>
                                <a href="/diy" class="block py-2 px-3 md:p-0 text-gray-900 hover:text-primary font-supreme font-semibold">DIY</a>
                            <?php endif; ?>
                        </li>
                        <li>
                            <?php if ($_SERVER['REQUEST_URI'] === '/catalogue'): ?>
                                <a href="/catalogue" class="block bg-primary text-white rounded !p-1 font-supreme font-semibold">Catalogue</a>
                            <?php else: ?>
                                <a href="/catalogue" class="block py-2 px-3 md:p-0 text-gray-900 hover:text-primary font-supreme font-semibold">Catalogue</a>
                            <?php endif; ?>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

<?php
        return ob_get_clean();
    }
}
