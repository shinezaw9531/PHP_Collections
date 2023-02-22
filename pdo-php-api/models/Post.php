<?php

error_reporting(E_ALL);
ini_set('display_error',1);

class Post{
    // Post Properties
    public $id;
    public $category_id;
    public $title;
    public $description;
    public $creted_at;

    // Database Data
    private $connetion;
    private $table = 'posts';

    public function __construct($db){
        $this->connection = $db;
    }

    // Method to read all the saved posts from database
    public function readPosts(){
        // Query for reading posts from table
        $query = 'SELECT 
            category.name as category,
            posts.id,
            posts.title,
            posts.description,
            posts.category_id,
            posts.created_at
            FROM '.$this->table.' posts LEFT JOIN
            category ON posts.category_id = category.id
            ORDER BY
                posts.created_at DESC
        ';

        $post = $this->connection->prepare($query);
        $post->execute();
        return $post;
    }

    // Method for reading single post.
    public function read_single_post($id){
        $this->id = $id;

        //Query for reading posts from table.
        
        $query = 'SELECT
            category.name as category,
            posts.id,
            posts.title,
            posts.description,
            posts.category_id,
            posts.created_at
            FROM '.$this->table.' posts LEFT JOIN
            category ON posts.category_id = category.id
            WHERE posts.id=?
            LIMIT 0,1
        ';

        $post = $this->connection->prepare($query);

       
        // $post->bindValue('id', $this->id, PDO::PARAM_INT);
        // $post->execute();

        //$post->execute([$this->id]);
        $post->bindValue(1, $this->id, PDO::PARAM_INT);
        $post->execute();
        return $post;
    }


    // Method to create new records.

    public function create_new_post($params){
        try
        {
            // Assigning values.

            $this->title = $params['title'];
            $this->description = $params['description'];
            $this->category_id = $params['category_id'];

            // Query to store new post in database.

            $query = 'INSERT INTO '. $this->table .'
                    SET 
                     title = :title,
                     category_id = :category_id,
                     description = :details';
            
            $post = $this->connection->prepare($query);

            $post->bindValue('title', $this->title);
            $post->bindValue('details', $this->description);
            $post->bindValue('category_id', $this->category_id);


            if($post->execute())
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

    // Method for updating posts.

    public function update($params){
        try
        {
              // Assigning values.

              $this->id = $params['id'];
              $this->title = $params['title'];
              $this->description = $params['description'];
              $this->category_id = $params['category_id'];

              $dataExist = $this->data_exist($this->id);

              if($dataExist>0){
                // Query for updating existing record.

                $query = 'UPDATE '.$this->table.' 
                SET
                    title = :title,
                    category_id = :category_id,
                    description = :details 
                    WHERE id = :id';

                $post = $this->connection->prepare($query);

                $post->bindValue('id', $this->id);
                $post->bindValue('title', $this->title);
                $post->bindValue('details', $this->description);
                $post->bindValue('category_id', $this->category_id);

                if($post->execute())
                {
                    return true;
                }
              }

              return false;
        }
        catch(PDOExecption $e)
        {
            echo $e->getMessage();
        }
    }

    // Method to delete post from database.

    public function destroy_post($id){
        try
        {
            // Assigning values.

            $this->id = $id;
            
            $dataExist = $this->data_exist($this->id);

            if($dataExist>0){
                // Query for updating existing record.

                $query = 'DELETE FROM '.$this->table.' 
                WHERE id = :id';

                $post = $this->connection->prepare($query);

                $post->bindValue('id', $this->id);
                
                if($post->execute())
                {
                    return true;
                }
            }

            return false;
        }
        catch(PDOExecption $e)
        {
            echo $e->getMessage();
        } 
    }


    public function data_exist($id){
        $sql = $this->connection->prepare("SELECT COUNT(*) AS `total` FROM posts WHERE id = :id");
        $sql->execute(array(':id' => $this->id));
        $result = $sql->fetchObject();
        return $result->total;
    }


}

?>