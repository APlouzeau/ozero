const conteneurGrid = document.getElementById('conteneur-grid');
const conteneurList = document.getElementById('conteneur-list');
const grid = document.getElementById('gridView');
const list = document.getElementById('listView');

grid.addEventListener('click', function() {
    conteneurGrid.style.display = '';
    conteneurList.style.display = 'none';
    grid.classList.add('bg-gray-200');
    list.classList.remove('bg-gray-200');
}
);

list.addEventListener('click', function() {
    conteneurGrid.style.display = 'none';
    conteneurList.style.display = 'block';
    list.classList.add('bg-gray-200');
    grid.classList.remove('bg-gray-200');
}
);