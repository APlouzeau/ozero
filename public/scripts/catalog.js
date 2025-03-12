const view = document.querySelector(".view");
const grid = document.querySelector(".gridButton");
const list = document.querySelector(".listButton");
const rangePrice = document.querySelector("#rangePrice");

grid.addEventListener("click", () => {
    view.classList.add("grid");
    view.classList.remove("list");
});

list.addEventListener("click", () => {
    view.classList.add("list");
    view.classList.remove("grid");
});

rangePrice.addEventListener("input", () => {
    const value = rangePrice.value;
    const price = document.querySelector(".price");
    console.log(value);
});
