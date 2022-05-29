<?php 

/**
 * Get the post record based on the ID
 *
 * @param object $conn Connection to the database
 * @param integer $id the article ID
 * @param string $columns Optional list of columns for the select, defaults to *
 * 
 * @return mixed An associative array containing the post with that ID, or null if not found
 */

function getPostId($conn, $id, $columns = '*') {

    $sql = "SELECT $columns
    FROM post
    WHERE id = :id";

   $stmt = $conn->prepare($sql);

   $stmt->bindValue(':id', $id, PDO::PARAM_INT);

   if ($stmt->execute()) {

       return $stmt->fetch(PDO::FETCH_ASSOC);

   }
}

?>


