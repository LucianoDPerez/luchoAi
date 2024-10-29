    const cards = document.querySelectorAll('.card-container');
    const itemsPerPage = 3; // Número de tarjetas por página
    let currentPage = 1;

    function showPage(page) {
    const start = (page - 1) * itemsPerPage;
    const end = start + itemsPerPage;

    cards.forEach((card, index) => {
    card.style.display = (index >= start && index < end) ? 'block' : 'none';
});

    // Actualizar visibilidad del paginador
    document.getElementById('prevPage').style.display = currentPage === 1 ? 'none' : 'inline';
    document.getElementById('nextPage').style.display = (currentPage * itemsPerPage) >= cards.length ? 'none' : 'inline';
}

    document.getElementById('mobileSearch').addEventListener('keyup', function() {
    const filter = this.value.toLowerCase();
    let filteredCards = Array.from(cards).filter(card => {
    const name = card.querySelector('.card-title').textContent.toLowerCase();
    return name.includes(filter);
});

    // Mostrar solo las tarjetas que coinciden con el filtro
    cards.forEach(card => {
    card.style.display = 'none'; // Ocultar todas las tarjetas
});

    filteredCards.forEach(card => {
    card.style.display = 'block'; // Mostrar solo las que coinciden
});

    // Reset pagination after search
    currentPage = 1;
    showPage(currentPage);
});

    document.getElementById('prevPage').addEventListener('click', function(e) {
    e.preventDefault();
    if (currentPage > 1) {
    currentPage--;
    showPage(currentPage);
}
});

    document.getElementById('nextPage').addEventListener('click', function(e) {
    e.preventDefault();
    if ((currentPage * itemsPerPage) < cards.length) {
    currentPage++;
    showPage(currentPage);
}
});

    // Initial display
    showPage(currentPage);