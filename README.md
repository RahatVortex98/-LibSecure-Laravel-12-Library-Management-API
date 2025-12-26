

<h3 align='center'>🌐 Introduction To Api </h3>

        API- Stands for Application Programming Interface.

        An API is a set of rules and definitions that allows different software applications to communicate with each other.
        It acts as a messenger or middleman, enabling one program to request services or data from another program.

        Think like this:
        You are an application that needs information or a service.

        The api is like a waiter in a restaurant. You don't go into the kitchen to get your food. Instead of this, you just say
        Waiter (API), what do you want?

        The waiter(API) takes your order to the kitchen(the other application) and brings back the result. You receive your food 
        (the data or service) without needing to know how it was prepared.

        An API defines:
        How requests should be made: what information needs to be sent, and in what format.
        What response can be expected: what data or results will be returned, and in what format?

        
<h3 align='center'>🛠️ Tools & Technologies </h3>

- **Backend Framework**: Laravel 12, PHP 8.2+
- **Database & Management**: MySQL, Eloquent ORM
- **API Development & Security**: Laravel Sanctum, API Resources, Form Requests
- **Development Tools**: Postman, Artisan CLI, Composer


<h3 align='center'>⚙️ Development Session</h3>     

Command in terminal:

        laravel new library-management-api

Select your possible choices and then,

In .env, change the database section, then

        php artisan migrate  #to migrate your database

Note: make sure XAMPP is up and running.

<h3 align='center'>📚 Database Setup</h3>    

commands for making the model, migration table, and factory,

         php artisan make:model Author -mf

         php artisan make:model Book -mf  

         php artisan make:model Member -mf

         php artisan make:model Borrowing -mf
Relationship between them:

        Author → Book
        Author has many Books
        Book belongs to Author
        
        Member → Borrowing
        Member has many Borrowings
        Borrowing belongs to Member
        
        Book → Borrowing
        Book has many Borrowings
        Borrowing belongs to Book

Link: https://dbdiagram.io/

<p align='center'> <img width="50%" src="https://github.com/user-attachments/assets/4a05624f-1612-418d-a969-95bb8f4bb63c" />

</p>

<h3 align='center'>🎮 Setup Api Based Controller</h3>    

Commands:

         php artisan make:controller AuthorController --api

         

         | Without `--api`           | With `--api`             |
         | ------------------------- | ------------------------ |
         | create(), edit() included | create(), edit() removed |
         | Used for web apps         | Used for REST APIs       |
         | HTML forms                | JSON responses           |


<h3 align='center'>🛡️ Setup Sanctum and Setup</h3>  

Commands:

        php artisan install:api

<p align='center'><img width="48%"  src="https://github.com/user-attachments/assets/db65acb5-11ae-4ef0-97c3-bc3608f82885" /></p>
        
- **under routes, there will be a file: routes->api.php**

- **And in models user.php, add this->>- **

        use Laravel\Sanctum\HasApiTokens;
  
        use HasApiTokens;
<h3 align="center"> જ⁀➴ Routes </h3>

    Route::apiResource('authors',AuthorController::class);

- **to check all route list: **

      php artisan route:list
  
<h3 align="center">📮💼👮 Setup Postman </h3>

- **Create new collection ->Blank collection(named it) -> Add folder**
  <h4>Requests:</h4>

  Auhtor:

        http://127.0.0.1:8000/api/authors/   



<h3 align="center">📍 API Endpoints</h3>

### 👤 Authors
- **GET** `/api/authors` — List all authors  
- **POST** `/api/authors` — Create a new author  
- **GET** `/api/authors/{id}` — Get a specific author  
- **PUT** `/api/authors/{id}` — Update an author  
- **DELETE** `/api/authors/{id}` — Delete an author  

---

### 📚 Books
- **GET** `/api/books` — List all books (search, filter)  
- **POST** `/api/books` — Create a new book  
- **GET** `/api/books/{id}` — Get a specific book  
- **PUT** `/api/books/{id}` — Update a book  
- **DELETE** `/api/books/{id}` — Delete a book  

---

### 🧑 Members
- **GET** `/api/members` — List all members  
- **POST** `/api/members` — Create a new member  

---

### 🔄 Borrowing
- **GET** `/api/borrowings` — List all borrowings  
- **POST** `/api/borrowings` — Borrow a book  
- **POST** `/api/borrowings/{id}/return` — Return a book  
- **GET** `/api/borrowings/overdue/list` — Get overdue books  
















