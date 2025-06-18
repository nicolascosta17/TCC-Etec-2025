function confirmDelete(productName) {
    return confirm("Tem certeza que deseja excluir o produto \"" + productName + "\"?");
}

function toggleDescription(button) {
    const row = button.closest("tr");
    const shortDesc = row.querySelector(".description-short");
    const fullDesc = row.querySelector(".description-full");

    if (shortDesc.style.display === "none") {
        shortDesc.style.display = "inline";
        fullDesc.style.display = "none";
        button.textContent = "Mostrar Mais";
    } else {
        shortDesc.style.display = "none";
        fullDesc.style.display = "inline";
        button.textContent = "Mostrar Menos";
    }
}

function filterByStatus(status) {
    const rows = document.querySelectorAll("table tbody tr");
    rows.forEach(row => {
        const indicator = row.querySelector(".status-indicator");
        if (!indicator) return;

        const classList = indicator.classList;
        const matchesStatus =
            (status === "green" && classList.contains("status-green")) ||
            (status === "yellow" && classList.contains("status-yellow")) ||
            (status === "red" && classList.contains("status-red")) ||
            (status === "all");

        row.style.display = matchesStatus ? "" : "none";
    });
}

document.addEventListener("DOMContentLoaded", () => {
    const filterButtons = document.querySelectorAll(".status-filter-btn");
    filterButtons.forEach(btn => {
        btn.addEventListener("click", () => {
            const status = btn.dataset.status;
            filterByStatus(status);
        });
    });
});
