<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "./dao/BaseDao.class.php";

class DictionaryDao extends BaseDao{
    public function __construct() {
        parent::__construct('dictionary');
    }

    public function addDictionary($signLanguage, $word, $phrase, $image) {
        // Prepare an SQL insert statement
        $insertStmt = $this->conn->prepare("INSERT INTO dictionary (sign_language, word, phrase, image) VALUES (:signLanguage, :word, :phrase, :image)");
    
        // Bind the values to the statement
        $insertStmt->bindParam(':signLanguage', $signLanguage);
        $insertStmt->bindParam(':word', $word);
        $insertStmt->bindParam(':phrase', $phrase);
        $insertStmt->bindParam(':image', $image, PDO::PARAM_LOB);
    
        // Execute the statement
        $insertStmt->execute();
    
        // If insertion is successful, return with a success message
        if ($insertStmt->rowCount() > 0) {
            return "Dictionary entry added successfully";
        } else {
            return "Failed to add dictionary entry";
        }
    }

    public function updateDictionaryImage($dictionaryId, $image) {
        // Prepare an SQL update statement
        $updateStmt = $this->conn->prepare("UPDATE dictionary SET image = :image WHERE id = :id");
    
        // Bind the values to the statement
        $updateStmt->bindParam(':id', $dictionaryId);
        $updateStmt->bindParam(':image', $image, PDO::PARAM_LOB);
    
        // Execute the statement
        $updateStmt->execute();
    
        // If update is successful, return with a success message
        if ($updateStmt->rowCount() > 0) {
            return "Dictionary entry updated successfully";
        } else {
            return "Failed to update dictionary entry";
        }
    }

    public function deleteDictionary($dictionaryId) {
        // Prepare an SQL delete statement
        $deleteStmt = $this->conn->prepare("DELETE FROM dictionary WHERE id = :id");

        // Bind the value to the statement
        $deleteStmt->bindParam(':id', $dictionaryId);

        // Execute the statement
        $deleteStmt->execute();

        // If deletion is successful, return with a success message
        if ($deleteStmt->rowCount() > 0) {
            return "Dictionary entry deleted successfully";
        } else {
            return "Failed to delete dictionary entry";
        }
    }

    public function getAllDictionaries() {
        // Prepare an SQL select statement to retrieve all dictionary entries
        $selectStmt = $this->conn->prepare("SELECT * FROM dictionary");
        $selectStmt->execute();

        // Fetch all dictionary entries as an associative array
        $entries = $selectStmt->fetchAll(PDO::FETCH_ASSOC);

        return $entries;
    }
}

?>