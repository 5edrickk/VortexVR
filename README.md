# Vortex VR 🕶️

Welcome to **Vortex VR**, an online e-commerce platform dedicated to Virtual Reality headsets! This project is an integrative web application built with PHP and provides a complete online shopping experience.

## ✨ Features

- **User Authentication**: Secure user registration, login, and profile management system.
- **Product Catalog**: Explore a diverse catalog of VR headsets featuring rich details, descriptions, prices, and stock indicators.
- **Advanced Filtering & Sorting**: Quickly find the perfect VR headset by searching terms, filtering by specific brands, or sorting by price/name.
- **Shopping Cart System**: Add products to your interactive cart, modify items, and monitor the total cost.
- **Virtual Wallet & Payment**: A built-in virtual wallet for users to manage their funds (`wallet.php`) and seamlessly check out (`checkout.php`).
- **Modern UI**: Attractive CSS-based designs, interactive filters, glassmorphism UI elements, and a responsive layout for optimal viewing on any device.

## 🛠️ Tech Stack

- **Backend**: Core PHP (Object-Oriented approaches with Managers)
- **Frontend**: HTML5, CSS3, JavaScript (Vanilla JS for interactive components)
- **Database**: MySQL / MariaDB (via PDO)

## 🚀 Installation & Local Setup

To run this project locally, you will need a local PHP server environment like **XAMPP**, **WAMP**, or **MAMP**.

1. **Clone the repository:**
   ```bash
   git clone <your-repository-url>
   cd projet-int-grateur-vortexvr
   ```

2. **Database Configuration:**
   - Open your MySQL management tool (e.g., phpMyAdmin).
   - Create a new database, preferably named `boutique_casques_vr`.
   - Import the provided database structure and sample data using the `boutique_casques_vr_FINAL_V2.sql` file.
   - *Optional:* Check `insertionBd.txt` for additional raw data queries if needed.

3. **Backend Setup:**
   - Locate your database connection file (usually in the `classe/` or `inc/` directory).
   - Ensure that the `$host`, `$dbname`, `$username`, and `$password` correctly correspond to your local environment (defaults typically being `root` and an empty password for local tools).

4. **Launch the platform:**
   - Ensure the project directory is located in the document root of your web server (e.g., `htdocs/` for XAMPP).
   - Start the Apache and MySQL modules.
   - Open your web browser and navigate to: `http://localhost/projet-int-grateur-vortexvr/`

## 📂 Project Structure

- `index.php` - Landing page with top product showcases and quick actions.
- `catalogue.php` - The comprehensive shop with dynamic search and filtering.
- `panier.php` / `checkout.php` - Cart overview and order confirmation processes.
- `compte.php` / `login.php` / `register.php` - Authentication and user management logic.
- `wallet.php` - Management dashboard for the user's virtual funds.
- `/classe/` - Contains the PHP classes (e.g., `CasqueManager.php`, `PanierManager.php`) responsible for DB interactions.
- `/inc/` - Reusable layout components (`header.php`, `footer.php`).
- `/css/` & `/js/` - Stylesheets and scripts for UI building and interactivity.
- `/images/` - Directory storing product and site imagery.

## 🗺️ System Design

Project conceptual design models, including the database schema (`Bd.png`) and architectural workflow (`Vfinal_projet.drawio`), are available at the root to overview the technical composition of the app.

---
*Created as an integrative project for a comprehensive web development coursework.*
