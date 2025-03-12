const view = document.querySelector(".view");
const grid = document.querySelector(".gridButton");
const list = document.querySelector(".listButton");

grid.addEventListener("click", () => {
    view.classList.add("grid");
    view.classList.remove("list");
});

list.addEventListener("click", () => {
    view.classList.add("list");
    view.classList.remove("grid");
});
