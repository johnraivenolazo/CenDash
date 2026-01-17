# CenDash — Centralized Campus Dining Platform

CenDash is a high-performance food ordering platform designed to streamline dining logistics at New Era University. By providing a real-time digital menu and a direct ordering interface, the system eliminates manual queuing and optimizes the interaction between students and campus vendors.

## 🚀 Engineering Highlights

Built with a focus on core web fundamentals and modern infrastructure, CenDash demonstrates a sophisticated approach to full-stack development without the overhead of heavy frameworks.

*   **Architecture:** Engineered from the ground up using **PHP 8.3** and **Vanilla JavaScript**, adopting a "no-framework" philosophy to maintain a lightweight footprint and ensure absolute control over the system logic.
*   **Infrastructure & DevOps:** Containerized the entire application using **Docker** to ensure environment parity. Configured a modern development pipeline using **Vite** and **pnpm** for optimized asset delivery and dependency management.
*   **Data Persistence:** Integrated **Supabase (PostgreSQL)** for secure, cloud-based data handling, utilizing PDO with prepared statements to ensure top-tier security and performance.
*   **Leadership:** Led a team of four developers, overseeing the entire software development lifecycle (SDLC) from initial UI/UX wireframing in SCSS to backend implementation and database schema design.

---

## 🛠 Tech Stack

### Backend & Database
*   **PHP 8.3**: Robust server-side logic and API handling.
*   **Supabase / PostgreSQL**: Scalable relational database with cloud persistence.
*   **EmailJS**: Integrated for automated notification services.

### Frontend
*   **Vanilla JS (ES6+)**: High-performance client-side logic.
*   **Tailwind CSS v4 & SCSS**: A custom-built, responsive design system.
*   **Vite**: Next-generation frontend tooling for rapid development and production builds.
*   **ScrollReveal**: Subtle micro-animations for an enhanced user experience.

### Deployment & Tools
*   **Docker**: Containerization for consistent deployment.
*   **Render**: Automated CI/CD platform for production hosting.
*   **pnpm**: High-efficiency package management.

---

## 🌟 Key Features

*   **Real-time Menu Management**: Dynamic vendor storefronts with instant price and availability updates.
*   **Vendor Dashboard**: Comprehensive order management system for campus vendors to track and process transactions.
*   **Student Interface**: Streamlined checkout process with personal order history tracking.
*   **Multi-tenant Architecture**: Scalable design allowing multiple vendors to manage independent categories and inventory.

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

## 📈 Context & Achievement

CenDash was developed as a production-ready solution to solve real-world dining inefficiencies at New Era University. The project was highly recognized for its technical architecture, leading to successful implementation and helping bridge the gap between campus vendors and the student population.

---

## 📄 License
This project is licensed under the MIT License.
