# College Library Website

A comprehensive library management system developed for college libraries using PHP MVC architecture.

## Features

- Digital Resources Management (E-books & E-journals)
- External Database Links
- Announcements System
- FAQ Management
- Contact/Ask a Librarian
- Admin Dashboard
- Responsive Design

## Tech Stack

- HTML5
- CSS3
- Bootstrap 5
- PHP 8.x
- MySQL
- MVC Architecture

## Requirements

- PHP 8.0 or higher
- MySQL 5.7 or higher
- Apache Web Server
- mod_rewrite enabled

## Installation

1. Clone the repository
2. Configure your web server to point to the project directory
3. Create a new MySQL database
4. Copy `config/database.example.php` to `config/database.php`
5. Update database credentials in `config/database.php`
6. Import the database schema from `database/schema.sql`
7. Access the website through your configured domain

## Project Structure

```
library-website/
├── index.php                      # Entry point
├── config/                        # Configuration files
├── app/                          # Application files
│   ├── controllers/              # Controllers
│   ├── models/                   # Models
│   └── views/                    # Views
├── public/                       # Public assets
│   ├── css/
│   ├── js/
│   ├── images/
│   └── uploads/
└── core/                         # Core framework files
```

## Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a new Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details