

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

- **store() = handle request → validate → save → respond**

         | Without `--api`           | With `--api`             |
         | ------------------------- | ------------------------ |
         | create(), edit() included | create(), edit() removed |
         | Used for web apps         | Used for REST APIs       |
         | HTML forms                | JSON responses           |


<h4>If you don't wanna use validation inside controller, then:</h4>

- **Author Controller**

- **Use a Form Request**
command:

        php artisan make:request StoreAuthorRequest
in controller:

            public function store(StoreAuthorRequest $request)
        {
            $author = Author::create($request->validated());
    
        return response()->json([
            'author' => $author,
            'message' => 'Author created successfully',
        ], 201);
        }

and in Request/StoreAuthorRequest/ :

        <?php
    
        namespace App\Http\Requests;
        
        use Illuminate\Foundation\Http\FormRequest;
        
        class StoreAuthorRequest extends FormRequest
        {
            public function authorize(): bool
            {
                return true; // allow request (change later if auth needed)
            }
    
        public function rules(): array
        {
            return [
                'name' => 'required|string|max:255',
                'bio'  => 'nullable|string',
            ];
        }
        }


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

<p align='center'><img width="48%"  src="https://github.com/user-attachments/assets/41648afc-420f-4384-846e-5f684c51eb91" />
 </p>
  <h4>Requests:</h4>

  Auhtor:

View all:(get)
        
        http://127.0.0.1:8000/api/authors/
        
Create:(post)

        http://127.0.0.1:8000/api/authors/
Find by single :(get)

        http://127.0.0.1:8000/api/authors/1
Update Author:(put|patch)

        http://127.0.0.1:8000/api/authors/1
Delete Author:(delete)

        http://127.0.0.1:8000/api/authors/1

<h4>Authors POSTMAN view</h4>
🔹 List & Create
<p align="center"> <img src="https://github.com/user-attachments/assets/fd5e76bf-c1d2-41c6-b478-b2eaecda80de" width="48%" /> <img src="https://github.com/user-attachments/assets/64f82600-1f43-42a4-b987-dd9d1dd26ce3" width="48%" /> </p>
🔹 View & Update
<p align="center"> <img src="https://github.com/user-attachments/assets/e25a3c22-04a2-4edb-baf8-d5b6f9b7ff51" width="48%" /> <img src="https://github.com/user-attachments/assets/433dbe24-fdca-4785-a947-3307c47a3ada" width="48%" /> </p>
🔹 Delete
<p align="center"> <img src="https://github.com/user-attachments/assets/1dc68108-a4e8-46d1-937c-2da79e3c586f" width="60%" /> </p>



        

<h3 align="center">📦 Laravel Resources</h3>

- **Laravel Resources (official name: API Resources) are a way to control how your models are converted to JSON in an API.
They sit between your models and your JSON response.**

- **Resources = how data is shown in API**

commands:

           php artisan make:resource AuthorResource
        
 - **INFO  Resource [D:\LibSecure\library-management-api\app\Http\Resources\AuthorResource.php] created successfully.**


   AuthorResource.php:

           <?php

            namespace App\Http\Resources;
            
            use Illuminate\Http\Request;
            use Illuminate\Http\Resources\Json\JsonResource;
            
            class AuthorResource extends JsonResource
            {
                /**
                 * Transform the resource into an array.
                 *
                 * @return array<string, mixed>
                 */
                public function toArray(Request $request): array
                {
                    return [
                        'name'=>$this->name,
                        'bio'=>$this->bio,
                        'nationality'=>$this->nationality
   
                         //relationship between books and author:
                        'books' => $this->whenCounted('books'),  
                    ];
                }
            }
   
Using it in Controller:

            return new AuthorResource($author);

Postman View:

<p align='center'><img width="48%"  src="https://github.com/user-attachments/assets/02aba636-0ecf-413a-9d73-8127e4f0471f" />

 </p>


<h3 align="center"> ✅ Books,Members,Borrowing Contoller and steps</h3>


<h3> 📖Books</h3>

- **Book Controller**
  
      php artisan make:controller BookController --api

- **Book Validation**

      php artisan make:request StoreBookRequest

- **INFO  Request [D:\LibSecure\library-management-api\app\Http\Requests\StoreBookRequest.php] created successfully.**

- **Book Resource**

      php artisan make:resource BookResource
  
- **INFO  Resource [D:\LibSecure\library-management-api\app\Http\Resources\BookResource.php] created successfully.**


- **Route->api.php**


      Route::apiResource('books',BookController::class);

- **Postman View:**

You must add:

    Headers->accept & application/json

    
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
















