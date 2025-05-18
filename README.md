# slim-skeleton Project

## Introduction

Welcome to the Slim HWAI Project! This project provides a boilerplate setup using the Slim Framework, a PHP micro-framework designed for creating simple yet powerful web applications. This setup is intended to streamline the process of starting a new PHP project with Slim by providing a ready-to-use skeleton.

## Installation

To install the Slim HWAI project, you will need Composer, a dependency management tool for PHP. Follow these steps to create a new project:

1. Ensure Composer is Installed: Make sure you have Composer installed on your system. You can download it from [getcomposer.org](https://getcomposer.org).

2. Create a New Project: Run the following command in your terminal to create a new project based on the Slim HWAI boilerplate:

    ```bash
    composer create-project hwai/slim-skeleton
    ```

    This command will create a new directory with the Slim HWAI project structure and install all necessary dependencies.

## Project Structure

After installation, you will have a project with the following structure:

-   `src/`: Contains the source code for your application. This is where you'll place your routes, controllers, and any other business logic.
-   `public/`: This is the web root directory. It contains publicly accessible files like HTML, CSS, JavaScript, and the entry point for your application (`index.php`).
-   `config/`: Contains configuration files for your application. This might include settings for database connections, middleware, and other configuration parameters.
-   `vendor/`: Contains Composer-managed libraries and dependencies. You generally won't need to modify anything here.
-   `tests/`: (Optional) If you include testing in your project, this directory will hold your test cases and test-related configuration.

## Running the Application

To start the application and view it in your web browser, you can use the built-in PHP web server. Navigate to the root directory of your project and run:

```bash
rr.exe serve
```

This will start a local server at [http://localhost:8080](http://localhost:8080). Open this URL in your browser to view your application.

## Configuration

Configuration files are located in the `config/` directory. Here, you can adjust settings specific to your environment, such as database credentials, environment variables, and other configuration parameters.

## Development and Contribution

If you wish to contribute to the development of this project, follow these steps:

1. Fork the Repository: Click on the "Fork" button at the top-right of the repository page on GitHub.

2. Create a Feature Branch: Create a new branch for your feature or bug fix:

    ```bash
    git checkout -b feature/YourFeature
    ```

3. Make Changes: Implement your changes and test them locally.

4. Submit a Pull Request: Push your changes to your forked repository and open a Pull Request (PR) on the original repository, providing a clear description of the changes you made.

## Issues and Support

If you encounter any issues or have questions about the project, please:

1. Open an Issue on GitHub with a detailed description of the problem or question.
2. Contact us via email at support@hwai.com for additional support.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for more details.
