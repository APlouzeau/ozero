<?php

class FooterView extends View {

    public function show() {
        ?>

        <div style="padding-left: 5px; padding-right: 5px;">
            <footer class="footer bg-base- text-base-content p-10" style="background-color: #4CB05C; border-radius: 10px; display: flex; justify-content: space-between; align-items: center;">
                <aside style="display: flex; align-items: center; gap: 20px;">
                    <img src="/assets/png/Logo-footer.png" alt="Logo Ozero Footer" width="100" height="100">
                    <img src="/assets/png/Ozero.png" alt="Logo Ozero Footer" width="100" height="100">
                </aside>
                <nav style="display: flex; gap: 40px; align-items: center; justify-content: center; flex-grow: 1; text-align: center;">
                    <a class="footer-link link link-hover">Contact</a>
                    <a class="footer-link link link-hover">À propos</a>
                </nav>
            </footer>
        </div>

        <?php
        return ob_get_clean();
    }
}
