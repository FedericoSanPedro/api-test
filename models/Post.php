<?php
error_reporting(E_ALL);
ini_set('display_error', 1);

/**
 * @OA\Info(title="My First API", version="1.0")
 */
class Post {
    // Database data.
    private $connection;
    private $table = 'post';


    // Post Properties
    public $id;
    public $category_id;
    public $title;
    public $description;


    public function __construct($db)
    {
        $this->connection = $db; 
    }
    
/**
     * @OA\Get(
     *     path="/api-test/api/post/posts.php",
     *     summary = "Get all posts",
     *     tags = {"Posts"},
     *     @OA\Response(response="200", description="An example resource"),
     *     @OA\Response(response="404", description="Not found"),
     * )
     */
    public function read()
    {
        // Query to get posts data.


        $query = 'SELECT 
            c.name as category,
            p.id,
            p.category_id,
            p.title,
            p.description
            FROM
            '.$this->table.' p  LEFT JOIN
            category c 
            ON p.category_id = c.id';


        $post = $this->connection->prepare($query);
        
        $post->execute();


        return $post;
    }

/**
     * @OA\Get(
     *     path="/api-test/api/post/single.php",
     *     summary = "Get one post",
     *         tags = {"Posts"},
     *         @OA\Parameter(
     *           name="id",
     *           in="query",
     *           required=true,
     *           description="Id passed to get data",
     *           @OA\Schema(
     *             type="string"
     *           )
     *         ),
     *     @OA\Response(response="200", description="An example resource"),
     *     @OA\Response(response="404", description="Not found"),
     * )
     */
    public function read_single_post($id)
    {
        $this->id = $id;
        // Query to get posts data.
        
        $query = 'SELECT 
            c.name as category,
            p.id,
            p.category_id,
            p.title,
            p.description
            FROM
            '.$this->table.' p LEFT JOIN
            category c 
            ON p.category_id = c.id
            WHERE p.id= ?
            LIMIT 0,1';
            
        $post = $this->connection->prepare($query);
        
        //$post->bindParam(9, $this->id);
        
        $post->execute([$this->id]);


        return $post;
       
    }

/**
     * @OA\Post(
     *     path="/api-test/api/post/insert.php",
     *     summary = "Create one post",
     *         tags = {"Posts"},
     *         @OA\RequestBody(
     *           @OA\MediaType(
     *             mediaType="multipart/form-data",
     *           @OA\Schema(
     *             @OA\Property(
     *                  property="title", 
     *                  type="string",
     *                  ),
     *                  
     *             @OA\Property(
     *                  property="description", 
     *                  type="string",
     *                  ),
     *             @OA\Property(
     *                  property="category_id", 
     *                  type="integer",
     *                  ),
     *              ),
     *           ),
     *         ),
     *     @OA\Response(response="200", description="An example resource"),
     *     @OA\Response(response="404", description="Not found"),
     * )
     */
    public function create_new_record($params)
    {
        try
        {
            $this->title       = $params['title'];
            $this->description = $params['description'];
            $this->category_id = $params['category_id'];
    
            $query = 'INSERT INTO '. $this->table .' 
                SET
                  title = :title,
                  category_id = :category_id,
                  description = :details';
           
            $statement = $this->connection->prepare($query);
                    
            $statement->bindValue('title', $this->title);
            $statement->bindValue('category_id', $this->category_id);
            $statement->bindValue('details', $this->description);
            
            if($statement->execute())
            {
                return true;
            }
    
            return false;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }


/**
     * @OA\Put(
     *     path="/api-test/api/post/update.php",
     *     summary = "Post update",
     *         tags = {"Posts"},
     *         @OA\RequestBody(
     *           @OA\MediaType(
     *             mediaType="json",
     *           @OA\Schema(
     *             @OA\Property(
     *                  property="id", 
     *                  type="integer",
     *                  ),
     *             @OA\Property(
     *                  property="title", 
     *                  type="string",
     *                  ),
     *                  
     *             @OA\Property(
     *                  property="description", 
     *                  type="string",
     *                  ),
     *             @OA\Property(
     *                  property="category_id", 
     *                  type="integer",
     *                  ),
     *              ),
     *           ),
     *         ),
     *     @OA\Response(response="200", description="An example resource"),
     *     @OA\Response(response="404", description="Not found"),
     * )
     */
    public function update_new_record($params)
    {
        try
        {
            $this->id          = $params['id'];
            $this->title       = $params['title'];
            $this->description = $params['description'];
            $this->category_id = $params['category_id'];
    
            $query = 'UPDATE '. $this->table .' 
                SET
                  title = :title,
                  category_id = :category_id,
                  description = :details
                WHERE id = :id';
           
            $statement = $this->connection->prepare($query);
            
            $statement->bindValue('id', $this->id);
            $statement->bindValue('title', $this->title);
            $statement->bindValue('category_id', $this->category_id);
            $statement->bindValue('details', $this->description);
            
            if($statement->execute())
            {
                return true;
            }
    
            return false;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

/**
     * @OA\Delete(
     *     path="/api-test/api/post/destroy.php",
     *     summary = "Destroy post",
     *         tags = {"Posts"},
     *        @OA\RequestBody(
     *           @OA\MediaType(
     *             mediaType="json",
     *           @OA\Schema(
     *             @OA\Property(
     *                  property="id", 
     *                  type="integer",
     *                  ),
     *              ),
     *           ),
     *         ),
     *     @OA\Response(response="200", description="An example resource"),
     *     @OA\Response(response="404", description="Not found"),
     * )
     */
    public function destroy_post($id){
        try 
        {
            $this->id = $id;
    
            $query = 'DELETE FROM '. $this->table .' 
                WHERE id = :id';
           
            $statement = $this->connection->prepare($query);
            
            $statement->bindValue('id', $this->id);
            
            if($statement->execute())
            {
                return true;
            }
    
            return false;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }
}