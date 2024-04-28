# Blog CMS APP

Welcome to the Laravel Filament Blog CMS repository! This project is a simple yet powerful content management system (CMS) built using Laravel and Filament.

Author: Malcolm Motubatse

<p align="center">
    <a href="#">
        <img 
            src="https://res.cloudinary.com/droskhnig/image/upload/v1714300884/screenshot_anstde.png" 
            width="400" 
            alt="Algorithmic Blog CMS" />
    </a>
</p>


## Features

- **Laravel Framework**: A robust PHP framework for building web applications.
- **Filament Admin Panel**: A beautiful and customizable admin panel for managing content.
- **Blog Functionality**: Create, edit, and manage blog posts easily.
- **User Authentication**: Secure user authentication system included.
- **Customizable**: Extend and customize according to your project requirements.

## Prerequisites

Before getting started, ensure you have the following installed on your machine:

- PHP (>= 8.3.6)
- Composer 2.7.4
- MySQL or other supported database

## Getting Started

Follow these steps to set up and run the project:

1. Clone the repository:

    ```bash
    git clone https://github.com/yourusername/blog-cms-app.git
    cd blog-cms-app
    ```

2. Install PHP dependencies:

    ```bash
    composer install
    ```

3. Copy the environment variables file:

    ```bash
    cp .env.example .env
    ```

4. Generate application key:

    ```bash
    php artisan key:generate
    ```

5. Update the `.env` file with your database credentials and other settings.

6. Run database migrations and seeders:

    ```bash
    php artisan migrate --seed
    ```

7. Start the development server:

    ```bash
    php artisan serve
    ```

8. Access the application in your web browser:

    ```
    http://localhost:8002
    ```

## Installation guide - DOCKER (Recommended)

Please ensure that you have the latest version of docker desktop installed.

After successfully installing, application should run on http://localhost:8002

Run the following commands in root folder:

    ```bash
    cp .docker/docker-compose.local.yml docker-compose.yml
    ```

Then create a .env file to prepare docker containers installation.

    ```bash
    cp .env.example .env
    ```

Then deploy the local installation, and wait until installation is complete.

    ```bash
    docker-compose up -d
    ```

As soon as installation is complete, ensure to run all the laravel installation commands inside the app container.

    ```bash
    docker-compose exec app bash // Logs you in an SSH session in app container
    ```

When inside the container, run the following commands (IF YOU DO NOT WANT TO IMPORT DATABASE)

    ```bash
    composer install
    ```

    ```bash
    php artisan migrate
    ```

## Usage

- Visit the admin panel to create and manage blog posts.
- Use the provided authentication system to manage users and roles.
- Customize the application according to your requirements.

## Contributing

Contributions are welcome! Please feel free to submit issues, feature requests, or pull requests.

## License

This project is licensed under the [MIT License](LICENSE).
