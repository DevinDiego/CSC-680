<?php 


/**
 * Post
 *
 * A piece of writing for publication
 */
class Post {

	/**
     * Unique identifier
     * @var integer
     */
	public $id;


	/**
     * The post title
     * @var string
     */
	public $post_title;


	/**
     * The post body
     * @var string
     */
	public $post_body;


	/**
     * The publication date and time
     * @var datetime
     */
	public $published_at;

	/**
     * Path to the image
     * @var string
     */
	public $image_file;

	/**
     * Validation errors
     * @var array
     */
	public $errors = [];


	/**
     * Get all the posts
     *
     * @param object $conn Connection to the database
     *
     * @return array An associative array of all the post records
     */

	public static function getAllPosts($conn) {

		$sql = "SELECT *
		FROM post
		ORDER BY published_at DESC;";

		$results = $conn->query($sql);

		return $results->fetchAll(PDO::FETCH_ASSOC);
	}



	/**
     * Get a page of articles
     *
     * @param object $conn Connection to the database
     * @param integer $limit Number of records to return
     * @param integer $offset Number of records to skip
     *
     * @return array An associative array of the page of article records
     */
	
	public static function getPage($conn, $limit, $offset)
	{
		$sql = "SELECT *
		FROM post
		ORDER BY published_at
		LIMIT :limit
		OFFSET :offset";

		$stmt = $conn->prepare($sql);

		$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
		$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

		$stmt->execute();

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}



	/**
 * Get the post record based on the ID
 *
 * @param object $conn Connection to the database
 * @param integer $id the article ID
 * @param string $columns Optional list of columns for the select, defaults to *
 * 
 * @return mixed an Object of this class, or null if not found
 */

	public static function getPostId($conn, $id, $columns = '*') {

		$sql = "SELECT $columns
		FROM post
		WHERE id = :id";

		$stmt = $conn->prepare($sql);

		$stmt->bindValue(':id', $id, PDO::PARAM_INT);

		$stmt->setFetchMode(PDO::FETCH_CLASS, 'Post');

		if ($stmt->execute()) {

			return $stmt->fetch();

		}
	}


	/**
     * Get the post record based on the ID along with associated categories, if any
     *
     * @param object $conn Connection to the database
     * @param integer $id the article ID
     *
     * @return array The post data with categories
     */
    public static function getWithCategories($conn, $id)
    {
        $sql = "SELECT post.*, category.name AS category_name
                FROM post
                LEFT JOIN post_category
                ON post.id = post_category.post_id
                LEFT JOIN category
                ON post_category.category_id = category.id
                WHERE post.id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * Get the post's categories
     *
     * @param object $conn Connection to the database
     *
     * @return array The category data
     */
    public function getCategories($conn)
    {
        $sql = "SELECT category.*
                FROM category
                JOIN post_category
                ON category.id = post_category.category_id
                WHERE post_id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


	/**
     * Update the post with its current property values
     *
     * @param object $conn Connection to the database
     *
     * @return boolean True if the update was successful, false otherwise
     */
	public function update($conn) {

		if ($this->validate()) {

			$sql = "UPDATE post
			SET post_title = :post_title,
			post_body = :post_body,
			published_at = :published_at
			WHERE id = :id";

			$stmt = $conn->prepare($sql);

			$stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
			$stmt->bindValue(':post_title', $this->post_title, PDO::PARAM_STR);
			$stmt->bindValue(':post_body', $this->post_body, PDO::PARAM_STR);

			if ($this->published_at == '') {
				$stmt->bindValue(':published_at', null, PDO::PARAM_NULL);
			} else {
				$stmt->bindValue(':published_at', $this->published_at, PDO::PARAM_STR);
			}

			return $stmt->execute();

		} else {

			return false;
		}

	}


	/**
     * Validate the properties, putting any validation error messages in the $errors property
     *
     * @return boolean True if the current properties are valid, false otherwise
     */

	protected function validate () {		

		if ($this->post_title == '') {

			$this->errors[] = 'Please enter the post title!';
		}

		if ($this->post_body == '') {

			$this->errors[] = 'Please provide a body for your post!';
		}

		if ($this->published_at == null) {

			$this->errors[] = 'Please select a date and time!';
		}

		return empty($this->errors);
	}


	/**
     * Delete the current post
     *
     * @param object $conn Connection to the database
     *
     * @return boolean True if the delete was successful, false otherwise
     */

	public function delete($conn) {

		$sql = "DELETE FROM post
		WHERE id = :id";

		$stmt = $conn->prepare($sql);

		$stmt->bindValue(':id', $this->id, PDO::PARAM_INT);			

		return $stmt->execute();

	}
	

	/**
     * Update the post with its current property values
     *
     * @param object $conn Connection to the database
     *
     * @return boolean True if the update was successful, false otherwise
     */

	public function create($conn) {

		if ($this->validate()) {

			$sql = "INSERT INTO post (post_title, post_body, published_at)
			VALUES (:post_title, :post_body, :published_at)";

			$stmt = $conn->prepare($sql);
			
			$stmt->bindValue(':post_title', $this->post_title, PDO::PARAM_STR);
			$stmt->bindValue(':post_body', $this->post_body, PDO::PARAM_STR);

			if ($this->published_at == '') {
				$stmt->bindValue(':published_at', null, PDO::PARAM_NULL);
			} else {
				$stmt->bindValue(':published_at', $this->published_at, PDO::PARAM_STR);
			}

			if ($stmt->execute()) {

				$this->id = $conn->lastInsertId();
				return true;
				
			} else {

				return false;
			}
		}
	}

	/**
     * Get a count of the total number of records
     *
     * @param object $conn Connection to the database
     *
     * @return integer The total number of records
     */
	
	public static function getTotal($conn) {

		return $conn->query('SELECT COUNT(*) FROM post')->fetchColumn();
	}


	/**
     * Update the image file property
     *
     * @param object $conn Connection to the database
     * @param string $filename The filename of the image file
     *
     * @return boolean True if it was successful, false otherwise
     */
	public function setImageFile($conn, $filename) {
		
		$sql = "UPDATE post
		SET image_file = :image_file
		WHERE id = :id";

		$stmt = $conn->prepare($sql);

		$stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
		$stmt->bindValue(':image_file', $filename, $filename == null ? PDO::PARAM_NULL : PDO::PARAM_STR);

		return $stmt->execute();
	}
}

?>