# Cristhian García Challenge for Horus

This project contemplates the creation of an API to handle geometric figures such as the Circle and the Triangle, and the sum of Diameters and areas also saves a history in the Database of each query made to the methods /circle/sum-objects and /triangle/sum-objects, is deployed using Docker, Nginx, MySQL, PHP. Implement unit tests and use design patterns such as: Template Method and Adapter explained later

## Deploy

### Cloning the Repository

To clone the repository from GitHub, you can follow these instructions:

1. Open your terminal or command prompt.

2. Navigate to the directory where you want to clone the repository. For example, if you want to clone it into your "Documents" folder, you can use the following command:

   ```
   cd Documents
   ```

3. Run the following command to clone the repository:

   ```
   git clone https://github.com/crisgarlez/horus-challenge.git
   ```

   This command will initiate the cloning process and download the repository files to your current directory.

4. Wait for the cloning process to complete. Once it's finished, you should see a new directory named "horus-challenge" in your current location.

5. You have successfully cloned the repository! You can now navigate into the cloned directory using the following command:

   ```
   cd horus-challenge
   ```

### Using Docker to deploy on local environment

To build Docker images for the repository using the docker-compose.yml file provided inside the horus-challenge folder, you can follow these instructions:

1. Ensure that you have Docker and Docker Compose installed on your machine. You can download and install Docker from the official Docker website (https://www.docker.com/get-started), and Docker Compose is typically included with Docker on most platforms.

2. Open your terminal or command prompt.

3. Inside the `horus-challenge` directory, you should find a `docker-compose.yml` file.

4. Run the following command to build the Docker images defined in the `docker-compose.yml` file:

   ```bash
   docker-compose build
   ```

   This command will read the `docker-compose.yml` file and build the necessary Docker images specified in the file.

5. Wait for the images to be built. The time it takes to build the images may vary depending on the complexity of the project and the resources of your machine.

6. Once the images have been built successfully, you can proceed to run the containers based on the images using the `docker-compose up` command. Run the following command:

   ```bash
   docker-compose up
   ```

   This command will start the containers according to the configurations specified in the `docker-compose.yml` file.

   Note: If you want to run the containers in detached mode (in the background), you can add the `-d` flag:

   ```bash
   docker-compose up -d
   ```

7. The containers should now be running, and you can access the services provided by the application.

### Using Postman to do HTTP Request

#### Importing the Postman collection

To import the Postman collection located in the `postman/HorusChallenge.postman_collection.json` file, you can follow these instructions:

1. Make sure you have Postman installed on your machine. You can download and install Postman from the official Postman website (https://www.postman.com/downloads/).

2. Open Postman and ensure you are in the Postman workspace where you want to import the collection.

3. In the Postman application, click on the "Import" button in the top left corner of the screen.

4. In the Import dialog, select the "File" tab.

5. Click on the "Upload Files" button and navigate to the location where you have cloned the repository.

6. Inside the cloned repository, locate the `postman` folder and open it.

7. Select the `HorusChallenge.postman_collection.json` file.

8. Click the "Open" or "Choose" button to start the import process.

9. Postman will import the collection and display a confirmation message once the import is complete.

10. You should now see the imported collection in the left sidebar of the Postman application.

11. Click on the imported collection to expand it and view the available requests and folders.

You have successfully imported the Postman collection into Postman. You can now use the collection to make requests to the API endpoints provided by the Horus Challenge application.

Please note that the instructions may vary slightly depending on the version of Postman you are using.

#### API Methods

##### circle Endpoint

```console
GET /circle/2
HTTP/1.1
Host: localhost

Response:
{
    "surface": "12.57",
    "circumference": "12.57",
    "type": "circle",
    "radius": "2.0"
}
```

##### triangle Endpoint

```console
GET /triangle/3/4/5
HTTP/1.1
Host: localhost

Response:
{
    "surface": "6.0",
    "circumference": "12.0",
    "type": "triangle",
    "a": "3.0",
    "b": "4.0",
    "c": "5.0"
}
```

##### circle-sum Endpoint

```console
POST /circle/sum-objects
HTTP/1.1
Host: localhost
Content-Type: application/json

Body:

{
    "circle1": {
        "radius": 2
    },
    "circle2": {
        "radius": 2
    }
}

Response

{
    "totalAreas": 25.14,
    "totalDiameters": 8
}
```

##### triangle-sum Endpoint

```console
POST /triangle/sum-objects
HTTP/1.1
Host: localhost
Content-Type: application/json
Content-Length: 159

{
    "triangle1": {
        "a": 3,
        "b": 4,
        "c": 5
    },
    "triangle2": {
        "a": 3,
        "b": 4,
        "c": 5
    }
}

Response

{
    "totalAreas": 12,
    "totalDiameters": 24
}
```

##### history Endpoint

```console
GET /history
HTTP/1.1
Host: localhost

Response

[
    {
        "id": 1,
        "request": "{\r\n    \"circle1\": {\r\n        \"radius\": 2\r\n    },\r\n    \"circle2\": {\r\n        \"radius\": 2\r\n    }\r\n}",
        "response": "{\"totalAreas\":25.14,\"totalDiameters\":8}",
        "createdAt": "2023-06-26 17:40:34"
    }
]
```

## Project Explaniation

**Shape Entity Class:**

```php
<?php

namespace App\Entity;

abstract class Shape
{
    abstract public function calculateSurface(): float;
    abstract public function calculateDiameter(): float;

    public function calculateSurfaceAndDiameter(): array
    {
        $surface = $this->calculateSurface();
        $diameter = $this->calculateDiameter();

        return [
            'surface' => $surface,
            'circumference' => $diameter,
        ];
    }
}
```

- The Shape class is an abstract class that serves as the base class for all shapes.
- It declares two abstract methods: `calculateSurface()` and `calculateDiameter()`. These methods represent steps of an algorithm that subclasses must implement.
- The Shape class also provides a concrete method called `calculateSurfaceAndDiameter()`. This method acts as the template method, defining the overall algorithmic structure.
- The `calculateSurfaceAndDiameter()` method calls the abstract methods `calculateSurface()` and `calculateDiameter()` to calculate the surface area and diameter of the shape, respectively.
- The method returns an array containing the calculated surface area and diameter.

**Circle Entity Class:**

```php
<?php

namespace App\Entity;

use App\Entity\Shape;

class Circle extends Shape
{
    private $radius;

    public function __construct(float $radius)
    {
        $this->radius = $radius;
    }

    public function calculateSurface(): float
    {
        return round(pi() * ($this->radius ** 2), 2);
    }

    public function calculateDiameter(): float
    {
        return $this->radius * 2;
    }

    public function serialize(): array
    {
        $result = $this->calculateSurfaceAndDiameter();
        $result['type'] = 'circle';
        $result['radius'] = number_format($this->radius, 1, ".", "");
        $result['circumference'] = number_format($result['surface'], 2, ".", "");
        $result['surface'] = number_format($result['surface'], 2, ".", "");

        return $result;
    }
}
```

- The Circle class extends the Shape class, inheriting the template method and implementing the abstract methods.
- It has a private property called `$radius` to store the radius of the circle.
- The class implements the `calculateSurface()` method, which calculates the surface area of the circle using the formula π \* radius^2.
- It also implements the `calculateDiameter()` method, which calculates the diameter of the circle by multiplying the radius by 2.
- Additionally, the Circle class provides a `serialize()` method, which converts the Circle object into an array with serialized properties, including the type, radius, surface, and circumference.

**Triangle Entity Class:**

```php
<?php

namespace App\Entity;

use App\Entity\Shape;

class Triangle extends Shape
{
    private $a;
    private $b;
    private $c;

    public function __construct(float $a, float $b, float $c)
    {
        $this->a = $a;
        $this->b = $b;
        $this->c = $c;
    }

    public function calculateSurface(): float
    {
        $s = ($this->a + $this->b + $this->c) / 2;
        return round(sqrt($s * ($s - $this->a) * ($s - $this->b) * ($s - $this->c)), 2);
    }

    public function calculateDiameter(): float
    {
        return $this->a + $this->b + $this->c;
    }

    public function serialize(): array
    {
        $result = $this->calculateSurfaceAndDiameter();
        $result['type'] = 'triangle';
        $result['a'] = number_format($this->a, 1, ".", "");
        $result['b'] = number_format($this->b, 1, ".", "");
        $result['c'] = number_format($this->c, 1, ".", "");
        $result['circumference'] = number_format($result['circumference'], 1, ".", "");
        $result['surface'] = number_format($result['surface'], 1, ".", "");

        return $result;
    }
}
```

- The Triangle class, similar to the Circle class, extends the Shape class and implements the abstract methods.
- It has three private properties: `$a`, `$b`, and `$c`, representing the lengths of the triangle's sides.
- The class implements the `calculateSurface()` method, which calculates the surface area of the triangle using Heron's formula.
- The `calculateDiameter()` method calculates the diameter of the triangle by summing up all three side lengths.
- Similarly to the Circle class, the Triangle class provides a `serialize()` method to convert the Triangle object into an array with serialized properties, including the type, side lengths (a, b, c), surface, and circumference.

**Template Method Pattern:**

- The Template Method pattern is implemented in the Shape class and its subclasses (Circle and Triangle).
- The Shape class defines the overall algorithmic structure through the `calculateSurfaceAndDiameter()` template method.
- The abstract methods `calculateSurface()` and `calculateDiameter()` act as "hooks" that subclasses must implement to provide specific calculations for their respective shapes.
- The template method calls these abstract methods, allowing each subclass to customize the behavior of those specific steps.
- This approach promotes code reuse and provides a common structure for calculating the surface area and diameter of different shapes.

**GeometryCalculator.php Service Class**

```php
<?php

namespace App\Service;

use App\Entity\Shape;

class GeometryCalculator
{
    public function sumAreas(Shape $shape1, Shape $shape2): float
    {
        $area1 = $shape1->calculateSurface();
        $area2 = $shape2->calculateSurface();

        return $area1 + $area2;
    }

    public function sumDiameters(Shape $shape1, Shape $shape2): float
    {
        $diameter1 = $shape1->calculateDiameter();
        $diameter2 = $shape2->calculateDiameter();

        return $diameter1 + $diameter2;
    }
}
```

The `GeometryCalculator` class is a service class that provides methods for calculating the sum of areas and sum of diameters for two given shapes.

Let's break down the class and its methods:

1. `sumAreas(Shape $shape1, Shape $shape2): float`:

   - This method takes two `Shape` objects, `$shape1` and `$shape2`, as input parameters.
   - It calls the `calculateSurface()` method on each shape object to calculate their respective surface areas.
   - The calculated surface areas are then added together and returned as a float value representing the sum of areas.

2. `sumDiameters(Shape $shape1, Shape $shape2): float`:
   - This method takes two `Shape` objects, `$shape1` and `$shape2`, as input parameters.
   - It calls the `calculateDiameter()` method on each shape object to calculate their respective diameters.
   - The calculated diameters are then added together and returned as a float value representing the sum of diameters.

The `GeometryCalculator` class operates on the abstraction of the `Shape` class. This allows it to work with any subclass of `Shape`, such as `Circle` or `Triangle`, as long as they implement the required methods (`calculateSurface()` and `calculateDiameter()`).

By encapsulating the logic for calculating the sum of areas and sum of diameters in a separate service class, the `GeometryCalculator` promotes separation of concerns and keeps the code organized. It also allows for easy extension and flexibility if additional shape types or calculations need to be added in the future.

**CircleController.php Controller class**

```php
<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Circle;
use App\Service\GeometryCalculator;

class CircleController extends AbstractController
{
    #[Route('/circle/{radius}', methods: ["GET"], name: 'app_circle')]
    public function index(float $radius): JsonResponse
    {
        $circle = new Circle($radius);
        return $this->json($circle->serialize());
    }

    #[Route('/circle/sum-objects', methods: ["POST"], name: 'app_circle_sum_object')]
    public function sumObjects(Request $request, GeometryCalculator $geometryCalculator): JsonResponse
    {
        $payload = json_decode($request->getContent(), TRUE);
        $circle1 = new Circle($payload['circle1']['radius']);
        $circle2 = new Circle($payload['circle2']['radius']);

        return $this->json([
            'totalAreas' => $geometryCalculator->sumAreas($circle1, $circle2),
            'totalDiameters' => $geometryCalculator->sumDiameters($circle1, $circle2)
        ]);
    }
}
```

The `CircleController` class is a Symfony controller that handles HTTP requests related to circles. Let's go through the code and understand its functionality:

1. `index(float $radius): JsonResponse`:

   - This method is mapped to the route `/circle/{radius}` with the HTTP method `GET`.
   - It expects a `float` parameter `$radius` to be passed in the URL.
   - Inside the method, a new `Circle` object is created using the provided `$radius`.
   - The `serialize()` method of the `Circle` object is called, which returns an array containing information about the circle.
   - The array is then converted to a JSON response using the `json()` method of the `AbstractController` class and returned.

2. `sumObjects(Request $request, GeometryCalculator $geometryCalculator): JsonResponse`:
   - This method is mapped to the route `/circle/sum-objects` with the HTTP method `POST`.
   - It expects a `Request` object and a `GeometryCalculator` object to be passed as dependencies.
   - The request payload is decoded from JSON format using the `json_decode()` function with the second argument set to `true`, which returns an associative array.
   - Two `Circle` objects are created using the radius values extracted from the payload.
   - The `sumAreas()` and `sumDiameters()` methods of the `GeometryCalculator` service are called, passing the two circle objects as arguments.
   - The results of the calculations, the total areas and total diameters, are returned as a JSON response.

The `CircleController` class follows the Symfony controller convention, utilizing annotations for route mapping. It uses the `Circle` entity class to create circle objects and the `GeometryCalculator` service to perform calculations on those objects.

**TriangleController.php Controller class**

```php
<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Service\GeometryCalculator;
use App\Entity\Triangle;

class TriangleController extends AbstractController
{
    #[Route('/triangle/{a}/{b}/{c}', methods: ["GET"], name: 'app_triangle')]
    public function index(float $a, float $b, float $c): JsonResponse
    {
        $triangle = new Triangle($a, $b, $c);
        return $this->json($triangle->serialize());
    }

    #[Route('/triangle/sum-objects', methods: ["POST"], name: 'app_triangle_sum_object')]
    public function sumObjects(Request $request, GeometryCalculator $geometryCalculator): JsonResponse
    {
        $payload = json_decode($request->getContent(), TRUE);

        $triangle1 = $payload['triangle1'];
        $triangle1 = new Triangle($triangle1['a'], $triangle1['b'], $triangle1['c']);

        $triangle2 = $payload['triangle2'];
        $triangle2 = new Triangle($triangle2['a'], $triangle2['b'], $triangle2['c']);

        return $this->json([
            'totalAreas' => $geometryCalculator->sumAreas($triangle1, $triangle2),
            'totalDiameters' => $geometryCalculator->sumDiameters($triangle1, $triangle2)
        ]);
    }
}
```

The `TriangleController` class is another Symfony controller that handles HTTP requests related to triangles. Let's understand the code and its functionality:

1. `index(float $a, float $b, float $c): JsonResponse`:

   - This method is mapped to the route `/triangle/{a}/{b}/{c}` with the HTTP method `GET`.
   - It expects three `float` parameters `$a`, `$b`, and `$c` to be passed in the URL representing the sides of the triangle.
   - Inside the method, a new `Triangle` object is created using the provided side lengths.
   - The `serialize()` method of the `Triangle` object is called, which returns an array containing information about the triangle.
   - The array is then converted to a JSON response using the `json()` method of the `AbstractController` class and returned.

2. `sumObjects(Request $request, GeometryCalculator $geometryCalculator): JsonResponse`:
   - This method is mapped to the route `/triangle/sum-objects` with the HTTP method `POST`.
   - It expects a `Request` object and a `GeometryCalculator` object to be passed as dependencies.
   - The request payload is decoded from JSON format using the `json_decode()` function with the second argument set to `true`, which returns an associative array.
   - Two sets of triangle side lengths are extracted from the payload.
   - Two `Triangle` objects are created using the side lengths extracted from the payload.
   - The `sumAreas()` and `sumDiameters()` methods of the `GeometryCalculator` service are called, passing the two triangle objects as arguments.
   - The results of the calculations, the total areas and total diameters, are returned as a JSON response.

The `TriangleController` class follows the Symfony controller convention and utilizes annotations for route mapping. It uses the `Triangle` entity class to create triangle objects and the `GeometryCalculator` service to perform calculations on those objects.

**History.php Entity class**

```php
<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\SerializedName;
use App\Repository\HistoryRepository;

#[ORM\Entity(repositoryClass: HistoryRepository::class)]
class History
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'json')]
    private string $request;

    #[ORM\Column(type: 'json')]
    private string $response;

    #[ORM\Column(type: 'datetime')]
    #[SerializedName('createdAt')]
    private \DateTimeInterface $createdAt;

    public function __construct(string $request, string $response)
    {
        $this->request = $request;
        $this->response = $response;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getRequest(): string
    {
        return $this->request;
    }

    public function getResponse(): string
    {
        return $this->response;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }
}
```

The `History` class represents a historical record of a request and its corresponding response in the application.

The class has the following properties:

- `id`: An integer property representing the unique identifier of the history record.
- `request`: A string property that stores the JSON-encoded request data.
- `response`: A string property that stores the JSON-encoded response data.
- `createdAt`: A `\DateTimeInterface` property that stores the timestamp of when the history record was created.

The class is annotated with `@ORM\Entity` to indicate that it is an entity managed by Doctrine ORM. The associated repository class is specified as `HistoryRepository`.

The `id` property is marked with `@ORM\Id` to indicate that it is the primary key. It is also annotated with `@ORM\GeneratedValue` to specify that the value is auto-generated. The column type is defined as `integer`.

The `request` and `response` properties are annotated with `@ORM\Column` to define their column types as `json`.

The `createdAt` property is annotated with `@ORM\Column` to define its column type as `datetime`. Additionally, the `@SerializedName` annotation is used to specify the serialized name as `createdAt` during serialization/deserialization.

The class has a constructor that accepts the request and response as arguments. It initializes the properties with the provided values and sets the `createdAt` property to the current timestamp using `\DateTimeImmutable()`.

Getter methods are provided for accessing the private properties: `getId()`, `getRequest()`, `getResponse()`, and `getCreatedAt()`.

**HistoryRepositoryInterface.php Interface**

```php
<?php

namespace App\Repository;

use App\Entity\History;

interface HistoryRepositoryInterface
{
    public function save(History $history): void;
    public function findAll(): array;
}
```

The `HistoryRepositoryInterface` is an interface that defines the contract for a repository responsible for storing and retrieving `History` entities.

The interface declares two methods:

1. `save(History $history): void`: This method is responsible for saving a `History` entity to the repository. It takes a `History` object as a parameter and does not return any value. It is used to persist a history record in the underlying storage.

2. `findAll(): array`: This method is used to retrieve all `History` entities from the repository. It returns an array containing all the history records stored in the repository.

By defining this interface, it allows for abstraction and loose coupling between the application's code and the actual implementation of the repository. Different implementations of the `HistoryRepositoryInterface` can be created to work with different storage systems (e.g., MySQL, MongoDB) while adhering to the same contract.

**HistoryRepository.php Repository class**

```php
<?php

namespace App\Repository;

use App\Entity\History;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class HistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, History::class);
    }

    public function save(History $history): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($history);
        $entityManager->flush();
    }

    public function findAll(): array
    {
        return $this->createQueryBuilder('h')
            ->getQuery()
            ->getResult();
    }
}
```

The `HistoryRepository` class is a repository implementation that extends the `ServiceEntityRepository` class provided by Doctrine. It is responsible for handling database operations related to the `History` entity.

Let's break down the code:

1. The class extends the `ServiceEntityRepository` class and specifies the entity class it will be working with (`History::class`) in the constructor using the `parent::__construct()` method.

2. The constructor takes a `ManagerRegistry` object as a parameter, which is used to obtain the entity manager and registry from Doctrine.

3. The `save()` method is responsible for persisting a `History` entity to the database. It gets the entity manager using `$this->getEntityManager()` and then uses the `persist()` and `flush()` methods to save the entity.

4. The `findAll()` method retrieves all `History` entities from the database. It uses the `createQueryBuilder()` method to create a query builder instance, specifying 'h' as the alias for the `History` entity. Then, it calls `getQuery()` to obtain the Doctrine query object, and finally, `getResult()` to execute the query and fetch the results as an array.

By extending the `ServiceEntityRepository` class, the `HistoryRepository` class inherits convenient methods provided by Doctrine for querying and manipulating entities. The `save()` method allows us to persist `History` entities, and the `findAll()` method provides a way to retrieve all `History` entities from the database.

**MySqlAdapter.php Adapter class**

```php
<?php

namespace App\Adapter;

use App\Entity\History;
use App\Repository\HistoryRepositoryInterface;
use App\Repository\HistoryRepository;
use Doctrine\Persistence\ManagerRegistry;

class MySqlAdapter implements HistoryRepositoryInterface
{
    private HistoryRepository $historyRepository;

    public function __construct(ManagerRegistry $registry)
    {
        $this->historyRepository = $registry->getRepository(History::class);
    }

    public function save(History $history): void
    {
        $this->historyRepository->save($history);
    }

    public function findAll(): array
    {
        return $this->historyRepository->findAll();
    }
}
```

The `MySqlAdapter` class is an implementation of the `HistoryRepositoryInterface` that adapts the `HistoryRepository` class to work with a MySQL database using Doctrine.

Let's go through the code:

1. The class implements the `HistoryRepositoryInterface` and provides the required methods: `save()` and `findAll()`.

2. The class has a dependency on the `HistoryRepository`, which is injected via the constructor. This repository is responsible for handling the database operations.

3. In the constructor, an instance of `HistoryRepository` is obtained from the `ManagerRegistry` using the `getRepository()` method. This allows us to access the `HistoryRepository` methods for interacting with the MySQL database.

4. The `save()` method delegates the responsibility of saving a `History` entity to the `historyRepository` object. It simply calls the `save()` method of the `HistoryRepository` class, passing the `History` object as a parameter.

5. The `findAll()` method delegates the responsibility of retrieving all `History` entities from the database to the `historyRepository` object. It calls the `findAll()` method of the `HistoryRepository` class and returns the result.

By using the `MySqlAdapter` class, we can interact with the `HistoryRepository` and perform database operations specific to a MySQL database. This adapter allows us to decouple the application code from the underlying persistence mechanism and provides a unified interface through the `HistoryRepositoryInterface`.

**HistoryService.php Service class**

```php
<?php

namespace App\Service;

use App\Entity\History;
use App\Repository\HistoryRepositoryInterface;

class HistoryService
{
    private HistoryRepositoryInterface $historyRepository;

    public function __construct(HistoryRepositoryInterface $historyRepository)
    {
        $this->historyRepository = $historyRepository;
    }

    public function saveHistory(string $request, string $response): void
    {
        $history = new History($request, $response);
        $this->historyRepository->save($history);
    }

    public function getAllHistory(): array
    {
        return $this->historyRepository->findAll();
    }
}
```

The `HistoryService` class is a service class that provides methods for saving and retrieving `History` records using a `HistoryRepositoryInterface`.

Let's go through the code:

1. The class defines a private property `$historyRepository` of type `HistoryRepositoryInterface`, which will be used to interact with the persistence layer.

2. The constructor takes a `HistoryRepositoryInterface` object as a parameter and assigns it to the `$historyRepository` property.

3. The `saveHistory()` method is responsible for creating a new `History` entity using the provided `$request` and `$response` parameters. It then calls the `save()` method on the `$historyRepository` to persist the `History` entity in the underlying data storage.

4. The `getAllHistory()` method retrieves all `History` records from the underlying data storage by calling the `findAll()` method on the `$historyRepository`. It returns an array containing all the retrieved `History` records.

By encapsulating the logic for saving and retrieving `History` records within the `HistoryService` class, it provides a clear and reusable interface for interacting with the `History` functionality. It abstracts away the underlying persistence implementation through the use of the `HistoryRepositoryInterface`, allowing for flexibility and easier testing and maintenance.

**Adapter pattern**

The Adapter pattern is utilized to adapt the `HistoryRepositoryInterface` to work with different data storage implementations, such as MySQL or MongoDB. Here's how it is applied:

1. **HistoryRepositoryInterface**: This interface defines the contract for interacting with `History` records, providing methods like `save()` and `findAll()`. It serves as the target interface for the Adapter pattern.

2. **HistoryRepository**: This class implements the `HistoryRepositoryInterface` and provides the core logic for interacting with the underlying data storage. In this case, it includes methods like `save()` and `findAll()` that work with Doctrine and MySQL.

3. **MySqlAdapter**: This class acts as an adapter that implements the `HistoryRepositoryInterface` and adapts it to work specifically with MySQL. It wraps the `HistoryRepository` and delegates the method calls to the corresponding methods in the repository. The `MySqlAdapter` essentially bridges the gap between the target interface (`HistoryRepositoryInterface`) and the specific MySQL implementation (`HistoryRepository`).

4. **HistoryService**: This class is a service that depends on the `HistoryRepositoryInterface`. It is decoupled from the specific implementation details of the repository. Instead, it relies on the abstract interface to perform operations on `History` records. The `HistoryService` doesn't need to know about the underlying data storage, whether it's MySQL or any other adapter implementation.

By using the Adapter pattern in this context, you can easily switch between different data storage implementations by providing the corresponding adapter. For example, if you want to switch from MySQL to MongoDB, you can create a `MongoDbAdapter` that implements the `HistoryRepositoryInterface` and adapts it to work with MongoDB. The `HistoryService` can then use the `MongoDbAdapter` without any changes.

**HistoryController.php Controller class**

```php
<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Service\HistoryService;

class HistoryController extends AbstractController
{
    private $historyService;

    public function __construct(HistoryService $historyService)
    {
        $this->historyService = $historyService;
    }

    #[Route('/history', methods: ["GET"], name: 'app_history')]
    public function index(): JsonResponse
    {
        $history = $this->historyService->getAllHistory();

        $response = [];
        foreach ($history as $record) {
            $response[] = [
                'id' => $record->getId(),
                'request' => $record->getRequest(),
                'response' => $record->getResponse(),
                'createdAt' => $record->getCreatedAt()->format('Y-m-d H:i:s')
            ];
        }

        return $this->json($response);
    }
}
```

The `HistoryController` class is responsible for handling HTTP requests related to the history records. It depends on the `HistoryService` to retrieve the history records and format them for the response.

- **Inheritance**: The class extends the `AbstractController` class provided by Symfony, which provides convenient methods for working with controllers.

- **Constructor**: The class defines a constructor that injects an instance of the `HistoryService` into the controller. This is done via dependency injection, allowing the controller to utilize the functionality of the `HistoryService`.

- **Route Annotation**: The controller method is annotated with `#[Route]` to define the route at which the method will be accessible. In this case, the endpoint is `/history`, and it only accepts GET requests. The name of the route is set to `'app_history'`.

- **index() Method**: This method is invoked when a GET request is made to the `/history` endpoint. It retrieves all the history records using the `HistoryService` by calling the `getAllHistory()` method.

- **Formatting the Response**: The retrieved history records are then transformed into a format suitable for the response. Each record is looped over, and the relevant information such as ID, request, response, and createdAt are extracted and added to an array.

- **Returning the Response**: The final response is generated by calling `$this->json($response)`, which converts the formatted array into a JSON response and returns it to the client.

## Tests

The tests are organized into separate test files, each containing test cases for specific classes or features. These test files follow the naming convention of <ClassName>Test.php to indicate the class being tested.

![Test folder](./docs/implemented_tests.PNG)

### Running the Tests

To execute the tests, you can use PHPUnit, a popular testing framework for PHP. Make sure PHPUnit is installed either globally or as a development dependency in your project.

To run all the tests, open a terminal, navigate to the root directory of your project, and execute the following command:

`php bin/phpunit --testdox`

![Test execution](./docs/test_execution.PNG)

## Docker

**Dockerfile**

```console
FROM php:8.1-fpm

# Copy composer.lock and composer.json
COPY composer.lock composer.json /var/www/

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libwebp-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libzip-dev \
    libonig-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-jpeg=/usr/include/ --with-freetype=/usr/include/
RUN docker-php-ext-install gd

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY . /var/www

# Copy existing application directory permissions
COPY --chown=www:www . /var/www

# Change current user to www
USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
```

**docker-compose.yml file**

```console
version: "3"
services:
  api:
    build:
      context: .
      dockerfile: Dockerfile
    image: digitalocean.com/php
    container_name: api
    restart: unless-stopped
    tty: true
    environment:
      SERVICE_NAME: api
      SERVICE_TAGS: dev
      APP_SECRET: c59387f2053b64e77fce3d67c3e2f399
      DATABASE_URL: "mysql://root:horus@db:3306/horus?serverVersion=8&charset=utf8mb4&allowPublicKeyRetrieval=true&useSSL=false"
    working_dir: /var/www
    volumes:
      - ./:/var/www
      - ./php/local.ini:/usr/local/etc/php/conf.d/local.ini
    networks:
      - horusnet

  server:
    image: nginx:alpine
    container_name: server
    restart: unless-stopped
    tty: true
    ports:
      - "80:80"
      - "443:443"
    volumes:
      - ./:/var/www
      - ./nginx/conf.d/:/etc/nginx/conf.d/
    networks:
      - horusnet

  db:
    image: mysql:8.0.29
    container_name: db
    restart: unless-stopped
    tty: true
    ports:
      - "3306:3306"
    environment:
      MYSQL_DATABASE: horus
      MYSQL_ROOT_PASSWORD: horus
      SERVICE_TAGS: dev
      SERVICE_NAME: mysql
    volumes:
      - dbdata:/var/lib/mysql/
      - ./mysql/my.cnf:/etc/my.cnf
      - ./mysql/dump:/docker-entrypoint-initdb.d
    networks:
      - horusnet

networks:
  horusnet:
    driver: bridge

volumes:
  dbdata:
    driver: local

```

The `docker-compose.yml` file is used to define and configure multiple services that make up an application and their dependencies. Let's go through the different sections and their explanations:

- **Services**: Defines the services that will be created and run.

  - **api**: Specifies the configuration for the `api` service.

    - **Build**: Configures the build context and Dockerfile for building the image. The `context` is set to the current directory (`.`) and the `dockerfile` is set to `Dockerfile`.

    - **Image**: Specifies the image to use for the service. In this case, it is `digitalocean.com/php`.

    - **Container_name**: Sets the name of the container to `api`.

    - **Restart**: Specifies the restart policy for the container. It is set to `unless-stopped`, which means the container will be restarted unless explicitly stopped.

    - **Tty**: Allocates a pseudo-TTY for the container.

    - **Environment**: Defines environment variables for the container. Here, several environment variables like `SERVICE_NAME`, `SERVICE_TAGS`, `APP_SECRET`, and `DATABASE_URL` are set.

    - **Working_dir**: Sets the working directory inside the container to `/var/www`.

    - **Volumes**: Maps local directories to container directories. The first volume mapping (`./:/var/www`) maps the current directory to `/var/www` inside the container. The second volume mapping (`./php/local.ini:/usr/local/etc/php/conf.d/local.ini`) maps a local PHP configuration file to the corresponding container location.

    - **Networks**: Specifies the networks to which the container is attached. Here, it is attached to the `horusnet` network.

  - **server**: Specifies the configuration for the `server` service.

    - **Image**: Specifies the image to use for the service. In this case, it is `nginx:alpine`.

    - **Container_name**: Sets the name of the container to `server`.

    - **Restart**: Specifies the restart policy for the container. It is set to `unless-stopped`.

    - **Tty**: Allocates a pseudo-TTY for the container.

    - **Ports**: Maps container ports to host ports. Here, port 80 and 443 of the host are mapped to the corresponding container ports.

    - **Volumes**: Maps local directories to container directories. The first volume mapping (`./:/var/www`) maps the current directory to `/var/www` inside the container. The second volume mapping (`./nginx/conf.d/:/etc/nginx/conf.d/`) maps a local Nginx configuration directory to the corresponding container location.

    - **Networks**: Specifies the networks to which the container is attached. Here, it is attached to the `horusnet` network.

  - **db**: Specifies the configuration for the `db` service.

    - **Image**: Specifies the image to use for the service. In this case, it is `mysql:8.0.29`.

    - **Container_name**: Sets the name of the container to `db`.

    - **Restart**: Specifies the restart policy for the container. It is set to `unless-stopped`.

    - **Tty**: Allocates a pseudo-TTY for the container.

    - **Ports**: Maps container ports to host ports. Here, port 3306 of the host is mapped to the corresponding container port.

    - **Environment**: Defines environment variables for the container. Variables like `MYSQL_DATABASE`, `MYSQL_ROOT_PASSWORD`, `SERVICE_TAGS`, and `SERVICE_NAME` are set.

    - \*\*

Volumes\*\*: Maps local directories to container directories. The first volume mapping (`dbdata:/var/lib/mysql/`) maps a named volume `dbdata` to the MySQL data directory. The second volume mapping (`./mysql/my.cnf:/etc/my.cnf`) maps a local MySQL configuration file to the corresponding container location. The third volume mapping (`./mysql/dump:/docker-entrypoint-initdb.d`) maps a local directory containing SQL dump files to the container's initialization directory.

    - **Networks**: Specifies the networks to which the container is attached. Here, it is attached to the `horusnet` network.

- **Networks**: Defines the networks that will be created.

  - **horusnet**: Specifies the configuration for the `horusnet` network.

    - **Driver**: Sets the network driver to `bridge`, which is the default network driver.

- **Volumes**: Defines named volumes that can be used by the services.

  - **dbdata**: Specifies the configuration for the `dbdata` volume. The `driver` is set to `local`, indicating that the volume is managed locally.

This `docker-compose.yml` file allows you to define and manage multiple services (API, server, and database) for your application, configure their dependencies, and map local directories and ports to the corresponding container locations. It provides a convenient way to start and manage all the required containers as a single unit.
