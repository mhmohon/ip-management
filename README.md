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
    <li><a href="#roadmap">Roadmap</a></li>
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
    <li><a href="#acknowledgments">Acknowledgments</a></li>
  </ol>
</details>



<!-- ABOUT THE PROJECT -->
## About The Project

This is an IP address management system where user can add a new IP addresses with a label.

### Built With

This section should list any major frameworks/libraries used to bootstrap your project. Leave any add-ons/plugins for the acknowledgements section. Here are a few examples.


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

<!-- ROADMAP -->
## Roadmap

- [x] Initial project setup with latest laravel 10
    - [x] Add all the necessary files (Modals, Migration files). 
    - [x] Install latest laravel sanctum package for authentication.
- [x] Add Additional Templates
- [x] Add Login & logout feature
    - [x] Write test cases for login & logout feature
- [x] Add CRU feature for IP address
    - [x] Complete the frontend Design module
    - [x] Validated the IP address
    - [x] Write test cases for this feature
- [x] Add Audit feature to the system
    - [x] Complete the frontend Design module
    - [x] Add Audit logs for logic and change actions
    - [x] Write test cases for to show audit logs
- [x] Update the readme file with proper project setup guidline

<!-- GETTING STARTED -->
## Getting Started

### Prerequisites

This is an example of how to list things you need to use the software and how to install them.
* npm
  ```sh
  npm install npm@latest -g
  ```

### Installation
Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/10.x)

Alternative installation is possible without local dependencies relying on [Docker](#docker).

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

** Now you have to setup the front application. Create another terminal in same directory and run following command.**
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
	

## Docker

To install with [Docker](https://www.docker.com), run following commands:

	git clone git@github.com:mhmohon/ip-management.git
	cd ip-management
	cp .env.example.docker .env
	docker run -v $(pwd):/app composer install
	cd ./docker
	docker-compose up -d
	docker-compose exec php php artisan key:generate
	docker-compose exec php php artisan jwt:generate
	docker-compose exec php php artisan migrate --seed
	docker-compose exec php php artisan serve --host=0.0.0.0

The api can be accessed at [http://localhost:8000/api](http://localhost:8000/api).

<!-- Architecture and Design Pattern -->
## Architecture and Design Pattern

I have chosen to use the Service Layer design patterns in my implementation of this application also used the service interface layer so that the code will be more abstract and increased testability, which make the application more modular, maintainable, and scalable.

<!-- USAGE EXAMPLES -->
## Usage

Use this space to show useful examples of how a project can be used. Additional screenshots, code examples and demos work well in this space. You may also link to more resources.

For storing an IP address in the database I've used the BINARY(16) field type to store both IPv4 and IPv6 addresses. This requires more storage space but allows for faster indexing and searching of IP addresses.
Used the inet_pton function to convert the IP address to its binary representation and stored it.
Used the inet_ntop function to convert the binary IP address to its human-readable form.

_For more examples, please refer to the [Documentation](https://example.com)_

<p align="right">(<a href="#readme-top">back to top</a>)</p>




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
