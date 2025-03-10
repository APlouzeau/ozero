<?php

class FooterView extends View {

    public function show() {
        ob_start();
        ?>

        <div class="flex flex-row px-5 justify-center items-center">
            <footer class="footer w-[95%] p-10 bg-primary shadow-lg shadow-black-950 text-base-content rounded-tl-[10px] rounded-tr-[10px] flex justify-between items-center font-supreme">
                <aside class="flex items-center gap-5">
                    <img src="/assets/png/Logo1.png" alt="Logo Ozero Footer" width="200" height="200">
                </aside>
                <nav class="flex gap-10 items-center justify-center flex-grow text-center">
                    <a class="footer-link link link-hover font-supreme font-semibold">Contact</a>
                    <a class="footer-link link link-hover font-supreme font-semibold">À propos</a>
                </nav>
            </footer>
        </div>

        <?php
        return ob_get_clean();
    }
}