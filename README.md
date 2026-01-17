# CenDash - Campus Dining System

CenDash is a web-based ordering platform built for New Era University. It simplifies how students find food and place orders from different campus vendors, making the whole dining experience easier and faster.

## Features
*   **Menu Browsing**: Check out what's available from different vendors with updated prices and descriptions.
*   **Ordering System**: Easy checkout process for students and an order management dashboard for admins.
*   **Vendor and Category Management**: Tools for vendors to add food items and organize their category listings.
*   **User Accounts**: Personal profiles to track order history and account details.

## Tech Stack and Tools

### Frontend
*   **Frontend Basics**: HTML5, Vanilla JavaScript (ES6+), and SCSS for custom styling.
*   **Tailwind CSS**: Using Tailwind CSS v4 for layout and components.
*   **Animations**: ScrollReveal for smooth scroll effects.
*   **Icons**: Font Awesome 6.5.1.
*   **Legacy Support**: jQuery (via CDN) is used for specific plugin features.

### Backend
*   **PHP**: Built with PHP 8.3.
*   **Database**: Supabase (PostgreSQL) using PDO with prepared statements for security.
*   **Email**: Integrated with EmailJS for handling notifications.

### Development & Tools
*   **Vite**: Handles the frontend build and dev server.
*   **pnpm**: Used for managing all packages and dependencies.
*   **Docker**: For consistent project environments.
*   **Render**: Current hosting platform for the live site.

---

## How to Run Locally

### Requirements
*   **PHP 8.3 or higher**
*   **pnpm 9 or higher**
*   **Node.js 20 or higher**

### Setup Steps

1.  **Clone the project**:
    ```bash
    git clone https://github.com/yourusername/CenDash.git
    cd CenDash
    ```

2.  **Install dependencies**:
    ```bash
    pnpm install
    ```

3.  **Database Config**:
    Add your Supabase details to the `server/.env` file.

4.  **Start the project**:
    This will start Vite, PHP, and the SASS watcher all at once:
    ```bash
    pnpm dev
    ```
    Open `http://localhost:5173` to view the site.

---

## Deployment (Render + Supabase)

1.  **Docker**: Make sure the `Dockerfile` is in the root folder before pushing to GitHub.
2.  **Render Setup**:
    *   Create a new **Web Service**.
    *   Select **Docker** as the runtime.
    *   Add your `DATABASE_URL` in the Render environment variables.
3.  **Keeping the site awake**:
    *   Because Render and Supabase free tiers go to sleep, I use a cron job (like cron-job.org).
    *   Point it to `https://your-app.onrender.com/server/ping.php` every 14 minutes to keep everything running smoothly.

---

## Achievements
CenDash received a **perfect score** as a final project for my first year, first semester at **New Era University** (Subject: Mathematics in Modern World - MMW). This project was built to solve the actual dining problems we face on campus.

---

## License
MIT License
