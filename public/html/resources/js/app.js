import "bootstrap";
import "./animations.js";

document.documentElement.classList.add("js");

import { initMultiSelectForm } from "./multiselect";

document.addEventListener("DOMContentLoaded", () => {
    initMultiSelectForm("programs-filter");
});

// switch grid/list view for programs page
function switchView(view, container) {
    const containerSection = document.querySelector(container);
    const gridBtn = document.getElementById("grid-view-btn");
    const listBtn = document.getElementById("list-view-btn");

    if (!containerSection) {
        return;
    }
    if (view === "grid") {
        containerSection.classList.add("grid");
        gridBtn.classList.add("active");
        listBtn.classList.remove("active");
    } else {
        containerSection.classList.remove("grid");
        listBtn.classList.add("active");
        gridBtn.classList.remove("active");
    }
}

// window.switchView = switchView;

const gridBtn = document.getElementById("grid-view-btn");
const listBtn = document.getElementById("list-view-btn");
const selectedGrid = localStorage.getItem("selectedGrid");

window.onload = switchView(selectedGrid, ".page .programs");

if (gridBtn && listBtn) {
    gridBtn.addEventListener("click", function (e) {
        e.preventDefault();
        switchView("grid", ".programs");
        localStorage.setItem("selectedGrid", "grid");
    });

    listBtn.addEventListener("click", function (e) {
        e.preventDefault();
        switchView("list", ".programs");
        localStorage.setItem("selectedGrid", "list");
    });
}
