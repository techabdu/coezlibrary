-- Seed data for static_pages table

-- About Us page content
INSERT INTO static_pages (page_name, slug, content) VALUES 
('About Us', 'about-us', '<section class="mission-section mb-5">
    <h2 class="h3 mb-4">Our Mission</h2>
    <p class="lead">To foster academic excellence and lifelong learning by providing comprehensive information resources and innovative services to our college community.</p>
    <p>The College of Engineering Z Library serves as the intellectual heart of our campus, offering a blend of traditional library services and cutting-edge digital resources. We strive to create an inclusive, collaborative environment that supports research, learning, and discovery.</p>
</section>

<section class="history-section mb-5">
    <h2 class="h3 mb-4">Our History</h2>
    <p>Established in 1985, the College of Engineering Z Library has grown from a small departmental collection to a comprehensive engineering library serving over 5,000 students and faculty members. Our collection includes specialized engineering resources, technical journals, and industry standards.</p>
</section>

<section class="team-section mb-5">
    <h2 class="h3 mb-4">Our Team</h2>
    <div class="librarian-profile mb-4">
        <h3 class="h4">Head Librarian</h3>
        <div class="row align-items-center">
            <div class="col-md-3">
                <img src="/public/images/staff/head-librarian.jpg" alt="Head Librarian" class="img-fluid rounded">
            </div>
            <div class="col-md-9">
                <h4 class="h5">Dr. Sarah Johnson</h4>
                <p>Ph.D. in Library Science with 15 years of experience in academic libraries. Specializes in engineering information resources and digital library management.</p>
            </div>
        </div>
    </div>
    <div class="library-staff">
        <h3 class="h4 mb-3">Library Staff</h3>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="staff-card">
                    <h4 class="h5">Technical Services Librarian</h4>
                    <p>Manages our digital resources, databases, and online catalogs.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="staff-card">
                    <h4 class="h5">Reference Librarian</h4>
                    <p>Provides research assistance and information literacy instruction.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="staff-card">
                    <h4 class="h5">Circulation Manager</h4>
                    <p>Oversees lending services and maintains library collections.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="staff-card">
                    <h4 class="h5">Digital Resources Specialist</h4>
                    <p>Maintains e-resources and provides technical support.</p>
                </div>
            </div>
        </div>
    </div>
</section>');

-- Services page content
INSERT INTO static_pages (page_name, slug, content) VALUES 
('Library Services', 'services', '<div class="services-overview mb-5">
    <p class="lead">Our library offers a comprehensive range of services designed to support your academic success and research needs.</p>
</div>

<div class="service-cards">
    <div class="row g-4">
        <!-- Research Assistance -->
        <div class="col-md-6 col-lg-4">
            <div class="service-card h-100">
                <div class="card-icon">
                    <i class="bi bi-search"></i>
                </div>
                <h3 class="h4">Research Assistance</h3>
                <p>Get expert help with:</p>
                <ul class="service-list">
                    <li>Research strategies</li>
                    <li>Database searches</li>
                    <li>Citation management</li>
                    <li>Literature reviews</li>
                </ul>
                <button class="btn btn-outline-primary mt-auto" data-bs-toggle="modal" data-bs-target="#researchModal">Learn More</button>
            </div>
        </div>

        <!-- Information Literacy -->
        <div class="col-md-6 col-lg-4">
            <div class="service-card h-100">
                <div class="card-icon">
                    <i class="bi bi-book"></i>
                </div>
                <h3 class="h4">Information Literacy</h3>
                <p>Develop essential skills:</p>
                <ul class="service-list">
                    <li>Database navigation</li>
                    <li>Online research tools</li>
                    <li>Source evaluation</li>
                    <li>Academic integrity</li>
                </ul>
                <button class="btn btn-outline-primary mt-auto" data-bs-toggle="modal" data-bs-target="#literacyModal">Learn More</button>
            </div>
        </div>

        <!-- Digital Resources -->
        <div class="col-md-6 col-lg-4">
            <div class="service-card h-100">
                <div class="card-icon">
                    <i class="bi bi-laptop"></i>
                </div>
                <h3 class="h4">Digital Resources</h3>
                <p>Access anywhere:</p>
                <ul class="service-list">
                    <li>E-books collection</li>
                    <li>Online journals</li>
                    <li>Research databases</li>
                    <li>Digital archives</li>
                </ul>
                <button class="btn btn-outline-primary mt-auto" data-bs-toggle="modal" data-bs-target="#digitalModal">Learn More</button>
            </div>
        </div>

        <!-- Study Spaces -->
        <div class="col-md-6 col-lg-4">
            <div class="service-card h-100">
                <div class="card-icon">
                    <i class="bi bi-people"></i>
                </div>
                <h3 class="h4">Study Spaces</h3>
                <p>Collaborative areas:</p>
                <ul class="service-list">
                    <li>Group study rooms</li>
                    <li>Quiet study zones</li>
                    <li>Computer labs</li>
                    <li>Discussion areas</li>
                </ul>
                <button class="btn btn-outline-primary mt-auto" data-bs-toggle="modal" data-bs-target="#spacesModal">Learn More</button>
            </div>
        </div>

        <!-- Technology Support -->
        <div class="col-md-6 col-lg-4">
            <div class="service-card h-100">
                <div class="card-icon">
                    <i class="bi bi-gear"></i>
                </div>
                <h3 class="h4">Technology Support</h3>
                <p>Tech resources:</p>
                <ul class="service-list">
                    <li>Wi-Fi access</li>
                    <li>Printing services</li>
                    <li>Scanner access</li>
                    <li>Software support</li>
                </ul>
                <button class="btn btn-outline-primary mt-auto" data-bs-toggle="modal" data-bs-target="#techModal">Learn More</button>
            </div>
        </div>

        <!-- Document Services -->
        <div class="col-md-6 col-lg-4">
            <div class="service-card h-100">
                <div class="card-icon">
                    <i class="bi bi-file-text"></i>
                </div>
                <h3 class="h4">Document Services</h3>
                <p>Resource access:</p>
                <ul class="service-list">
                    <li>Interlibrary loans</li>
                    <li>Document delivery</li>
                    <li>Reference scanning</li>
                    <li>Print resources</li>
                </ul>
                <button class="btn btn-outline-primary mt-auto" data-bs-toggle="modal" data-bs-target="#docModal">Learn More</button>
            </div>
        </div>
    </div>
</div>');


