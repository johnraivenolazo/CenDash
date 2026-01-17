<div align="center">
  <img src="public/assets/images/logo.png" width="150" alt="CenDash Logo">
  <h1>CenDash</h1>
</div>


CenDash is a food ordering system built for New Era University. It replaces long, manual queues with a digital menu and a direct ordering interface, making it faster for students to get food and easier for vendors to manage their shops.

## How it's Built

I built CenDash with a focus on core web tech. Most student projects use basic local setups, but I wanted something that felt like a real product.

*   **Custom Framework-free Build:** Built entirely from scratch using **PHP 8.3** and **Vanilla JavaScript**. No heavy frameworks—just clean code that stays fast and easy to maintain.
*   **Modern Infrastructure:** The app is containerized with **Docker**, so it runs the same way on my machine as it does on the server. I used **Vite** and **pnpm** to keep the frontend build process fast.
*   **Database:** Instead of basic text files or local MySQL, I used **Supabase (PostgreSQL)**. It handles our data securely and gives us a cloud-hosted backend that's ready for production.
*   **The Team:** I led a team of four, handling everything from the initial UI designs in SCSS to the database schema and deployment on Render.

---

## The Tech Stack

### Tools
*   **PHP 8.3**: Handles all the logic and database connections.
*   **Supabase / PostgreSQL**: Cloud database with high security.
*   **Vite**: Fast dev server and build tool.
*   **Docker**: For consistent environments across different machines.
*   **Tailwind CSS v4 & SCSS**: For the layout and custom styling.

### Extras
*   **EmailJS**: For sending order notifications.
*   **ScrollReveal**: To add some simple animations when scrolling.
*   **pnpm**: Because it's faster and uses less disk space than npm.

---

## What it Does

*   **Live Menus:** Vendors can update their food items, prices, and availability in real-time.
*   **Vendor Dashboard:** A dedicated area for shop owners to track sales and manage incoming orders.
*   **Student Orders:** A clean interface for students to browse, order, and see their history.
*   **Multi-vendor Support:** Designed so multiple vendors can manage their own separate inventory and categories.

---

## 💻 Local Development

### Prerequisites
*   **PHP 8.3+**
*   **Node.js 20+**
*   **pnpm 9+**

### Setup
1.  **Clone the Repository**:
    ```bash
    git clone https://github.com/johnraivenolazo/CenDash.git
    cd CenDash
    ```
2.  **Install Dependencies**:
    ```bash
    pnpm install
    ```
3.  **Environment Configuration**:
    Configure your Supabase/PostgreSQL credentials in the `server/.env` file.
4.  **Run Development Server**:
    ```bash
    pnpm dev
    ```
    The application will be accessible at `http://localhost:5173`.

---

## Why this exists

We built CenDash because ordering food on campus was a hassle. The lines were too long, and it was hard to know what was actually available until you got to the counter. This project was our way of fixing that problem with a real technical solution. It was highly rated for its architecture and is a solid example of how to build a production-ready app without the bloat of large frameworks.

---

## 📄 License
This project is licensed under the MIT License.
