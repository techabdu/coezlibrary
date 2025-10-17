# Library Website Development Plan
**Project:** College Library Website (MVP)  
**Tech Stack:** HTML, CSS, Bootstrap 5, PHP MVC, MySQL  
**Version Control:** Git + GitHub

---

## 🎯 General Rules for LLM Assistance

### Code Quality Standards
1. **Always write clean, commented code** - Every function/method should have a docblock comment
2. **Follow PHP PSR-12 coding standards** - Consistent formatting and naming conventions
3. **Use prepared statements** - NEVER use direct SQL queries (prevent SQL injection)
4. **Sanitize ALL user inputs** - Use `htmlspecialchars()`, `filter_var()`, etc.
5. **Responsive design first** - Test all layouts on mobile, tablet, and desktop views
6. **Semantic HTML** - Use proper HTML5 tags (`<header>`, `<nav>`, `<main>`, `<article>`, etc.)
7. **Bootstrap classes over custom CSS** - Use Bootstrap utilities first, custom CSS only when necessary
8. **Error handling** - Always implement try-catch blocks and user-friendly error messages
9. **No hardcoded values** - Use configuration files for database credentials, paths, etc.
10. **Test after every feature** - Verify functionality works before moving to next step

### Git Workflow
- **Commit after EVERY completed step** with descriptive messages
- **Format:** `git commit -m "Step X.Y: Brief description of what was done"`
- **Example:** `git commit -m "Step 1.2: Created database schema and initial tables"`
- **Push to GitHub after each major checkpoint**

### File Naming Conventions
- **Controllers:** `PascalCase` - `HomeController.php`, `ResourceController.php`
- **Models:** `PascalCase` - `Announcement.php`, `Database.php`
- **Views:** `lowercase_with_underscores` - `home.php`, `digital_resources.php`
- **CSS/JS files:** `kebab-case` - `main-style.css`, `admin-dashboard.js`

### When Stuck
1. Check the document reference
2. Review the database schema in this file
3. Verify Bootstrap 5 documentation for components
4. Test in browser with developer console open
5. Ask for clarification with specific error messages

---

## 📊 Database Schema Reference

```sql
-- Use this schema as reference throughout development

-- 1. announcements
CREATE TABLE announcements (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    date_posted DATE NOT NULL,
    is_active BOOLEAN DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. databases (external links)
CREATE TABLE databases (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    url VARCHAR(500) NOT NULL,
    category VARCHAR(100),
    icon_path VARCHAR(255),
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. digital_resources (e-books and e-journals)
CREATE TABLE digital_resources (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255),
    category ENUM('ebook', 'ejournal') NOT NULL,
    file_path VARCHAR(500),
    thumbnail_path VARCHAR(255),
    description TEXT,
    upload_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    downloads_count INT DEFAULT 0
);

-- 4. static_pages
CREATE TABLE static_pages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    page_name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) UNIQUE NOT NULL,
    content TEXT NOT NULL,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 5. carousel_images
CREATE TABLE carousel_images (
    id INT PRIMARY KEY AUTO_INCREMENT,
    image_path VARCHAR(255) NOT NULL,
    caption VARCHAR(255),
    display_order INT DEFAULT 0,
    is_active BOOLEAN DEFAULT 1
);

-- 6. faq
CREATE TABLE faq (
    id INT PRIMARY KEY AUTO_INCREMENT,
    question TEXT NOT NULL,
    answer TEXT NOT NULL,
    category VARCHAR(100),
    display_order INT DEFAULT 0
);

-- 7. contact_submissions (Ask a Librarian)
CREATE TABLE contact_submissions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    status ENUM('pending', 'responded', 'archived') DEFAULT 'pending',
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 8. library_info (singleton table)
CREATE TABLE library_info (
    id INT PRIMARY KEY DEFAULT 1,
    hours TEXT,
    location VARCHAR(255),
    phone VARCHAR(50),
    email VARCHAR(255),
    address TEXT
);

-- 9. users (admin authentication)
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin', 'librarian') DEFAULT 'librarian',
    email VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

---

## 📁 Project Structure Reference

```
library-website/
├── index.php                      # Entry point (front controller)
├── config/
│   ├── database.php              # DB connection config
│   └── config.php                # General app config
├── app/
│   ├── controllers/
│   │   ├── HomeController.php
│   │   ├── ResourceController.php
│   │   ├── PageController.php
│   │   ├── ContactController.php
│   │   └── AdminController.php
│   ├── models/
│   │   ├── Announcement.php
│   │   ├── Database.php
│   │   ├── DigitalResource.php
│   │   ├── StaticPage.php
│   │   ├── FAQ.php
│   │   ├── Contact.php
│   │   ├── LibraryInfo.php
│   │   └── User.php
│   └── views/
│       ├── layouts/
│       │   ├── header.php
│       │   ├── footer.php
│       │   └── navigation.php
│       ├── home.php
│       ├── databases.php
│       ├── digital_resources.php
│       ├── ebooks.php
│       ├── ejournals.php
│       ├── about.php
│       ├── services.php
│       ├── policies.php
│       ├── faq.php
│       ├── contact.php
│       └── admin/
│           ├── dashboard.php
│           ├── login.php
│           ├── manage_announcements.php
│           ├── manage_databases.php
│           ├── manage_resources.php
│           ├── manage_pages.php
│           └── view_contacts.php
├── public/
│   ├── css/
│   │   └── style.css
│   ├── js/
│   │   └── main.js
│   ├── images/
│   │   └── carousel/
│   └── uploads/
│       ├── ebooks/
│       ├── ejournals/
│       └── thumbnails/
├── core/
│   ├── Router.php                # URL routing
│   ├── Controller.php            # Base controller class
│   └── Model.php                 # Base model class
└── .htaccess                     # URL rewriting
```

---

## ✅ Development Steps

### **PHASE 1: PROJECT SETUP & FOUNDATION**

#### Step 1.1: Initialize Project Structure
- [ ] Create all folders as per project structure above
- [ ] Create `.gitignore` file (ignore `/config/database.php`, `/public/uploads/*`, `.env`)
- [ ] Create README.md with project description
- [ ] **Git commit:** "Step 1.1: Initialized project structure"

#### Step 1.2: Database Setup
- [ ] Create MySQL database named `library_db`
- [ ] Execute all table creation SQL from schema reference above
- [ ] Verify all 9 tables are created successfully
- [ ] Insert sample data into `library_info` table (hours, location, etc.)
- [ ] Create initial admin user (username: `admin`, 'password' hashed password)
- [ ] **Git commit:** "Step 1.2: Created database schema and initial tables"

#### Step 1.3: Configuration Files
- [ ] Create `config/database.php` with PDO connection
  - Host, database name, username, password constants
  - PDO error mode set to exception
  - Character set UTF-8
- [ ] Create `config/config.php` with app-wide constants
  - Base URL, site title, paths to uploads, etc.
- [ ] Test database connection (create test file, then delete)
- [ ] **Git commit:** "Step 1.3: Created configuration files"

#### Step 1.4: Core MVC Classes
- [ ] Create `core/Model.php` - Base model class with DB connection
- [ ] Create `core/Controller.php` - Base controller class with view loader
- [ ] Create `core/Router.php` - URL routing logic
  - Parse URLs, extract controller/method/params
  - Handle default routes (home page)
- [ ] **Git commit:** "Step 1.4: Built core MVC framework classes"

#### Step 1.5: Front Controller
- [ ] Create `index.php` as entry point
  - Include config files
  - Autoload classes (or require them)
  - Initialize router and dispatch requests
- [ ] Create `.htaccess` for URL rewriting
  - Redirect all requests to index.php
  - Remove .php extensions
- [ ] Test routing with a simple "Hello World" controller
- [ ] **Git commit:** "Step 1.5: Implemented front controller and routing"

**🔍 CHECKPOINT 1:** Test that routing works - visiting `/home` should trigger HomeController

---

### **PHASE 2: FRONTEND LAYOUT & SHARED COMPONENTS**

#### Step 2.1: Bootstrap Integration
- [ ] Create `app/views/layouts/header.php`
  - Include Bootstrap 5 CSS from CDN
  - Include custom `style.css`
  - Add viewport meta tag for responsiveness
  - Set dynamic page title
- [ ] Create `app/views/layouts/footer.php`
  - Include Bootstrap JS bundle from CDN
  - Include custom `main.js`
  - Add copyright and contact info
- [ ] Test header/footer on blank page
- [ ] **Git commit:** "Step 2.1: Created header and footer layouts with Bootstrap"

#### Step 2.2: Navigation Bar
- [ ] Create `app/views/layouts/navigation.php`
  - Bootstrap navbar component
  - Logo/site title on left
  - Menu items: Home, Resources (dropdown), About, Services, FAQ, Contact
  - Resources dropdown: Databases, E-Books, E-Journals
  - Responsive hamburger menu for mobile
  - Active state highlighting current page
- [ ] Add CSS for navbar styling in `public/css/style.css`
- [ ] Test responsiveness on mobile/tablet/desktop
- [ ] **Git commit:** "Step 2.2: Built responsive navigation bar"

#### Step 2.3: Base Styles
- [ ] Create `public/css/style.css` with:
  - CSS variables for color scheme (primary, secondary, accent colors)
  - Typography styles (headings, body text)
  - Utility classes (margins, padding, shadows)
  - Button styles override/extension
  - Card styles for consistent UI
  - Footer styling
- [ ] Ensure mobile-first approach
- [ ] **Git commit:** "Step 2.3: Added base CSS styles and variables"

**🔍 CHECKPOINT 2:** Navigation should work, look good on all devices, dropdown should function

---

### **PHASE 3: HOMEPAGE DEVELOPMENT**

#### Step 3.1: HomeController and Model Setup
- [ ] Create `app/controllers/HomeController.php`
  - index() method to load homepage
  - Load data from models (announcements, carousel images, library info)
- [ ] Create `app/models/Announcement.php`
  - getActiveAnnouncements() method - returns latest 5 active announcements
- [ ] Create `app/models/LibraryInfo.php`
  - getLibraryInfo() method - returns singleton library details
- [ ] Create `app/models/CarouselImage.php` (for later)
  - getActiveImages() method - returns active images ordered by display_order
- [ ] **Git commit:** "Step 3.1: Created HomeController and related models"

#### Step 3.2: Homepage View - Hero Section
- [ ] Create `app/views/home.php`
- [ ] Add Bootstrap carousel component
  - Display library images from database (use placeholder images for now)
  - Auto-sliding with indicators and controls
  - Captions with image descriptions
  - Minimum height for visual impact
- [ ] Test carousel functionality (sliding, indicators)
- [ ] **Git commit:** "Step 3.2: Implemented homepage hero carousel"

#### Step 3.3: Homepage - Library Info Section
- [ ] Add prominent section below carousel displaying:
  - Library hours in a card/box
  - Location with map icon
  - Contact phone/email with icons (use Bootstrap icons or Font Awesome)
- [ ] Use Bootstrap grid: 3 columns on desktop, stacked on mobile
- [ ] Add hover effects on info cards
- [ ] **Git commit:** "Step 3.3: Added library information section to homepage"

#### Step 3.4: Homepage - Quick Links Section
- [ ] Create "Quick Access" section with large buttons/cards:
  - Databases
  - E-Books
  - E-Journals
  - FAQ
  - Ask a Librarian
- [ ] Use Bootstrap cards or buttons with icons
- [ ] Grid layout: 3 columns on desktop, 2 on tablet, 1 on mobile
- [ ] Link buttons to respective pages (routes)
- [ ] **Git commit:** "Step 3.4: Added quick links section to homepage"

#### Step 3.5: Homepage - Announcements Section
- [ ] Add "Latest News & Announcements" section
- [ ] Display last 3-5 announcements from database
  - Title, date, excerpt (first 150 characters)
- [ ] Use Bootstrap cards or list group
- [ ] Add "View All" link (for future announcements page)
- [ ] Style with alternating background or borders
- [ ] **Git commit:** "Step 3.5: Implemented announcements section with database integration"

**🔍 CHECKPOINT 3:** Homepage should be fully functional, responsive, with live data from database

---

### **PHASE 4: STATIC PAGES**

#### Step 4.1: PageController Setup
- [ ] Create `app/controllers/PageController.php`
- [ ] Add methods: about(), services(), policies()
- [ ] Create `app/models/StaticPage.php`
  - getPageBySlug($slug) method - returns page content
- [ ] **Git commit:** "Step 4.1: Created PageController and StaticPage model"

#### Step 4.2: About Us Page
- [ ] Create `app/views/about.php`
- [ ] Sections:
  - Library mission statement
  - Brief history
  - About the librarian (with photo placeholder)
  - About library staff (cards with roles)
- [ ] Fetch content from `static_pages` table (slug: 'about-us')
- [ ] Add breadcrumb navigation
- [ ] Responsive layout with images
- [ ] **Git commit:** "Step 4.2: Built About Us page with dynamic content"

#### Step 4.3: Services Page
- [ ] Create `app/views/services.php`
- [ ] List all library services with descriptions:
  - Research Help
  - E-Library Access
  - Study Spaces
  - Reference Services
  - Interlibrary Loan (if applicable)
- [ ] Use icon + heading + description layout
- [ ] Fetch from database or hardcode (mark for later admin edit)
- [ ] Add breadcrumb navigation
- [ ] **Git commit:** "Step 4.3: Created Services page"

#### Step 4.4: Library Policies Page
- [ ] Create `app/views/policies.php`
- [ ] Sections with accordions or tabs:
  - Borrowing policies
  - Computer usage rules
  - Fines and fees
  - Conduct expectations
  - Membership information
- [ ] Use Bootstrap accordion component for collapsible sections
- [ ] Fetch content from `static_pages` table (slug: 'policies')
- [ ] Add breadcrumb navigation
- [ ] **Git commit:** "Step 4.4: Implemented Library Policies page with accordions"

#### Step 4.5: Seed Static Pages Content
- [ ] Insert initial content into `static_pages` table:
  - about-us page content
  - services page content
  - policies page content
- [ ] Write SQL insert statements or create seed script
- [ ] Test all static pages display correct content
- [ ] **Git commit:** "Step 4.5: Seeded static pages with initial content"

**🔍 CHECKPOINT 4:** All static pages (About, Services, Policies) should render correctly

---

### **PHASE 5: DATABASES PAGE (External Links)**

#### Step 5.1: ResourceController and Database Model
- [ ] Create `app/controllers/ResourceController.php`
- [ ] Add databases() method
- [ ] Create `app/models/Database.php`
  - getAllDatabases() method - returns all database links
  - getDatabasesByCategory($category) method
- [ ] **Git commit:** "Step 5.1: Created ResourceController and Database model"

#### Step 5.2: Databases View
- [ ] Create `app/views/databases.php`
- [ ] Page structure:
  - Page title and description
  - Optional category filter/tabs (All, Science, Humanities, Business, etc.)
  - Grid of database cards
- [ ] Each card displays:
  - Database name
  - Icon/logo (placeholder if none)
  - Brief description
  - External link button ("Access Database" - opens in new tab)
  - Category badge
- [ ] Use Bootstrap cards in grid layout
- [ ] Add breadcrumb navigation
- [ ] External links should have `target="_blank"` and `rel="noopener noreferrer"`
- [ ] **Git commit:** "Step 5.2: Built databases page with grid layout"

#### Step 5.3: Seed Database Links
- [ ] Insert sample database links into `databases` table:
  - EBSCOhost
  - DOAJ (Directory of Open Access Journals)
  - Science Direct
  - PubMed
  - JSTOR (or others relevant)
- [ ] Include name, description, URL, category for each
- [ ] Test that all links display correctly
- [ ] **Git commit:** "Step 5.3: Seeded databases table with sample data"

#### Step 5.4: Add Category Filtering (Optional Enhancement)
- [ ] Add category tabs/pills at top of databases page
- [ ] JavaScript to filter cards by category without page reload
- [ ] Or implement server-side filtering with URL parameters
- [ ] Test filtering functionality
- [ ] **Git commit:** "Step 5.4: Added category filtering to databases page"

**🔍 CHECKPOINT 5:** Databases page should display all external links, filter by category

---

### **PHASE 6: DIGITAL RESOURCES (E-Books & E-Journals)**

#### Step 6.1: DigitalResource Model
- [ ] Create `app/models/DigitalResource.php`
- [ ] Methods:
  - getAllEBooks() - returns all ebooks
  - getAllEJournals() - returns all ejournals
  - getResourceById($id) - returns single resource
  - incrementDownloads($id) - tracks download count
  - **PLACEHOLDER:** uploadResource() method (mark as TODO for Phase 8)
- [ ] **Git commit:** "Step 6.1: Created DigitalResource model"

#### Step 6.2: E-Books Page
- [ ] Add ebooks() method to ResourceController
- [ ] Create `app/views/ebooks.php`
- [ ] Page structure:
  - Page title "E-Books Collection"
  - Search/filter bar (by title or author - optional)
  - Grid of e-book cards
- [ ] Each card shows:
  - Thumbnail image (placeholder if none)
  - Title
  - Author
  - Brief description
  - Download button (downloads file or shows placeholder message)
  - Download count badge
- [ ] Add breadcrumb navigation
- [ ] **PLACEHOLDER:** Display message "E-book uploads coming soon" if table is empty
- [ ] **Git commit:** "Step 6.2: Created E-Books page with placeholder for uploads"

#### Step 6.3: E-Journals Page
- [ ] Add ejournals() method to ResourceController
- [ ] Create `app/views/ejournals.php`
- [ ] Similar structure to e-books page:
  - Page title "E-Journals Collection"
  - Grid of journal cards
  - Thumbnail, title, author, description, download button
- [ ] Add breadcrumb navigation
- [ ] **PLACEHOLDER:** Display message if no journals uploaded yet
- [ ] **Git commit:** "Step 6.3: Created E-Journals page with placeholder"

#### Step 6.4: Combined Digital Resources Page (Optional)
- [ ] Add digitalResources() method to ResourceController
- [ ] Create `app/views/digital_resources.php`
- [ ] Tabs to switch between E-Books and E-Journals
- [ ] Or single page with category badges
- [ ] User can toggle view between both types
- [ ] **Git commit:** "Step 6.4: Created unified digital resources view"

#### Step 6.5: Download Tracking (Placeholder Functionality)
- [ ] Implement download() method in ResourceController
  - Accepts resource ID
  - Increments downloads_count in database
  - **PLACEHOLDER:** Returns message instead of actual file (files not uploaded yet)
- [ ] Link download buttons to download route
- [ ] Test download counter increments
- [ ] **Git commit:** "Step 6.5: Implemented download tracking (placeholder)"

**🔍 CHECKPOINT 6:** E-Books and E-Journals pages display correctly, download tracking works

---

### **PHASE 7: FAQ PAGE**

#### Step 7.1: FAQ Model and Controller
- [ ] Add faq() method to PageController
- [ ] Create `app/models/FAQ.php`
  - getAllFAQs() method - returns all FAQs ordered by display_order
  - getFAQsByCategory($category) method
- [ ] **Git commit:** "Step 7.1: Created FAQ model and controller method"

#### Step 7.2: FAQ Page View
- [ ] Create `app/views/faq.php`
- [ ] Page structure:
  - Page title "Frequently Asked Questions"
  - Optional category tabs (General, Borrowing, Digital Resources, etc.)
  - Bootstrap accordion for questions
- [ ] Each FAQ item in accordion:
  - Question as accordion header
  - Answer as accordion body (collapsible)
- [ ] Add breadcrumb navigation
- [ ] **Git commit:** "Step 7.2: Built FAQ page with accordion UI"

#### Step 7.3: Seed FAQ Data
- [ ] Insert sample FAQs into `faq` table:
  - "How do I access the library databases?" → Answer about login/access
  - "What are the library hours?" → Answer with hours
  - "How do I download e-books?" → Step-by-step guide
  - "What are the fines for late returns?" → Fines info
  - "Can I request a book purchase?" → Process description
  - Add 10-15 common questions
- [ ] Categorize FAQs appropriately
- [ ] Test FAQ page displays all questions
- [ ] **Git commit:** "Step 7.3: Seeded FAQ database with sample questions"

#### Step 7.4: FAQ Search (Optional Enhancement)
- [ ] Add search bar at top of FAQ page
- [ ] JavaScript filter to show/hide accordion items based on search
- [ ] Highlight matching keywords
- [ ] Test search functionality
- [ ] **Git commit:** "Step 7.4: Added search functionality to FAQ page"

**🔍 CHECKPOINT 7:** FAQ page displays all questions, accordion works smoothly

---

### **PHASE 8: CONTACT / ASK A LIBRARIAN**

#### Step 8.1: Contact Model and Controller
- [ ] Create `app/controllers/ContactController.php`
- [ ] Methods:
  - index() - displays contact form
  - submit() - handles form submission
- [ ] Create `app/models/Contact.php`
  - saveSubmission($data) - inserts form data into database
  - getAllSubmissions() - for admin panel later
- [ ] **Git commit:** "Step 8.1: Created ContactController and Contact model"

#### Step 8.2: Contact Page View
- [ ] Create `app/views/contact.php`
- [ ] Page structure:
  - Page title "Contact Us / Ask a Librarian"
  - Library contact information (phone, email, address) from database
  - Contact form with fields:
    - Name (required)
    - Email (required, validated)
    - Subject (required)
    - Message (required, textarea)
    - Submit button
- [ ] Use Bootstrap form classes for styling
- [ ] Add form validation (HTML5 required attributes)
- [ ] Add breadcrumb navigation
- [ ] **Git commit:** "Step 8.2: Built contact page with form"

#### Step 8.3: Form Submission Handling
- [ ] Implement submit() method in ContactController:
  - Validate all inputs server-side
  - Sanitize data (htmlspecialchars, trim)
  - Check for valid email format
  - Insert into `contact_submissions` table
  - Set status as 'pending'
  - Display success message to user
  - Redirect back to contact page with flash message
- [ ] Test form submission
- [ ] Verify data saved in database
- [ ] **Git commit:** "Step 8.3: Implemented form submission and validation"

#### Step 8.4: Form Feedback Messages
- [ ] Create session-based flash message system
  - Success message: "Your message has been sent! We'll respond within 24 hours."
  - Error messages for validation failures
- [ ] Display messages with Bootstrap alerts
- [ ] Auto-dismiss after few seconds (optional JavaScript)
- [ ] Test both success and error scenarios
- [ ] **Git commit:** "Step 8.4: Added flash messaging for form feedback"

#### Step 8.5: Email Notification (Optional Enhancement)
- [ ] Implement email notification when form is submitted
  - Use PHP `mail()` function or PHPMailer library
  - Send notification to library email
  - Include submission details
- [ ] Test email delivery (may need SMTP configuration)
- [ ] **Git commit:** "Step 8.5: Added email notifications for contact form" (if implemented)

**🔍 CHECKPOINT 8:** Contact form submits successfully, data saved, user sees confirmation

---

### **PHASE 9: ADMIN PANEL - AUTHENTICATION**

#### Step 9.1: User Model
- [ ] Create `app/models/User.php`
- [ ] Methods:
  - getUserByUsername($username) - returns user data
  - verifyPassword($password, $hash) - checks password
  - hashPassword($password) - creates password hash (for registration later)
- [ ] **Git commit:** "Step 9.1: Created User model for authentication"

#### Step 9.2: Admin Login Page
- [ ] Create `app/controllers/AdminController.php`
- [ ] Methods:
  - login() - displays login form
  - authenticate() - handles login submission
  - logout() - destroys session
  - dashboard() - displays admin dashboard (requires authentication)
- [ ] Create `app/views/admin/login.php`
  - Simple centered login form
  - Username field
  - Password field
  - Submit button
  - Bootstrap styling
- [ ] **Git commit:** "Step 9.2: Created admin login page"

#### Step 9.3: Authentication Logic
- [ ] Implement authenticate() method:
  - Retrieve username and password from POST
  - Query user from database
  - Verify password with password_verify()
  - If valid: create session, redirect to dashboard
  - If invalid: show error message, redirect back to login
- [ ] Start session in index.php or config
- [ ] Store user ID and role in session
- [ ] **Git commit:** "Step 9.3: Implemented login authentication"

#### Step 9.4: Session Protection Middleware
- [ ] Create helper function `requireAuth()`:
  - Check if user session exists
  - If not, redirect to login page
  - If yes, allow access
- [ ] Add requireAuth() check to all admin controller methods (except login)
- [ ] Test: accessing admin pages without login should redirect to login
- [ ] **Git commit:** "Step 9.4: Added authentication middleware"

#### Step 9.5: Logout Functionality
- [ ] Implement logout() method:
  - Destroy session variables
  - Redirect to login page with message
- [ ] Add logout link in admin dashboard navigation
- [ ] Test logout functionality
- [ ] **Git commit:** "Step 9.5: Implemented logout functionality"

**🔍 CHECKPOINT 9:** Admin login/logout works, unauthorized access is blocked

---

### **PHASE 10: ADMIN DASHBOARD**

#### Step 10.1: Dashboard Layout
- [ ] Create `app/views/admin/dashboard.php`
- [ ] Admin navigation sidebar or top nav:
  - Dashboard (overview)
  - Manage Announcements
  - Manage Databases
  - Manage Digital Resources (placeholder)
  - Manage Pages
  - View Contact Submissions
  - Logout
- [ ] Main content area with welcome message
- [ ] Use Bootstrap admin template or custom layout
- [ ] Responsive for tablet/mobile
- [ ] **Git commit:** "Step 10.1: Created admin dashboard layout"

#### Step 10.2: Dashboard Overview Widgets
- [ ] Add statistics cards to dashboard:
  - Total databases count
  - Total e-books count
  - Total e-journals count
  - Pending contact submissions count
  - Total announcements count
- [ ] Use Bootstrap cards in grid
- [ ] Fetch counts from respective models
- [ ] Add icons to each stat card
- [ ] **Git commit:** "Step 10.2: Added dashboard statistics widgets"

#### Step 10.3: Recent Activity Section
- [ ] Display recent activity on dashboard:
  - Last 5 contact submissions (name, subject, date)
  - Last 3 announcements posted
- [ ] Link to respective management pages
- [ ] Use Bootstrap tables or list groups
- [ ] **Git commit:** "Step 10.3: Added recent activity to dashboard"

**🔍 CHECKPOINT 10:** Admin dashboard displays correctly, navigation works

---

### **PHASE 11: ADMIN - MANAGE ANNOUNCEMENTS**

#### Step 11.1: Announcements Management Page
- [ ] Add manageAnnouncements() method to AdminController
- [ ] Create `app/views/admin/manage_announcements.php`
- [ ] Page structure:
  - "Add New Announcement" button (opens modal or goes to form page)
  - Table/list of existing announcements:
    - Title, Date Posted, Status (Active/Inactive), Actions (Edit, Delete, Toggle Status)
- [ ] Use Bootstrap table with action buttons
- [ ] **Git commit:** "Step 11.1: Created announcements management page"

#### Step 11.2: Add Announcement Functionality
- [ ] Add createAnnouncement() and storeAnnouncement() methods to AdminController
- [ ] Create form (modal or separate page) with fields:
  - Title (required)
  - Content (textarea, required)
  - Date Posted (auto-populate with today's date)
  - Active checkbox
- [ ] Add create() method to Announcement model:
  - Insert new announcement into database
- [ ] Test adding new announcement
- [ ] Verify it appears on homepage
- [ ] **Git commit:** "Step 11.2: Implemented add announcement functionality"

#### Step 11.3: Edit Announcement Functionality
- [ ] Add editAnnouncement($id) and updateAnnouncement($id) methods to AdminController
- [ ] Pre-fill form with existing announcement data
- [ ] Add update() method to Announcement model
- [ ] Test editing announcement
- [ ] Verify changes reflect on frontend
- [ ] **Git commit:** "Step 11.3: Implemented edit announcement functionality"

#### Step 11.4: Delete Announcement Functionality
- [ ] Add deleteAnnouncement($id) method to AdminController
- [ ] Add JavaScript confirmation dialog before deletion
- [ ] Add delete() method to Announcement model
- [ ] Test deleting announcement
- [ ] Verify it's removed from homepage
- [ ] **Git commit:** "Step 11.4: Implemented delete announcement functionality"

#### Step 11.5: Toggle Announcement Status
- [ ] Add toggleStatus($id) method to AdminController
- [ ] Quick toggle button to activate/deactivate without full edit
- [ ] Update is_active field in database
- [ ] Test toggling status
- [ ] Verify only active announcements show on homepage
- [ ] **Git commit:** "Step 11.5: Added toggle status for announcements"

**🔍 CHECKPOINT 11:** Admin can create, edit, delete, and toggle announcements

---

### **PHASE 12: ADMIN - MANAGE DATABASES**

#### Step 12.1: Databases Management Page
- [ ] Add manageDatabases() method to AdminController
- [ ] Create `app/views/admin/manage_databases.php`
- [ ] Page structure:
  - "Add New Database" button
  - Table of existing databases:
    - Name, Category, URL, Actions (Edit, Delete)
- [ ] Use Bootstrap table
- [ ] **Git commit:** "Step 12.1: Created databases management page"

#### Step 12.2: Add Database Functionality
- [ ] Add createDatabase() and storeDatabase() methods to AdminController
- [ ] Create form with fields:
  - Name (required)
  - Description (textarea)
  - URL (required, validate URL format)
  - Category (dropdown: Science, Humanities, Business, General, etc.)
  - Icon upload (optional - placeholder for now)
- [ ] Add create() method to Database model
- [ ] Test adding new database link
- [ ] Verify it appears on databases page
- [ ] **Git commit:** "Step 12.2: Implemented add database functionality"

#### Step 12.3: Edit Database Functionality
- [ ] Add editDatabase($id) and updateDatabase($id) methods
- [ ] Pre-fill form with existing database data
- [ ] Add update() method to Database model
- [ ] Test editing database
- [ ] Verify changes on frontend
- [ ] **Git commit:** "Step 12.3: Implemented edit database functionality"

#### Step 12.4: Delete Database Functionality
- [ ] Add deleteDatabase($id) method to AdminController
- [ ] Add JavaScript confirmation dialog
- [ ] Add delete() method to Database model
- [ ] Test deleting database
- [ ] Verify removal from databases page
- [ ] **Git commit:** "Step 12.4: Implemented delete database functionality"

**🔍 CHECKPOINT 12:** Admin can fully manage database links (CRUD operations)

---

### **PHASE 13: ADMIN - MANAGE STATIC PAGES**

#### Step 13.1: Pages Management Interface
- [ ] Add managePages() method to AdminController
- [ ] Create `app/views/admin/manage_pages.php`
- [ ] List all static pages (About Us, Services, Policies)
- [ ] Action buttons: Edit only (no delete for core pages)
- [ ] Use Bootstrap table or cards
- [ ] **Git commit:** "Step 13.1: Created static pages management page"

#### Step 13.2: Edit Static Page Content
- [ ] Add editPage($id) and updatePage($id) methods to AdminController
- [ ] Create form with:
  - Page name (read-only)
  - Content (rich text editor or large textarea)
  - Last updated timestamp (auto-update)
- [ ] Add update() method to StaticPage model
- [ ] Test editing page content
- [ ] Verify changes on frontend pages
- [ ] **Git commit:** "Step 13.2: Implemented edit static page functionality"

#### Step 13.3: Rich Text Editor Integration (Optional)
- [ ] Integrate TinyMCE or CKEditor for WYSIWYG editing
- [ ] Include CDN script in admin page edit form
- [ ] Configure toolbar options (bold, italic, lists, links)
- [ ] Test rich text formatting
- [ ] Ensure HTML renders correctly on frontend
- [ ] **Git commit:** "Step 13.3: Added WYSIWYG editor for page content"

**🔍 CHECKPOINT 13:** Admin can edit static page content, changes reflect on frontend

---

### **PHASE 14: ADMIN - VIEW CONTACT SUBMISSIONS**

#### Step 14.1: Contact Submissions Page
- [ ] Add viewContacts() method to AdminController
- [ ] Create `app/views/admin/view_contacts.php`
- [ ] Display table of all contact submissions:
  - Name, Email, Subject, Date Submitted, Status, Actions (View, Mark as Responded, Archive)
- [ ] Color-code status (pending=yellow, responded=green, archived=gray)
- [ ] Use Bootstrap table with pagination (if many submissions)
- [ ] **Git commit:** "Step 14.1: Created contact submissions viewing page"

#### Step 14.2: View Individual Submission
- [ ] Add viewContactDetail($id) method to AdminController
- [ ] Display full message in modal or separate page:
  - Name, Email, Subject
  - Full message text
  - Submission timestamp
  - Current status
- [ ] Add "Reply via Email" button (opens email client with mailto:)
- [ ] **Git commit:** "Step 14.2: Implemented view individual contact submission"

#### Step 14.3: Update Submission Status
- [ ] Add updateContactStatus($id, $status) method to AdminController
- [ ] Buttons to mark as: Responded, Archive
- [ ] Add updateStatus() method to Contact model
- [ ] Test status changes
- [ ] Verify status updates in table
- [ ] **Git commit:** "Step 14.3: Added status update for contact submissions"

#### Step 14.4: Filter/Search Submissions
- [ ] Add filter dropdown: All, Pending, Responded, Archived
- [ ] Add search bar to search by name or subject
- [ ] Implement filtering in Contact model
- [ ] Test filtering functionality
- [ ] **Git commit:** "Step 14.4: Added filtering to contact submissions"

**🔍 CHECKPOINT 14:** Admin can view, respond to, and manage all contact submissions

---

### **PHASE 15: ADMIN - MANAGE CAROUSEL & LIBRARY INFO**

#### Step 15.1: Manage Carousel Images
- [ ] Add manageCarousel() method to AdminController
- [ ] Create `app/views/admin/manage_carousel.php`
- [ ] Display list of carousel images:
  - Thumbnail preview, Caption, Display Order, Status, Actions
- [ ] Add "Upload New Image" button
- [ ] **Git commit:** "Step 15.1: Created carousel management page"

#### Step 15.2: Upload Carousel Image
- [ ] Add uploadCarouselImage() method to AdminController
- [ ] Create form with:
  - Image file upload (accept only jpg, png, gif)
  - Caption (optional)
  - Display order (number)
  - Active checkbox
- [ ] Validate file type and size (max 2MB)
- [ ] Save image to `/public/images/carousel/`
- [ ] Insert record into `carousel_images` table
- [ ] Test uploading image
- [ ] Verify it appears on homepage carousel
- [ ] **Git commit:** "Step 15.2: Implemented carousel image upload"

#### Step 15.3: Edit/Delete Carousel Images
- [ ] Add editCarousel($id) and deleteCarousel($id) methods
- [ ] Edit: update caption, display order, status
- [ ] Delete: remove from database and file system
- [ ] Add reordering functionality (drag-drop or number input)
- [ ] Test editing and deleting
- [ ] **Git commit:** "Step 15.3: Added edit and delete for carousel images"

#### Step 15.4: Manage Library Information
- [ ] Add manageLibraryInfo() method to AdminController
- [ ] Create form to edit:
  - Library hours (textarea)
  - Location
  - Phone number
  - Email
  - Address
- [ ] Update singleton record in `library_info` table
- [ ] Test updating library info
- [ ] Verify changes on homepage
- [ ] **Git commit:** "Step 15.4: Implemented library info management"

**🔍 CHECKPOINT 15:** Admin can manage carousel and library information

---

### **PHASE 16: ADMIN - MANAGE FAQ**

#### Step 16.1: FAQ Management Page
- [ ] Add manageFAQ() method to AdminController
- [ ] Create `app/views/admin/manage_faq.php`
- [ ] Display table of all FAQs:
  - Question (truncated), Category, Display Order, Actions
- [ ] "Add New FAQ" button
- [ ] **Git commit:** "Step 16.1: Created FAQ management page"

#### Step 16.2: Add FAQ Functionality
- [ ] Add createFAQ() and storeFAQ() methods
- [ ] Create form with fields:
  - Question (required)
  - Answer (textarea, required)
  - Category (dropdown)
  - Display order (number)
- [ ] Add create() method to FAQ model
- [ ] Test adding FAQ
- [ ] Verify on FAQ page
- [ ] **Git commit:** "Step 16.2: Implemented add FAQ functionality"

#### Step 16.3: Edit/Delete FAQ
- [ ] Add editFAQ($id), updateFAQ($id), and deleteFAQ($id) methods
- [ ] Pre-fill form for editing
- [ ] Confirmation for deletion
- [ ] Test editing and deleting FAQs
- [ ] **Git commit:** "Step 16.3: Implemented edit and delete FAQ functionality"

#### Step 16.4: Reorder FAQs
- [ ] Add drag-and-drop reordering or up/down arrows
- [ ] Update display_order in database
- [ ] Test reordering
- [ ] Verify new order on FAQ page
- [ ] **Git commit:** "Step 16.4: Added FAQ reordering functionality"

**🔍 CHECKPOINT 16:** Admin can fully manage FAQ content

---

### **PHASE 17: DIGITAL RESOURCES UPLOAD (PLACEHOLDER IMPLEMENTATION)**

#### Step 17.1: Digital Resources Management Page
- [ ] Add manageResources() method to AdminController
- [ ] Create `app/views/admin/manage_resources.php`
- [ ] Display two tabs: E-Books and E-Journals
- [ ] Each tab shows table of resources with Actions
- [ ] **PLACEHOLDER:** "Upload New Resource" button (non-functional for now)
- [ ] Add prominent notice: "File upload functionality will be implemented in future phase"
- [ ] **Git commit:** "Step 17.1: Created digital resources management page (placeholder)"

#### Step 17.2: Manual Resource Entry (Temporary Workaround)
- [ ] Create form to manually add resource metadata (without file):
  - Title, Author, Category (ebook/ejournal)
  - Description
  - File path (manual text input - to be replaced later)
  - Thumbnail URL (optional)
- [ ] Save metadata to `digital_resources` table
- [ ] Add note: "File upload coming soon - enter file path manually for now"
- [ ] Test adding resource metadata
- [ ] **Git commit:** "Step 17.2: Added manual resource metadata entry (placeholder)"

#### Step 17.3: Edit/Delete Digital Resources
- [ ] Add editResource($id), updateResource($id), deleteResource($id) methods
- [ ] Edit form pre-filled with resource data
- [ ] Delete removes database record (file deletion to be added later)
- [ ] Test editing and deleting resources
- [ ] **Git commit:** "Step 17.3: Implemented edit/delete for digital resources (placeholder)"

**🔍 CHECKPOINT 17:** Digital resources can be managed (metadata only, file upload placeholder)

---

### **PHASE 18: POLISH & OPTIMIZATION**

#### Step 18.1: Form Validation Enhancement
- [ ] Review all forms (frontend and admin)
- [ ] Add client-side validation with JavaScript
- [ ] Add server-side validation to all controllers
- [ ] Display field-specific error messages
- [ ] Prevent duplicate submissions (disable button on submit)
- [ ] Test all forms with invalid data
- [ ] **Git commit:** "Step 18.1: Enhanced form validation across site"

#### Step 18.2: Error Pages
- [ ] Create `app/views/errors/404.php` (Page Not Found)
- [ ] Create `app/views/errors/403.php` (Forbidden/Unauthorized)
- [ ] Create `app/views/errors/500.php` (Server Error)
- [ ] Update router to handle 404 errors
- [ ] Style error pages with Bootstrap
- [ ] Add "Go Home" button
- [ ] Test accessing non-existent URLs
- [ ] **Git commit:** "Step 18.2: Created custom error pages"

#### Step 18.3: Security Hardening
- [ ] Review all SQL queries - ensure prepared statements used
- [ ] Add CSRF token protection to all forms
- [ ] Sanitize all user inputs with htmlspecialchars()
- [ ] Set secure session parameters (httponly, secure flags)
- [ ] Add rate limiting to contact form (prevent spam)
- [ ] Validate file uploads (type, size, extension)
- [ ] Add .htaccess rules to prevent directory listing
- [ ] Test for common vulnerabilities (SQL injection, XSS)
- [ ] **Git commit:** "Step 18.3: Implemented security hardening measures"

#### Step 18.4: Performance Optimization
- [ ] Optimize images (compress carousel images)
- [ ] Implement lazy loading for images
- [ ] Minify CSS and JavaScript files (create .min versions)
- [ ] Add browser caching headers in .htaccess
- [ ] Optimize database queries (add indexes if needed)
- [ ] Enable GZIP compression in .htaccess
- [ ] Test page load times with browser dev tools
- [ ] **Git commit:** "Step 18.4: Implemented performance optimizations"

#### Step 18.5: Accessibility Improvements
- [ ] Add alt text to all images
- [ ] Ensure proper heading hierarchy (h1, h2, h3)
- [ ] Add ARIA labels to interactive elements
- [ ] Ensure sufficient color contrast (check with tool)
- [ ] Make all functionality keyboard-accessible
- [ ] Test with screen reader (if possible)
- [ ] Add skip-to-content link
- [ ] **Git commit:** "Step 18.5: Enhanced accessibility features"

#### Step 18.6: Mobile Responsiveness Final Check
- [ ] Test every page on mobile device or emulator
- [ ] Check navigation menu on small screens
- [ ] Verify forms are usable on mobile
- [ ] Test carousel touch gestures
- [ ] Check table responsiveness (use Bootstrap responsive tables)
- [ ] Adjust font sizes for readability
- [ ] Test landscape and portrait orientations
- [ ] **Git commit:** "Step 18.6: Final mobile responsiveness adjustments"

#### Step 18.7: Cross-Browser Testing
- [ ] Test in Chrome
- [ ] Test in Firefox
- [ ] Test in Safari (if available)
- [ ] Test in Edge
- [ ] Fix any browser-specific issues
- [ ] Ensure consistent appearance across browsers
- [ ] **Git commit:** "Step 18.7: Cross-browser compatibility fixes"

**🔍 CHECKPOINT 18:** Site is polished, secure, accessible, and performant

---

### **PHASE 19: SEARCH FUNCTIONALITY**

#### Step 19.1: Global Search Controller
- [ ] Add search() method to a SearchController (create new controller)
- [ ] Accept search query parameter
- [ ] Search across:
  - Database names/descriptions
  - E-book titles/authors
  - E-journal titles/authors
  - FAQ questions/answers
  - Static page content
- [ ] Return combined results
- [ ] **Git commit:** "Step 19.1: Created search controller and logic"

#### Step 19.2: Search Bar in Navigation
- [ ] Add search form to navigation bar
- [ ] Input field with search icon
- [ ] Submit button or search on enter
- [ ] Mobile-friendly (collapsible on small screens)
- [ ] Style with Bootstrap
- [ ] **Git commit:** "Step 19.2: Added search bar to navigation"

#### Step 19.3: Search Results Page
- [ ] Create `app/views/search_results.php`
- [ ] Display search query at top
- [ ] Group results by type:
  - Databases (with links)
  - E-Books (with download buttons)
  - E-Journals (with download buttons)
  - FAQs (with links to FAQ page)
  - Pages (with links)
- [ ] Show result count for each category
- [ ] Display "No results found" if empty
- [ ] Highlight search terms in results (optional)
- [ ] **Git commit:** "Step 19.3: Created search results page"

#### Step 19.4: Search Optimization
- [ ] Implement FULLTEXT search for better results (optional)
- [ ] Add relevance scoring
- [ ] Limit results per category (show top 10)
- [ ] Add "Load More" or pagination
- [ ] Test search with various queries
- [ ] **Git commit:** "Step 19.4: Optimized search functionality"

**🔍 CHECKPOINT 19:** Global search works across all content types

---

### **PHASE 20: FINAL TESTING & DOCUMENTATION**

#### Step 20.1: Comprehensive Testing
- [ ] Test all user-facing features:
  - Homepage displays correctly
  - Navigation links work
  - Database links open correctly
  - Contact form submits
  - FAQ accordion functions
  - Static pages load
  - Search returns results
- [ ] Test all admin features:
  - Login/logout
  - All CRUD operations for each content type
  - File uploads (carousel)
  - Status toggles
  - Form validations
- [ ] Check all error scenarios
- [ ] Verify database integrity
- [ ] **Git commit:** "Step 20.1: Completed comprehensive testing"

#### Step 20.2: User Documentation
- [ ] Create user guide document:
  - How to navigate the website
  - How to access databases
  - How to download e-books/e-journals
  - How to contact library
  - How to search
- [ ] Save as PDF or HTML page
- [ ] Add link in footer (optional)
- [ ] **Git commit:** "Step 20.2: Created user documentation"

#### Step 20.3: Admin Documentation
- [ ] Create admin manual:
  - How to log in
  - How to manage each content type
  - Best practices for announcements
  - How to respond to contact submissions
  - How to add/remove databases
  - How to update library info
- [ ] Include screenshots if possible
- [ ] Save in project docs folder
- [ ] **Git commit:** "Step 20.3: Created admin documentation"

#### Step 20.4: Code Documentation
- [ ] Review all PHP files for comments
- [ ] Add/update docblocks for all classes and methods
- [ ] Document any complex logic
- [ ] Update README.md with:
  - Project description
  - Installation instructions
  - Configuration steps
  - Technology stack
  - Project structure
  - Credits
- [ ] **Git commit:** "Step 20.4: Completed code documentation"

#### Step 20.5: Deployment Preparation
- [ ] Create deployment checklist:
  - Update config.php with production settings
  - Update database.php with production credentials
  - Set proper file permissions (755 for folders, 644 for files)
  - Disable error display in production (log errors instead)
  - Test .htaccess rules on production server
  - Create database backup script
  - Set up regular backups
- [ ] Create deployment guide document
- [ ] **Git commit:** "Step 20.5: Created deployment documentation"

#### Step 20.6: Final Review
- [ ] Review all checkboxes in this planning.md file
- [ ] Ensure all features from PRD are implemented
- [ ] Verify Git commit history is clean and descriptive
- [ ] Check that all placeholders are clearly marked
- [ ] Run final security audit
- [ ] Test one more time on staging environment
- [ ] **Git commit:** "Step 20.6: Final review completed - MVP ready"

**🔍 FINAL CHECKPOINT:** Site is complete, tested, documented, and ready for deployment

---

## 🎉 Post-MVP Enhancements (Future Phases)

These features are marked as placeholders in the MVP and will be implemented later:

### Phase 21: File Upload System (Future)
- [ ] Implement secure file upload for e-books and e-journals
- [ ] Add file type validation (PDF, EPUB, etc.)
- [ ] Create file storage structure
- [ ] Add thumbnail generation
- [ ] Implement file download with proper headers

### Phase 22: OPAC Integration (Future)
- [ ] Research OPAC systems (Koha, Evergreen, etc.)
- [ ] Design catalog database schema
- [ ] Build catalog search interface
- [ ] Implement borrowing system
- [ ] Add user accounts for students

### Phase 23: Advanced Features (Future)
- [ ] User registration and profiles
- [ ] Reading lists/favorites
- [ ] Book reviews and ratings
- [ ] Email notifications for new resources
- [ ] Advanced analytics dashboard
- [ ] Multi-language support
- [ ] Mobile app API

---

## 📋 Git Commit Message Templates

Use these formats for consistent commit messages:

```
Setup/Config: "Step X.Y: [Description]"
Feature: "Step X.Y: Added [feature name]"
Update: "Step X.Y: Updated [component] with [changes]"
Fix: "Step X.Y: Fixed [issue] in [component]"
Style: "Step X.Y: Styled [component] with [changes]"
Docs: "Step X.Y: Documented [component/process]"
Test: "Step X.Y: Tested [feature/component]"
Refactor: "Step X.Y: Refactored [code] for [reason]"
```

---

## 🚨 Important Reminders

1. **NEVER skip checkpoints** - They ensure everything works before proceeding
2. **Test in browser after EVERY step** - Don't accumulate bugs
3. **Commit after EVERY completed step** - Granular commits are better
4. **Follow security best practices** - Sanitize inputs, use prepared statements
5. **Keep mobile-first mindset** - Test responsive design constantly
6. **Document as you go** - Don't leave documentation for the end
7. **Ask for help when stuck** - Reference this document and external docs
8. **Backup database regularly** - Especially before major changes
9. **Use Bootstrap classes first** - Custom CSS only when necessary
10. **Placeholder features are okay** - Mark them clearly for future implementation

---

## 📞 Support & References

- **Bootstrap 5 Docs:** https://getbootstrap.com/docs/5.3/
- **PHP Manual:** https://www.php.net/manual/en/
- **MySQL Reference:** https://dev.mysql.com/doc/
- **Git Documentation:** https://git-scm.com/doc
- **W3C Accessibility:** https://www.w3.org/WAI/
- **OWASP Security:** https://owasp.org/www-project-top-ten/

---

## ✅ Progress Tracking

Track your overall progress through the phases:

- [ ] Phase 1: Project Setup & Foundation (Steps 1.1-1.5)
- [ ] Phase 2: Frontend Layout & Shared Components (Steps 2.1-2.3)
- [ ] Phase 3: Homepage Development (Steps 3.1-3.5)
- [ ] Phase 4: Static Pages (Steps 4.1-4.5)
- [ ] Phase 5: Databases Page (Steps 5.1-5.4)
- [ ] Phase 6: Digital Resources (Steps 6.1-6.5)
- [ ] Phase 7: FAQ Page (Steps 7.1-7.4)
- [ ] Phase 8: Contact Form (Steps 8.1-8.5)
- [ ] Phase 9: Admin Authentication (Steps 9.1-9.5)
- [ ] Phase 10: Admin Dashboard (Steps 10.1-10.3)
- [ ] Phase 11: Manage Announcements (Steps 11.1-11.5)
- [ ] Phase 12: Manage Databases (Steps 12.1-12.4)
- [ ] Phase 13: Manage Static Pages (Steps 13.1-13.3)
- [ ] Phase 14: View Contact Submissions (Steps 14.1-14.4)
- [ ] Phase 15: Manage Carousel & Library Info (Steps 15.1-15.4)
- [ ] Phase 16: Manage FAQ (Steps 16.1-16.4)
- [ ] Phase 17: Digital Resources Upload Placeholder (Steps 17.1-17.3)
- [ ] Phase 18: Polish & Optimization (Steps 18.1-18.7)
- [ ] Phase 19: Search Functionality (Steps 19.1-19.4)
- [ ] Phase 20: Final Testing & Documentation (Steps 20.1-20.6)

**Current Phase:** ___________  
**Last Completed Step:** ___________  
**Next Step:** ___________

---

**End of Planning Document**

**Note to LLM:** When assisting with this project, always:
1. Check which step we're currently on
2. Reference the database schema and project structure
3. Follow the code quality standards
4. Ask for checkbox confirmation after completing each step
5. Remind about Git commits
6. Point out checkpoints when reached
7. Keep security and best practices in mind
8. Test thoroughly before marking step as complete