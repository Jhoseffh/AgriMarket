# AgriMarket

**AgriMarket** is an agricultural e-commerce website developed using Laravel. It allows users to buy and sell agricultural products using one account. This means that a user does not need a separate account to become a seller or a buyer.The main purpose of AgriMarket is to help farmers and other agricultural sellers sell their products directly to customers. Through this platform, buyers can purchase products without depending too much on middlemen or other intermediaries that may increase the final price of agricultural products. The system provides an online marketplace where sellers can post their products, while buyers can browse products, add them to their shopping cart, and place orders.


## 1. Technologies Used

| Technology    | Purpose                                                             |
| ------------- | ------------------------------------------------------------------- |
| Laravel 12    | Used to develop the main system and handle its backend functions.   |
| PHP           | Used for the system's programming logic.                            |
| MySQL         | Used to store user, product, cart, and order information.           |
| HTML          | Used to structure the website pages.                                |
| CSS           | Used to design the appearance of the website.                       |
| JavaScript    | Used to make website features interactive.                          |
| Blade         | Used to display dynamic information on website pages.               |
| Git           | Used to track changes and manage different versions of the project. |
| GitHub        | Used to store the project's source code online.                     |
| Laravel Cloud | Used to host the system and its production database online.         |


## 2. How the Laravel System Works
AgriMarket uses Laravel's Model-View-Controller (MVC) structure to organize the system. It separates the application into different parts, each with its own purpose.

How the System Works:
User → Route → Controller → Model → Database → View

The user interacts with the website through a browser, such as logging in, browsing products, or placing orders. The Route receives the request and directs it to the correct Controller, which handles the request and decides what action to perform. The Model communicates with the Database to retrieve or save information such as users, products, carts, and orders. Finally, the View, using Laravel Blade, displays the result on the website.

## 3. Database Management and Migrations

AgriMarket uses MySQL to store important system information. During development, the database runs locally using XAMPP, while the deployed application connects to its production database through Laravel Cloud. Laravel migrations are PHP files used to create or modify database tables through code instead of creating them manually. For example, AgriMarket uses migrations to create a products table that stores product names, prices, quantities, categories, images, and seller information.

## 4. Git Branches
- auth-shop-setup – Handles user authentication and the initial setup of the shop page.
- image-database-configuration – Handles product image storage and database configuration.
- main – The primary branch containing the main version of the project.
- order-setup – Handles the setup of the ordering system, including order processing and management.
- system-finalization – Handles final improvements, fixes, and integration of system features.
- user-configuration – Handles user-related settings, profiles, and account configurations.

## 5. What Is Laravel Cloud?

[Laravel Cloud](https://cloud.laravel.com/) is a hosting platform designed for Laravel applications. It provides the online environment needed to run a Laravel website without manually setting up a server. AgriMarket uses Laravel Cloud to make the application accessible through the internet.

Laravel Cloud connects to the project's GitHub repository to retrieve the application files. When a deployment starts, it gets the selected branch, installs the required dependencies, and runs the configured deployment commands. Once successful, the updated version of AgriMarket becomes available online.

Laravel Cloud makes deployment and maintenance easier by providing application hosting, managed database services, and production environment configuration. When developers make changes to AgriMarket, they commit and push the updates to GitHub. If automatic deployment is enabled, Laravel Cloud detects the changes and deploys the updated application without manually uploading the files.

## 6. Deployment Steps

AgriMarket is deployed using Laravel Cloud. The deployment process connects the GitHub repository to Laravel Cloud, configures the application, and makes the website accessible online.

### Steps:

1. **Prepare the Application** – Make sure the application works properly on the local development environment and that all changes are committed to Git.

2. **Push Changes to GitHub** – Push the latest project changes to the GitHub repository so Laravel Cloud can access the application code.

3. **Connect GitHub to Laravel Cloud** – Log in to Laravel Cloud and connect the GitHub repository containing AgriMarket.

4. **Configure the Application** – Select the repository and branch to deploy. Set the required environment variables, including the database connection details and other application settings.

5. **Set Up the Production Database** – Configure the database that the deployed application will use. Make sure its connection details match the application's environment settings.

6. **Deploy the Application** – Start the deployment through Laravel Cloud. It will prepare the application using the configured deployment process.

7. **Test the Live Website** – Open the deployed URL and check whether the main features work properly, including user authentication, product browsing, shopping cart, and order processing.

After deployment, AgriMarket can be accessed through its live website: https://agrimarket-production-steboa.laravel.cloud/