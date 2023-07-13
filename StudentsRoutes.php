<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once './dao/BaseDao.class.php';
require_once './dao/StudentsDao.class.php';

/**
 * @OA\Get(
 *     path="/students",
 *     tags={"Students"},
 *     summary="Get all students",
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation"
 *     )
 * )
 */
Flight::route('GET /students', function(){
    $studentsDao = new StudentsDao();
    Flight::json($studentsDao->getAllStudents());
});

/**
 * @OA\Get(
 *     path="/students/{id}",
*     tags={"Students"},
 *     summary="Get a student by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Student ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation"
 *     )
 * )
 */
Flight::route('GET /students/@id', function($id){
    $studentsDao = new StudentsDao();
    Flight::json($studentsDao->get_by_id($id));
});

/**
 * @OA\Post(
 *     path="/students",
 *     summary="Add a new student",
*      tags={"Students"},
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="FirstName",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="LastName",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="Grade",
 *                     type="integer"
 *                 ),
 *                 @OA\Property(
 *                     property="Description",
 *                     type="string"
 * 
 *                 ),
 *                  @OA\Property(
 *                     property="Address",
 *                     type="string"
 *             ),
 *         ),
 *     ),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation"
 *     )
 * )
 */
Flight::route('POST /students', function(){
    $request = Flight::request();
    $data = $request->data->getData();
    $studentsDao = new StudentsDao();
    $studentsDao->addStudent($data['FirstName'], $data['LastName'], $data['Grade'], $data['Description'], $data['Nickname']);
    Flight::json($data);
});

/**
 * @OA\Put(
 *     path="/edit_students/{id}",
 *     summary="Update a student",
*      tags={"Students"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Student ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation"
 *     )
 * )
 */
Flight::route('PUT /edit_students/@id', function($id){
    $request = Flight::request();
    $data = $request->data->getData();
    $studentsDao = new StudentsDao();
    $studentsDao->updateStudent($id, $data, $description, $grade);
    Flight::json($data);
});

/**
 * @OA\Delete(
 *     path="/students/{id}",
 *     summary="Delete a student",
 *     tags={"Students"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Student ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation"
 *     )
 * )
 */
Flight::route('DELETE /students/@id', function($id){
    $studentsDao = new StudentsDao();
    $studentsDao->delete($id);
    Flight::json(["message" => "deleted"]);
});
?>
