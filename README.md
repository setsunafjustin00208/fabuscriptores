# fabuscriptores

## Purpose

**fabuscriptores** is a writer community-driven platform for storytellers to create meaningful fictional stories with limitless collaboration. The platform empowers users to write, share, and collaborate on stories, fostering a creative and supportive environment for writers of all backgrounds.

---

## Tech Stack

- **Frontend:** [Vue 3](https://vuejs.org/) (JavaScript)
- **Backend:** [CodeIgniter 4](https://codeigniter.com/) (PHP 8.4)
- **Database:** [MongoDB](https://www.mongodb.com/)

---

## Setup

1. **Clone the repository:**
   ```sh
   git clone <your-repo-url>
   cd fabuscriptores
   ```

2. **Backend Setup (CodeIgniter 4):**
   - Copy `env` to `.env` and configure your environment variables, especially:
     - `app.baseURL`
     - MongoDB connection:  
       ```
       mongodb.default.connectionstring = mongodb://localhost:27017
       mongodb.default.database = fabuscriptores
       ```
   - Install PHP dependencies:
     ```sh
     composer install
     ```

3. **Frontend Setup (Vue 3):**
   - Navigate to the `resources` folder (if present) and install dependencies:
     ```sh
     cd resources
     npm install
     ```
   - Run the development server:
     ```sh
     npm run dev
     ```
   - For production build:
     ```sh
     npm run build
     ```

4. **Database Setup (MongoDB):**
   - Ensure MongoDB is running and accessible at the connection string specified in your `.env`.

5. **Running the Application:**
   - Start the backend server (from the project root):
     ```sh
     php spark serve
     ```
   - Access the frontend via the Vite dev server or after building, through the backend's public directory.

---

## Directory Structure

- `app/Controllers` - Backend controllers (API endpoints)
- `app/Libraries` - Custom PHP libraries (e.g., MongoDB integration)
- `app/Modules` - Modular structure for features (controllers, models, views)
- `app/Views` - Backend-rendered views
- `resources/` - Vue 3 frontend source code
- `public/` - Public web root (entry point for web server)

---

## CLI Commands

### Default CodeIgniter 4 Commands

You can use the built-in CodeIgniter CLI tool, `spark`, for many tasks:

- `php spark serve`  
  Start the local development server.

- `php spark migrate`  
  Run all new migrations.

- `php spark db:seed`  
  Seed the database.

- `php spark routes`  
  List all defined routes.

- `php spark help`  
  List all available commands.

See [CodeIgniter 4 User Guide - CLI](https://codeigniter.com/user_guide/cli/cli.html) for more.

---

### Custom fabuscriptores Commands

#### Create Command

The `create` command helps you scaffold new components for your project:

- **Create a View:**  
  ```
  php spark create view MyView
  ```
  - Prompts for an optional subdirectory under `app/Views`.

- **Create a Library:**  
  ```
  php spark create library MyLibrary
  ```
  - Prompts for an optional subdirectory under `app/Libraries`.
  - Generates a PHP class with the given name.

- **Create a Module:**  
  ```
  php spark create module Blog
  ```
  - Creates a new module under `app/Modules/Blog` with default `Controllers`, `Models`, and `Views` folders.
  - Generates a default controller, model, and view for the module.

---

## Testing

- Backend tests use PHPUnit.
- To run tests:
  ```sh
  vendor\bin\phpunit
  ```
- Configure your test database in `.env` or `app/Config/Database.php`.

---

## Contribution

Contributions are welcome! Please fork the repository and submit a pull request.

---

## License

This project is open-source and available under the MIT License.