<?php
/**
 * FAQ page view
 * Displays frequently asked questions organized by categories
 */
?>

<!-- Hero Section -->
<section class="hero-section bg-primary py-5 mb-5">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3 text-white">Frequently Asked Questions</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>" class="text-white">Home</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">FAQ</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="faq-section py-5">
    <div class="container">
        <!-- Search Bar -->
        <div class="row mb-5">
            <div class="col-md-8 mx-auto">
                <div class="input-group">
                    <input type="text" class="form-control" id="faqSearch" placeholder="Search FAQs...">
                    <button class="btn btn-primary" type="button">
                        <i class="bi bi-search"></i> Search
                    </button>
                </div>
            </div>
        </div>

        <!-- Category Tabs -->
        <ul class="nav nav-pills mb-4 justify-content-center" id="faqTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="all-tab" data-bs-toggle="pill" data-bs-target="#all" 
                        type="button" role="tab" aria-controls="all" aria-selected="true">
                    All Questions
                </button>
            </li>
            <?php foreach ($categories as $category): ?>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="<?= htmlspecialchars($category) ?>-tab" 
                            data-bs-toggle="pill" 
                            data-bs-target="#<?= htmlspecialchars($category) ?>" 
                            type="button" role="tab" 
                            aria-controls="<?= htmlspecialchars($category) ?>" 
                            aria-selected="false">
                        <?= htmlspecialchars(ucfirst($category)) ?>
                    </button>
                </li>
            <?php endforeach; ?>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="faqTabContent">
            <!-- All Questions Tab -->
            <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                <div class="accordion" id="accordionAllFAQs">
                    <?php $counter = 0; foreach ($faqsByCategory as $category => $categoryFaqs): ?>
                        <div class="accordion-item category-group" data-category="<?= htmlspecialchars($category) ?>">
                            <h2 class="accordion-header">
                                <button class="accordion-button fw-bold collapsed" type="button" 
                                        data-bs-toggle="collapse" 
                                        data-bs-target="#category<?= $counter ?>" 
                                        aria-expanded="false" 
                                        aria-controls="category<?= $counter ?>">
                                    <?= htmlspecialchars(ucfirst($category)) ?>
                                </button>
                            </h2>
                            <div id="category<?= $counter ?>" class="accordion-collapse collapse" 
                                 data-bs-parent="#accordionAllFAQs">
                                <div class="accordion-body">
                                    <div class="accordion" id="accordionCategory<?= $counter ?>">
                                        <?php foreach ($categoryFaqs as $index => $faq): ?>
                                            <div class="accordion-item faq-item">
                                                <h3 class="accordion-header">
                                                    <button class="accordion-button collapsed" type="button" 
                                                            data-bs-toggle="collapse" 
                                                            data-bs-target="#faq<?= $counter ?>_<?= $index ?>" 
                                                            aria-expanded="false" 
                                                            aria-controls="faq<?= $counter ?>_<?= $index ?>">
                                                        <?= htmlspecialchars($faq['question']) ?>
                                                    </button>
                                                </h3>
                                                <div id="faq<?= $counter ?>_<?= $index ?>" 
                                                     class="accordion-collapse collapse" 
                                                     data-bs-parent="#accordionCategory<?= $counter ?>">
                                                    <div class="accordion-body">
                                                        <?= nl2br(htmlspecialchars($faq['answer'])) ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php $counter++; endforeach; ?>
                </div>
            </div>

            <!-- Category Tabs -->
            <?php foreach ($categories as $category): ?>
                <div class="tab-pane fade" id="<?= htmlspecialchars($category) ?>" 
                     role="tabpanel" 
                     aria-labelledby="<?= htmlspecialchars($category) ?>-tab">
                    <div class="accordion" id="accordion<?= ucfirst($category) ?>">
                        <?php foreach ($faqsByCategory[$category] as $index => $faq): ?>
                            <div class="accordion-item faq-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" 
                                            data-bs-toggle="collapse" 
                                            data-bs-target="#faq<?= htmlspecialchars($category) ?>_<?= $index ?>" 
                                            aria-expanded="false" 
                                            aria-controls="faq<?= htmlspecialchars($category) ?>_<?= $index ?>">
                                        <?= htmlspecialchars($faq['question']) ?>
                                    </button>
                                </h3>
                                <div id="faq<?= htmlspecialchars($category) ?>_<?= $index ?>" 
                                     class="accordion-collapse collapse" 
                                     data-bs-parent="#accordion<?= ucfirst($category) ?>">
                                    <div class="accordion-body">
                                        <?= nl2br(htmlspecialchars($faq['answer'])) ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- FAQ search script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('faqSearch');
    const faqItems = document.querySelectorAll('.faq-item');

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();

        faqItems.forEach(item => {
            const question = item.querySelector('.accordion-button').textContent.toLowerCase();
            const answer = item.querySelector('.accordion-body').textContent.toLowerCase();
            
            if (question.includes(searchTerm) || answer.includes(searchTerm)) {
                item.style.display = '';
                // If item is in a category group, show the category
                const categoryGroup = item.closest('.category-group');
                if (categoryGroup) {
                    categoryGroup.style.display = '';
                }
            } else {
                item.style.display = 'none';
                // Check if all items in category are hidden
                const categoryGroup = item.closest('.category-group');
                if (categoryGroup) {
                    const visibleItems = categoryGroup.querySelectorAll('.faq-item[style="display: none;"]');
                    if (visibleItems.length === categoryGroup.querySelectorAll('.faq-item').length) {
                        categoryGroup.style.display = 'none';
                    }
                }
            }
        });
    });
});
</script>

<style>
.hero-section {
    background: linear-gradient(rgba(0, 100, 0, 0.8), rgba(0, 100, 0, 0.8)), url("<?= BASE_URL ?>/public/images/carousel/default-library.jpg") center/cover no-repeat;
}

.nav-pills .nav-link {
    margin: 0 0.25rem;
}

.accordion-button:not(.collapsed) {
    color: var(--bs-primary);
    background-color: rgba(var(--bs-primary-rgb), 0.1);
}

.accordion-button:focus {
    border-color: var(--bs-primary);
    box-shadow: 0 0 0 0.25rem rgba(var(--bs-primary-rgb), 0.25);
}
</style>