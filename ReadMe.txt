
### Setup Guide for Blog Laravel Application

This guide outlines the steps to clone the Blog Laravel application from GitHub and set it up for smooth operation.

#### Prerequisites:
- Git installed on your system.
- Composer installed on your system.
- PHP and Laravel dependencies installed.
- Xampp or another server installed.
- MySQL or another compatible database server installed.

#### Setup Steps:

1. **Clone Repository**:

   Clone the Blog repository from GitHub by executing the following command in your terminal:

   ```bash
   git clone https://github.com/prajwal-giri01/Blog.git
   ```

2. **Copy Environment File**:

   Navigate into the cloned repository directory and duplicate the `.env.example` file to create a new `.env` file:

   ```bash
   cp .env.example .env
   ```

3. **Install Dependencies**:

   Install the required PHP dependencies using Composer. Run the following command within the project directory:

   ```bash
   composer install
   ```

   Or, if you already have Composer dependencies installed and want to update them:

   ```bash
   composer update
   ```

4. **Database Migration and Seeding**:

   Execute the following command to migrate the database tables and seed initial data:

   ```bash
   php artisan migrate:fresh --seed
   ```

   This command will create the necessary tables and populate them with initial data.

5. **Generate Application Key**:

   Generate a new application key by running the following command:

   ```bash
   php artisan key:generate
   ```

   This command will set a secure key for your application.

#### Running the Application:

After completing the setup steps, your Blog Laravel application should be ready to run. You can start the application using the Laravel development server:

```bash
php artisan serve
```

Access the application in your web browser at `http://localhost:8000`.

#### Additional Information:

- Spatie Role and Permission: AdditionalRequirements.txt

---


