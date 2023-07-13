<?php

require_once './services/ContactService.php';

/**
 * @OA\Post(
 *     path="/contact",
 * security={{"bearerAuth":{}}},
 *     tags={"Contact"},
 *     summary="Send a message",
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="name",
 *                     type="string",
 *                 ),
 *                 @OA\Property(
 *                     property="email",
 *                     type="string",
 *                 ),
 *                 @OA\Property(
 *                     property="subject",
 *                     type="string",
 *                 ),
 *                 @OA\Property(
 *                     property="message",
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
 *     @OA\Response(
 *         response=500,
 *         description="Failed to send message",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *             ),
 *         ),
 *     ),
 * )
 */
Flight::route('POST /contact', function(){
    $name = Flight::request()->data['name'];
    $email = Flight::request()->data['email'];
    $number = Flight::request()->data['number'];
    $subject = Flight::request()->data['subject'];

    $contactServices = new ContactService();
    $message = $contactServices->saveContact($name, $email, $number, $subject);

    Flight::json(array('message' => $message), 200);
});

?>