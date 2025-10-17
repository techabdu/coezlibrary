<?php
/**
 * Policies page view
 * Displays library policies, rules, and guidelines
 */
?>

<!-- Page Header -->
<div class="page-header bg-light">
    <div class="container py-5">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-3">
                <?php foreach ($breadcrumbs as $breadcrumb): ?>
                    <li class="breadcrumb-item <?= $breadcrumb['link'] === null ? 'active' : '' ?>">
                        <?php if ($breadcrumb['link']): ?>
                            <a href="<?= $breadcrumb['link'] ?>"><?= $breadcrumb['title'] ?></a>
                        <?php else: ?>
                            <?= $breadcrumb['title'] ?>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ol>
        </nav>
        
        <h1 class="display-4 mb-3">Library Policies</h1>
        <p class="lead text-muted">
            Guidelines and rules to ensure a productive learning environment for all
        </p>
    </div>
</div>

<!-- Main Content -->
<div class="container py-5">
    <div class="row">
        <!-- Quick Links Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="policy-sidebar sticky-top" style="top: 2rem;">
                <div class="card">
                    <div class="card-body">
                        <h2 class="h5 mb-3">Quick Navigation</h2>
                        <div class="list-group policy-nav">
                            <a href="#borrowing" class="list-group-item list-group-item-action">
                                Borrowing Policies
                            </a>
                            <a href="#computer" class="list-group-item list-group-item-action">
                                Computer Usage
                            </a>
                            <a href="#fines" class="list-group-item list-group-item-action">
                                Fines & Fees
                            </a>
                            <a href="#conduct" class="list-group-item list-group-item-action">
                                Code of Conduct
                            </a>
                            <a href="#spaces" class="list-group-item list-group-item-action">
                                Study Spaces
                            </a>
                            <a href="#resources" class="list-group-item list-group-item-action">
                                Digital Resources
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Policy Content -->
        <div class="col-lg-9">
            <!-- Dynamic Content from Database -->
            <?php if (isset($content['content'])): ?>
                <div class="policy-content">
                    <?= $content['content'] ?>
                </div>
            <?php else: ?>
                <!-- Default Policy Content -->
                <div class="policy-content">
                    <!-- Borrowing Policies -->
                    <section id="borrowing" class="policy-section mb-5">
                        <h2 class="h3 mb-4">Borrowing Policies</h2>
                        <div class="accordion" id="borrowingAccordion">
                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#loanPeriods">
                                        Loan Periods
                                    </button>
                                </h3>
                                <div id="loanPeriods" class="accordion-collapse collapse show">
                                    <div class="accordion-body">
                                        <ul class="policy-list">
                                            <li><strong>Books:</strong> 14 days with one renewal</li>
                                            <li><strong>Reference Materials:</strong> In-library use only</li>
                                            <li><strong>Journals:</strong> 7 days, no renewal</li>
                                            <li><strong>Media Items:</strong> 3 days with one renewal</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#borrowingLimits">
                                        Borrowing Limits
                                    </button>
                                </h3>
                                <div id="borrowingLimits" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        <ul class="policy-list">
                                            <li><strong>Students:</strong> Maximum 5 items</li>
                                            <li><strong>Faculty:</strong> Maximum 10 items</li>
                                            <li><strong>Staff:</strong> Maximum 7 items</li>
                                            <li><strong>Alumni:</strong> Maximum 3 items</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Computer Usage -->
                    <section id="computer" class="policy-section mb-5">
                        <h2 class="h3 mb-4">Computer Usage Rules</h2>
                        <div class="accordion" id="computerAccordion">
                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#generalComputer">
                                        General Guidelines
                                    </button>
                                </h3>
                                <div id="generalComputer" class="accordion-collapse collapse show">
                                    <div class="accordion-body">
                                        <ul class="policy-list">
                                            <li>Time limit: 2 hours per session</li>
                                            <li>Academic work takes priority</li>
                                            <li>No software installation allowed</li>
                                            <li>Save work to personal storage devices</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#computerRestrictions">
                                        Restrictions
                                    </button>
                                </h3>
                                <div id="computerRestrictions" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        <div class="alert alert-warning">
                                            <i class="bi bi-exclamation-triangle me-2"></i>
                                            The following activities are prohibited:
                                        </div>
                                        <ul class="policy-list">
                                            <li>Gaming or entertainment</li>
                                            <li>Downloading large files</li>
                                            <li>Accessing inappropriate content</li>
                                            <li>Commercial activities</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Fines and Fees -->
                    <section id="fines" class="policy-section mb-5">
                        <h2 class="h3 mb-4">Fines and Fees</h2>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Item Type</th>
                                        <th>Daily Fine</th>
                                        <th>Maximum Fine</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Books</td>
                                        <td>$0.50</td>
                                        <td>$25.00</td>
                                        <td>Per item</td>
                                    </tr>
                                    <tr>
                                        <td>Reference Materials</td>
                                        <td>$2.00</td>
                                        <td>$40.00</td>
                                        <td>Per item</td>
                                    </tr>
                                    <tr>
                                        <td>Media Items</td>
                                        <td>$1.00</td>
                                        <td>$30.00</td>
                                        <td>Per item</td>
                                    </tr>
                                    <tr>
                                        <td>Lost Items</td>
                                        <td colspan="2">Replacement Cost + $10.00</td>
                                        <td>Processing fee</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>

                    <!-- Code of Conduct -->
                    <section id="conduct" class="policy-section mb-5">
                        <h2 class="h3 mb-4">Code of Conduct</h2>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="conduct-card">
                                    <h3 class="h5 text-success">
                                        <i class="bi bi-check-circle me-2"></i>Expected Behavior
                                    </h3>
                                    <ul class="policy-list">
                                        <li>Maintain quiet study environment</li>
                                        <li>Respect library property</li>
                                        <li>Follow staff instructions</li>
                                        <li>Clean up after yourself</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="conduct-card">
                                    <h3 class="h5 text-danger">
                                        <i class="bi bi-x-circle me-2"></i>Prohibited Behavior
                                    </h3>
                                    <ul class="policy-list">
                                        <li>Loud conversations</li>
                                        <li>Food and drinks (except water)</li>
                                        <li>Damaging materials</li>
                                        <li>Disruptive behavior</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Study Spaces -->
                    <section id="spaces" class="policy-section mb-5">
                        <h2 class="h3 mb-4">Study Spaces</h2>
                        <div class="accordion" id="spacesAccordion">
                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#roomBooking">
                                        Room Booking Policy
                                    </button>
                                </h3>
                                <div id="roomBooking" class="accordion-collapse collapse show">
                                    <div class="accordion-body">
                                        <ul class="policy-list">
                                            <li>Maximum 2-hour booking per day</li>
                                            <li>Advance booking required</li>
                                            <li>Group study rooms: 2-6 people</li>
                                            <li>Cancellation notice: 2 hours</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Digital Resources -->
                    <section id="resources" class="policy-section mb-5">
                        <h2 class="h3 mb-4">Digital Resources</h2>
                        <div class="accordion" id="resourcesAccordion">
                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#accessPolicy">
                                        Access and Usage Policy
                                    </button>
                                </h3>
                                <div id="accessPolicy" class="accordion-collapse collapse show">
                                    <div class="accordion-body">
                                        <ul class="policy-list">
                                            <li>Valid library card required</li>
                                            <li>Remote access available</li>
                                            <li>Copyright restrictions apply</li>
                                            <li>Download limits may apply</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Policies Page Styles -->
<style>
/* Policy Navigation */
.policy-nav .list-group-item {
    border: none;
    padding: 0.75rem 1rem;
    color: var(--gray-700);
    background: transparent;
    transition: var(--transition-base);
}

.policy-nav .list-group-item:hover,
.policy-nav .list-group-item:focus {
    color: var(--primary);
    background-color: var(--primary-light);
    transform: translateX(5px);
}

/* Policy Sections */
.policy-section {
    scroll-margin-top: 2rem;
}

.policy-section h2 {
    color: var(--gray-900);
    padding-bottom: 0.5rem;
    border-bottom: 2px solid var(--primary);
    display: inline-block;
}

/* Accordion Customization */
.accordion-button {
    background-color: var(--white);
}

.accordion-button:not(.collapsed) {
    color: var(--primary);
    background-color: var(--primary-light);
    box-shadow: none;
}

.accordion-button:focus {
    box-shadow: none;
    border-color: var(--primary);
}

/* Policy Lists */
.policy-list {
    list-style: none;
    padding-left: 0;
}

.policy-list li {
    position: relative;
    padding-left: 1.5rem;
    margin-bottom: 0.75rem;
    color: var(--gray-700);
}

.policy-list li::before {
    content: "•";
    position: absolute;
    left: 0;
    color: var(--primary);
}

/* Conduct Cards */
.conduct-card {
    background: var(--white);
    border-radius: var(--border-radius);
    padding: 1.5rem;
    height: 100%;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--gray-200);
}

/* Tables */
.table {
    --bs-table-striped-bg: var(--primary-light);
}

.table th {
    background-color: var(--primary);
    color: var(--white);
}

/* Responsive Adjustments */
@media (max-width: 992px) {
    .policy-sidebar {
        position: static !important;
        margin-bottom: 2rem;
    }

    .policy-nav {
        display: flex;
        flex-wrap: nowrap;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .policy-nav .list-group-item {
        flex: 0 0 auto;
        white-space: nowrap;
    }
}

@media (max-width: 768px) {
    .page-header h1 {
        font-size: 2rem;
    }

    .policy-section h2 {
        font-size: 1.5rem;
    }

    .conduct-card {
        padding: 1rem;
    }
}
</style>

<!-- Smooth Scroll Behavior Script -->
<script>
document.querySelectorAll('.policy-nav a').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const section = document.querySelector(this.getAttribute('href'));
        window.scrollTo({
            top: section.offsetTop - 20,
            behavior: 'smooth'
        });
    });
});
</script>