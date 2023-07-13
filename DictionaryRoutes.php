<?php

require_once './services/DictionaryServices.php';

/**
 * @OA\Get(
 *     path="/dictionary",
 *     tags={"dictionary"},
 *     summary="Get all dictionaries",
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation"
 *     )
 * )
 */
Flight::route('GET /dictionary', function(){
    $dictionaryServices = new DictionaryServices();
    $result = $dictionaryServices->getAllDictionaries();
  
    Flight::json($result, 200);
});

/**
 * @OA\Post(
 *     path="/add_dictionary",
 *     summary="Add a new dictionary entry",
 *     tags={"dictionary"},
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="sign_language",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="word",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="phrase",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="image",
 *                     type="string",
 *                     format="binary"
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation"
 *     )
 * )
*/
Flight::route('POST /add_dictionary', function(){
    $signLanguage = Flight::request()->data['sign_language'];
    $word = Flight::request()->data['word'];
    $phrase = Flight::request()->data['phrase'];
    $image = Flight::request()->files['image'];

    // Get the uploaded file
    $imageFile = $image['tmp_name'];

    // Check if a file was uploaded
    if (!empty($imageFile)) {
        // Read the file contents
        $imageData = file_get_contents($imageFile);

        // Encode the file data as base64
        $imageBase64 = base64_encode($imageData);
    } else {
        // Set a default value for image if no file was uploaded
        $imageBase64 = '';
    }
  
    $dictionaryServices = new DictionaryServices();
    $result = $dictionaryServices->addDictionary($signLanguage, $word, $phrase, $imageBase64);
  
    Flight::json(array('message' => $result), 200);
});

/**
 * @OA\Delete(
 *     path="/delete_dictionary/{id}",
 *     summary="Delete a dictionary entry",
 *     tags={"dictionary"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Dictionary ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation"
 *     )
 * )
 */
Flight::route('DELETE /delete_dictionary/@id', function($id){
    $dictionaryId = $id;
  
    $dictionaryServices = new DictionaryServices();
    $result = $dictionaryServices->deleteDictionary($dictionaryId);
  
    Flight::json(array('message' => $result), 200);
});


/**
 * @OA\Post(
 *     path="/update_image/{id}",
 *     summary="Update the image of a dictionary entry",
 *     tags={"dictionary"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Dictionary ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="image",
 *                     type="string",
 *                     format="binary"
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation"
 *     )
 * )
 */
Flight::route('POST /update_image/@id', function($id){
    $dictionaryId = $id;
    $image = Flight::request()->files['image'];

    // Get the uploaded file
    $imageFile = $image['tmp_name'];

    // Check if a file was uploaded
    if (!empty($imageFile)) {
        // Read the file contents
        $imageData = file_get_contents($image['tmp_name']);

        // Encode the file data as base64
        $imageBase64 = base64_encode($imageData);
    } else {
        // Set a default value for image if no file was uploaded
        $imageBase64 = '';
    }
  
    $dictionaryServices = new DictionaryServices();
    $result = $dictionaryServices->updateDictionaryImage($dictionaryId, $imageBase64);
  
    Flight::json(array('message' => $result), 200);
});

?>
