// Appliquer un css tailwind classique à toutes les balises du contenu du blog
const blogContent = document.getElementById('blog-content');

// CSS
const h1 = ['text-2xl', 'font-bold'];
const h2 = ['text-xl','font-bold'];
const h3 = ['text-lg' ,'font-bold'];
const h4 = ['text-base' ,'font-bold'];

blogContent.querySelectorAll('h1').forEach(h1Tag => {
    h1.forEach(h1 => {
        h1Tag.classList.add(h1);
    });
}
);
blogContent.querySelectorAll('h2').forEach(h2Tag => {
    h2.forEach(h2 => {
        h2Tag.classList.add(h2);
    });
}
);
blogContent.querySelectorAll('h3').forEach(h3Tag => {
    h3.forEach(h3 => {
        h3Tag.classList.add(h3);
    });
}
);
blogContent.querySelectorAll('h4').forEach(h4Tag => {
    h4.forEach(h4 => {
        h4Tag.classList.add(h4);
    });
}
);
