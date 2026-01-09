

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

✍️ Authors API – Postman View
<table> <tr> <td align="center"><b>List Authors</b></td> <td align="center"><b>Create Author</b></td> </tr> <tr> <td> <img src="https://github.com/user-attachments/assets/fd5e76bf-c1d2-41c6-b478-b2eaecda80de" width="450"/> </td> <td> <img src="https://github.com/user-attachments/assets/64f82600-1f43-42a4-b987-dd9d1dd26ce3" width="450"/> </td> </tr> <tr> <td align="center"><b>Get Author By ID</b></td> <td align="center"><b>Update Author</b></td> </tr> <tr> <td> <img src="https://github.com/user-attachments/assets/e25a3c22-04a2-4edb-baf8-d5b6f9b7ff51" width="450"/> </td> <td> <img src="https://github.com/user-attachments/assets/433dbe24-fdca-4785-a947-3307c47a3ada" width="450"/> </td> </tr> <tr> <td align="center" colspan="2"><b>Delete Author</b></td> </tr> <tr> <td colspan="2" align="center"> <img src="https://github.com/user-attachments/assets/1dc68108-a4e8-46d1-937c-2da79e3c586f" width="500"/> </td> </tr> </table>



        

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
    
🔗 API Endpoints
- **📘 Books API**

    | Method      | Description       | Endpoint                               |
    | ----------- | ----------------- | -------------------------------------- |
    | GET         | Get all books     | `http://127.0.0.1:8000/api/books`      |
    | POST        | Create a new book | `http://127.0.0.1:8000/api/books`      |
    | GET         | Get book by ID    | `http://127.0.0.1:8000/api/books/{id}` |
    | PUT / PATCH | Update book       | `http://127.0.0.1:8000/api/books/{id}` |
    | DELETE      | Delete book       | `http://127.0.0.1:8000/api/books/{id}` |



## 📸 Postman API Screenshots

<table>
<tr>
<td align="center"><b>Create Book</b></td>
<td align="center"><b>Get All Books</b></td>
</tr>
<tr>
<td><img src="https://github.com/user-attachments/assets/2f743208-861f-472c-9088-9db62c790e49" width="450"/></td>
<td><img src="https://github.com/user-attachments/assets/3c5a0224-b5c4-4897-8586-cca826ff3cbb" width="450"/></td>
</tr>

<tr>
<td align="center"><b>Get Book By ID</b></td>
<td align="center"><b>Update Book</b></td>
</tr>
<tr>
<td><img src="https://github.com/user-attachments/assets/31d34348-0b89-46b0-915a-768518a430e4" width="450"/></td>
<td><img src="https://github.com/user-attachments/assets/d9eb0c75-6653-4527-83cb-3a45eb61d241" width="450"/></td>
</tr>

<tr>
<td align="center" colspan="2"><b>Delete Book</b></td>
</tr>
<tr>
<td colspan="2" align="center">
<img src="https://github.com/user-attachments/assets/7de294df-f2f8-4693-aebd-06dbcf770c00" width="500"/>
</td>
</tr>
</table>


<h3>👥 Members</h3>

- **Members Controller**
  
      php artisan make:controller MemberController --api

- **Member Validation**

      php artisan make:request StoreMemberRequest

- **INFO  Request [D:\LibSecure\library-management-api\app\Http\Requests\StoreMemberRequest.php] created successfully.**

- **Member Resource**

      php artisan make:resource MemberResource
  
- **INFO  Resource [D:\LibSecure\library-management-api\app\Http\Resources\MemberResource.php] created successfully.**   

- **Route->api.php**


      Route::apiResource('members',MemberController::class);



🔗 API Endpoints
- **👥Members API**

    | Method      | Description       | Endpoint                               |
    | ----------- | ----------------- | -------------------------------------- |
    | GET         | Get all books     | `http://127.0.0.1:8000/api/members`      |
    | POST        | Create a new book | `http://127.0.0.1:8000/api/members`      |
    | GET         | Get book by ID    | `http://127.0.0.1:8000/api/members/{id}` |
    | PUT / PATCH | Update book       | `http://127.0.0.1:8000/api/members/{id}` |
    | DELETE      | Delete book       | `http://127.0.0.1:8000/api/members/{id}` |



👥 Members API 
– Postman Preview
<table> <tr> <td align="center"><b>Create Member</b></td> <td align="center"><b>Get All Members</b></td> </tr> <tr> <td> <img src="https://github.com/user-attachments/assets/6b3c32d0-dcb8-458e-a617-8c981bb9caff" width="450"/> </td> <td> <img src="https://github.com/user-attachments/assets/982996bc-597a-41c7-959e-d11f717d8c58" width="450"/> </td> </tr> <tr> <td align="center"><b>Get Member By ID</b></td> <td align="center"><b>Update Member</b></td> </tr> <tr> <td> <img src="https://github.com/user-attachments/assets/63ace6a4-09d3-41cd-8f37-6f524f26f1a5" width="450"/> </td> <td> <img src="https://github.com/user-attachments/assets/953cfcc7-e7fe-460f-9b38-e33992677c63" width="450"/> </td> </tr> <tr> <td align="center" colspan="2"><b>Delete Member</b></td> </tr> <tr> <td colspan="2" align="center"> <img src="https://github.com/user-attachments/assets/14e570c1-6b17-477c-a3de-413683112ba1" width="500"/> </td> </tr> </table>

<h3>🤝 Borrowings</h3>

- **Borrowings Controller**

      php artisan make:controller BorrowingController --api

- **Borrowings  Validation(For Update Controller)**

      php artisan make:request StoreBorrowingRequest
    
- **INFO  Request [D:\LibSecure\library-management-api\app\Http\Requests\StoreBorrowingRequest.php] created successfully.**

**Borrowings  Validation (For Update Controller)**

      php artisan make:request UpdateBorrowingRequest
    
- **INFO  Request [D:\LibSecure\library-management-api\app\Http\Requests\UpdateBorrowingRequest.php] created successfully.**
  
- **Borrowings  Resource**

      php artisan make:resource BorrowingResource

- **INFO  Resource [D:\LibSecure\library-management-api\app\Http\Resources\BorrowingResource.php] created successfully.**

 - **Route->api.php**

        Route::apiResource('borrowings',BorrowingController::class)->only(['index','store','show']);

        //return & overdue
   
        Route::post('borrowings/{borrowing}/return',[BorrowingController::class,'returnBook']);
        Route::get('borrowings/overdue/list',[BorrowingController::class,'overdue']);

   
  
🔗 API Endpoints
🤝 Borrowings API

        | Method | Description            | Endpoint                                            |
        | ------ | ---------------------- | --------------------------------------------------- |
        | GET    | Get all borrowings     | `http://127.0.0.1:8000/api/borrowings`              |
        | POST   | Create a new borrowing | `http://127.0.0.1:8000/api/borrowings`              |
        | GET    | Get borrowing by ID    | `http://127.0.0.1:8000/api/borrowings/{id}`         |
        | POST   | Return a borrowed book | `http://127.0.0.1:8000/api/borrowings/{id}/return`  |
        | GET    | Get overdue borrowings | `http://127.0.0.1:8000/api/borrowings/overdue/list` |

        
🤝 Borrowings API 
– Postman Preview    
<table> <tr> <td align="center"><b>Create Borrowing</b></td> <td align="center"><b>Get All Borrowings</b></td> </tr> <tr> <td><img src="https://github.com/user-attachments/assets/e2c47b61-89fb-438c-8217-b6c603e28764" width="450"/></td> <td><img src="https://github.com/user-attachments/assets/e5847968-8e9a-401c-ac34-72c1b70abed1" width="450"/></td> </tr> <tr> <td align="center"><b>Get Borrowing By ID</b></td> <td align="center"><b>Return Borrowed Book</b></td> </tr> <tr> <td><img src="https://github.com/user-attachments/assets/a9b61a0d-fbdf-4874-928c-9e5cb4ef82c1" width="450"/></td> <td><img src="https://github.com/user-attachments/assets/8803ebdf-0c38-48db-ae38-bb9e5e0122b3" width="450"/></td> </tr> <tr> <td align="center" colspan="2"><b>Overdue Borrowings</b></td> </tr> <tr> <td colspan="2" align="center"> <img src="https://github.com/user-attachments/assets/c4b0b9d0-fe01-4bd0-b432-baa401f263a6" width="520"/> </td> </tr> </table>


<h3>📉 Statistics</h3>
 - **Route->api.php**

         Route::get('statistics',function(){
        return response()->json([
            'total_books'=>\App\Models\Book::count(),
            'total_authors'=>\App\Models\Author::count(),
            'total_members'=>\App\Models\Member::count(),
            'book_borrowed'=>\App\Models\Borrowing::where('status','borrowed')->count(),
            'overdue_borrowings'=>\App\Models\Borrowing::where('status','overdue')->count(),
        ]);
– Postman Preview  
<table align="center"> <tr> <td align="center"><b>Create Borrowing</b></td> </tr> <tr> <td align="center"> <img src="https://github.com/user-attachments/assets/37202174-cdb3-4007-b6ca-5fcbb801fc4b" width="520" /> </td> </tr> </table>


<h3 align="center">🔐 Adding Authentication & Authorization</h3>

- **Auth Controller**
  
        php artisan make:controller AuthController

- **INFO  Controller [D:\LibSecure\library-management-api\app\Http\Controllers\AuthController.php] created successfully.**

- **Route->api.php**

      Route::post('/registration',[AuthController::class,'register']);
      Route::post('/login',[AuthController::class,'login']);

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
















