<?php 
// creando el primer EndPoint

//header info about the endpoint

header('Content-Type: application/json');
$endpoint = $_SERVER['REQUEST_URI'];


// probar base de datos

require_once('./connection.php');
connectDatabase();



switch ($endpoint) {
    //GET
    case '/api/v1/get-bootcamps':
        http_response_code(200);
       require_once('./handlers/bootcamp.handler.php');
       $bootcamps= getAllBootcamps();
       echo json_encode($bootcamps);
        break;

    //POST 

    case '/api/v1/get-bootcamps/create':
        http_response_code(201);
        require_once('./handlers/bootcamp.handler.php');
        $response = file_get_contents("php://input");
        $data= json_decode($response, true);
       // $data = json_decode(file_get_contents('php://input'), true);
        $result= addBootcamp($data);
        echo json_encode([
            "mesagge" => "Bootcamp created", 
            "operation" => $result]);
        break;


    //PUT
    case '/api/v1/get-bootcamps/update/5':
        http_response_code(200);
        require_once('./handlers/bootcamp.handler.php');
        //Recibo parametros
        $url = $_SERVER['REQUEST_URI'];
        $slug = basename(parse_url($url, PHP_URL_PATH));

        //Recibo Datos
        $data = json_decode(file_get_contents('php://input'), true);
        $data['slug']= $slug;
    
        $result = updateBootcamp($data);

        echo json_encode([
            "message" => "Bootcamp updated succesfully",
            "operation" => $result
        ]);
        break;

    //DELETE 
    case '/api/v1/get-bootcamps/delete/2':
        http_response_code(200);

        //recibir parametros de URL
        $url = $_SERVER['REQUEST_URI'];
        $slug = basename(parse_url($url, PHP_URL_PATH));
        require_once('./handlers/bootcamp.handler.php');
       
        $result = deleteBootcamp($slug);

        echo json_encode([
            "message" => "Bootcamp deleted succesfully",
            "operation" => $result
        ]);
       
        break;

        default: 
        http_response_code(404);
        echo json_encode([
            'message' => 'Endpoint nod found'
        ]);
        break;
}


//ENDPOINT  - GET ALL BOOTCAMPS
//ENDPOINT - CREATE A NEW BOOTCAMP
//ENDPOINT - EDIT A BOOTCAMP
//ENDPOINT - DELETE A BOOTCAMP

?>