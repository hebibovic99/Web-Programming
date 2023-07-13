<?php

require_once './dao/StudentInfoDao.class.php';

/**
 * @OA\Get(
 *     path="/students_info1",
 *     summary="Get all student Info",
 *     tags={"Student Info1"},
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation"
 *     )
 * )
 */
Flight::route('GET /students_info', function(){
    $studentsInfoDao = new StudentInfoDao();
    Flight::json($studentsInfoDao->getAllStudents());
});

?>
