<?php

class AuthView {
    protected $user;

    public function __construct($user = null) {
        if ($user != null) {
            $this->user = $user;
        }
    }

    public function showLoginForm() {
        ob_start();
        ?>

        <div class="max-w-5xl mx-auto min-h-screen bg-white">
            <form id="loginForm" class="loginRegisterForm my-8 md:my-16 max-w-96 mx-auto card shadow-lg shadow-black-950 p-6 bg-white" action="/login" method="POST">
                <h2 class="text-2xl font-bold mb-4 text-center text-black">Se connecter</h2>

                <div id="flashMessageContainer" class=""></div>

                <div class="form-control mb-4">
                    <label for="email" class="label">
                        <span class="label-text text-black">Email :</span>
                    </label>
                    <input type="email" id="email" name="email" required class="input input-bordered w-full bg-gray-100 focus:bg-white"/>
                </div>

                <div class="form-control mb-4">
                    <label for="password" class="label">
                        <span class="label-text text-black">Mot de passe :</span>
                    </label>
                    <input type="password" id="password" name="password" required class="input input-bordered w-full bg-gray-100 focus:bg-white"/>
                </div>

                <div>
                    <input type="checkbox" id="remember" name="remember"/>
                    <label for="remember" class="text-black">Se souvenir de moi</label>
                </div>

                <!-- Bouton vert -->
                <button type="submit" class="btn w-full mt-4 text-white border-none shadow-lg shadow-black-950" style="background-color: #4CB05C;">
                    Connexion
                </button>


                <a href="/register" class="link link-primary mt-2 block text-center text-black hover:text-[#4CB05C] transition-colors duration-300">
                    Pas de compte ? S'enregistrer
                </a>
            </form>
        </div>

        <?php
        return ob_get_clean();
    }

    public function showRegisterForm() {
        ob_start();
        ?>

        <div class="max-w-5xl mx-auto min-h-screen bg-white">
            <form id="registerForm" class="loginRegisterForm my-8 md:my-16 max-w-96 mx-auto card shadow-lg shadow-black-950 p-6 bg-white" action="/register" method="POST">
                <h2 class="text-2xl font-bold mb-4 text-center text-black">S'inscrire</h2>

                <div id="flashMessageContainer" class=""></div>

                <div class="form-control mb-4">
                    <label for="firstName" class="label">
                        <span class="label-text text-black">Prénom :</span>
                    </label>
                    <input type="text" id="firstName" name="firstName" autocomplete="given-name" class="input input-bordered w-full bg-gray-100 focus:bg-white" required/>
                </div>

                <div class="form-control mb-4">
                    <label for="lastName" class="label">
                        <span class="label-text text-black">Nom :</span>
                    </label>
                    <input type="text" id="lastName" name="lastName" autocomplete="family-name" class="input input-bordered w-full bg-gray-100 focus:bg-white" required/>
                </div>

                <div class="form-control mb-4">
                    <label for="name" class="label">
                        <span class="label-text text-black">Nom d'utilisateur :</span>
                    </label>
                    <input type="text" id="name" name="name" required autocomplete="username" class="input input-bordered w-full bg-gray-100 focus:bg-white"/>
                </div>

                <div class="form-control mb-4">
                    <label for="email" class="label">
                        <span class="label-text text-black">Email :</span>
                    </label>
                    <input type="email" id="email" name="email" required autocomplete="email" class="input input-bordered w-full bg-gray-100 focus:bg-white"/>
                </div>

                <div class="form-control mb-4">
                    <label for="password" class="label">
                        <span class="label-text text-black">Mot de passe :</span>
                    </label>
                    <input type="password" id="password" name="password" required autocomplete="new-password" class="input input-bordered w-full bg-gray-100 focus:bg-white"/>
                </div>

                <!-- Bouton vert -->
                <button type="submit" class="btn w-full mt-4 text-white border-none outline-none shadow-lg shadow-black-950" style="background-color: #4CB05C;">
                    Inscription
                </button>


                <a href="/login" class="link link-primary mt-2 block text-center text-black hover:text-[#4CB05C] transition-colors duration-300">
                     Déjà un compte ? Se connecter
                </a>
            </form>
        </div>

        <?php
        return ob_get_clean();
    }
}
