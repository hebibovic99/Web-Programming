<?php

require_once './services/UserServices.php';

/**
 * @OA\Post(
 *     path="/register",
 *     tags={"User"},
 *     summary="Register a new user",
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="firstName",
 *                     type="string",
 *                 ),
 * @OA\Property(
 *                     property="lastName",
 *                     type="string",
 *                 ),
 *                 @OA\Property(
 *                     property="email",
 *                     type="string",
 *                 ),
 *                 @OA\Property(
 *                     property="password",
 *                     type="string",
 *                 ),
 *             ),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *             ),
 *         ),
 *     ),
 * )
 */
Flight::route('POST /register', function(){
    $firstName = Flight::request()->data['firstName'];
    $lastName = Flight::request()->data['lastName'];
    $email = Flight::request()->data['email'];
    $password = Flight::request()->data['password'];
  
    $userServices = new UserServices(Flight::get('pdo'));
    $message = $userServices->registerUser($firstName, $lastName, $email, $password);
  
    Flight::json(array('message' => $message), 200);
});

/**
 * @OA\Post(
 *     path="/login",
 *     tags={"User"},
 *     summary="User login",
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="email",
 *                     type="string",
 *                 ),
 *                 @OA\Property(
 *                     property="password",
 *                     type="string",
 *                 ),
 *             ),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="token",
 *                 type="string",
 *             ),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Invalid credentials",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *             ),
 *         ),
 *     ),
 * )
 */
Flight::route('POST /login', function(){
    $email = Flight::request()->data['email'];
    $password = Flight::request()->data['password'];
  
    $userServices = new UserServices(Flight::get('pdo'));
    try {
        $jwt = $userServices->loginUser($email, $password);
        Flight::json(['token' => $jwt]);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 401);
    }
});

Flight::route('POST /logout', function(){
    // Clear the user session
    session_unset();
    session_destroy();

    // Send a success response
    Flight::json(array('message' => 'Logout successful'), 200);
});

?>
