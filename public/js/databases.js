/**
 * Database category filtering functionality
 */
document.addEventListener('DOMContentLoaded', function() {
    const categoryButtons = document.querySelectorAll('.nav-pills .nav-link');
    const databaseCards = document.querySelectorAll('.databases-section .col-md-6');

    // Add click event listeners to category buttons
    categoryButtons.forEach(button => {
        button.addEventListener('click', function() {
            const category = this.getAttribute('data-category');

            // Update active button state
            categoryButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            // Filter database cards
            databaseCards.forEach(card => {
                if (category === 'all') {
                    card.style.display = '';
                } else {
                    const cardCategory = card.querySelector('.badge').textContent.trim();
                    card.style.display = cardCategory === category ? '' : 'none';
                }
            });
        });
    });
});