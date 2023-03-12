<!-- PROJECT INFO -->
<div align="center">
  <h3 align="center">IP Address Management Solution</h3>
  <p align="center">
    A solution to manage IP address
  </p>
</div>



<!-- TABLE OF CONTENTS -->
<details>
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
      <ul>
        <li><a href="#built-with">Built With</a></li>
      </ul>
    </li>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#installation">Installation</a></li>
      </ul>
    </li>
    <li><a href="#architecture-and-design-pattern">Architecture and Design Pattern</a></li>
    <li><a href="#usage">Usage</a></li>
    <li><a href="#contact">Contact</a></li>
  </ol>
</details>



<!-- ABOUT THE PROJECT -->
## About The Project

This is a system that allows users to manage IP addresses by adding and updating labels. It provides an easy-to-use interface for tracking IP addresses and their associated labels. Additionally, the system features an audit log service that records all user actions, providing accountability and traceability for all changes made to the IP address database.

### Built With

This project is build with these technologies.

[![Vue][Vue.js]][Vue-url]
[![Laravel][Laravel.com]][Laravel-url]
[![tailwindcss.com][tailwindcss.com]][tailwindcss-url]


<!-- REQUIREMENTS -->
## Requirements

- A token based login feature to the system.
- User should be able to add, view new IP address with a label to the database.
    - IP addresses must be validated
    - Only authenticated user are able add/changes the record of database.
- User should be able to modify only the IP address label.
- System should have an audit log where all the changes will stored.
    - The audit trail should be maintained for every login and changes.
- The application should be designed and built following best practices and design patterns.
- The application should be well-documented and testable.
- Write a few test cases to ensure that the API is functioning as expected.

<!-- GETTING STARTED -->
## Getting Started

### Prerequisites

Before you can run this Laravel project, you'll need to install the following software:

- PHP v8.1 or later
- Composer v2.5.4 or later
- Laravel v10.0 or later
- MySQL
- npm v8.5.1 or later

You will also need to set up a MySQL database and configure Laravel to use it. Here's how:

1. Create a new MySQL database foryour project.
2. Update the **DB_DATABASE**, **DB_USERNAME**, and **DB_PASSWORD** values in the **.env** file to match your MySQL database credentials.

### Installation
Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/10.x)

1. Clone the repo

		git clone git@github.com:mhmohon/ip-management.git
	
2. Switch to the repo folder

		cd ip-management
	
3. Install all the dependencies using composer

		composer install
	
4. Copy the example env file and make the required configuration changes in the .env file

		cp .env.example .env
	
5. Generate a new application key

		php artisan key:generate
	
6. Run the database migrations (**Set the database connection in .env before migrating**)

		php artisan migrate --seed
	
7. Start the local development server

		php artisan serve

You can now access the server at http://localhost:8000

**Now you have to setup the front application. Create another terminal in same directory and run following command.**
1. Install NPM packages

        npm install
	
2. Start the local frontend server

   	    npm run dev

**TL;DR command list**

    git clone git@github.com:mhmohon/ip-management.git
    cd ip-management
    composer install
    cp .env.example .env
    php artisan key:generate
	
**Make sure you set the correct database connection information before running the migrations**

    php artisan migrate --seed
    php artisan serve
    
**TL;DR command list for local frontend server**

    npm install
    npm run dev

<!-- Architecture and Design Pattern -->
## Architecture and Design Pattern
#### Service Layer Pattern
I have chosen to use the Service Layer design patterns in my implementation of this application also used the **service interface** layer so that the code will be more abstract and increased testability, which make the application more modular, maintainable, and scalable.

#### Model-Observer Pattern
For creating audit log service I have used Model-Observer Pattern, to make the code more simplifies code and provide separation of concerns.

#### Event Service Pattern
To create audit log for each time user login, I have used this pattern to make the code more scalable.

#### Other Libraries
For storing an IP address in the database I have used the BINARY(16) field type to store both IPv4 and IPv6 addresses. This requires more storage space but allows for faster indexing and searching of IP addresses.
Used the inet_pton function to convert the IP address to its binary representation and stored it.
Used the inet_ntop function to convert the binary IP address to its human-readable form.

<!-- USAGE EXAMPLES -->
## Usage
### Few Screenshots
##### Login Page
[![login.png](https://i.postimg.cc/PqXH3QxG/login.png)](https://postimg.cc/870xsWMw)
##### Home Page
[![homepage.png](https://i.postimg.cc/G3WHM6nZ/homepage.png)](https://postimg.cc/HjtYnZx2)
##### Audit Log Page
[![auditpage.png](https://i.postimg.cc/3NnmGBdK/auditpage.png)](https://postimg.cc/Mffn2174)


You can run **Unit** test by using this command

		./vendor/bin/pest
	
**Result**

![pestImage][pestImage]

You can run **PHPStan** test by using this command

		./vendor/bin/phpstan analyse
	
**Result**

![phpstan][phpstan]



<!-- CONTACT -->
## Contact

Mosharrf Hossain - [@Linkedin](https://www.linkedin.com/in/mhmohon/) - mhmosharrf@gmail.com

Project Link: [https://github.com/mhmohon/ip-management](https://github.com/mhmohon/ip-management)



<!-- MARKDOWN LINKS & IMAGES -->
<!-- https://www.markdownguide.org/basic-syntax/#reference-style-links -->
[linkedin-url]: https://linkedin.com/in/mhmohon
[product-screenshot]: images/screenshot.png
[Next.js]: https://img.shields.io/badge/next.js-000000?style=for-the-badge&logo=nextdotjs&logoColor=white
[Vue.js]: https://img.shields.io/badge/Vue.js-35495E?style=for-the-badge&logo=vuedotjs&logoColor=4FC08D
[Vue-url]: https://vuejs.org/
[Laravel.com]: https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white
[Laravel-url]: https://laravel.com
[Bootstrap.com]: https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white
[Bootstrap-url]: https://getbootstrap.com
[tailwindcss.com]: https://img.shields.io/badge/tailwindcss-0769AD?style=for-the-badge&logo=tailwindcss&logoColor=white
[tailwindcss-url]: https://tailwindcss.com 
[pestImage]: https://i.ibb.co/GvRCTWM/pest.png
[phpstan]: https://i.ibb.co/z2d65HY/phpstan.png
