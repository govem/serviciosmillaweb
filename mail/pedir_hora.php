<?php
require '../vendor/autoload.php';
use SparkPost\SparkPost;
use GuzzleHttp\Client;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;

switch ($_SERVER['HTTP_ORIGIN']) {
    case 'http://serviciosmilla.cl': case 'https://serviciosmilla.cl':
    header('Access-Control-Allow-Origin: '.$_SERVER['HTTP_ORIGIN']);
    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
    header('Access-Control-Max-Age: 1000');
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
    header('Content-type:application/json');
    break;
}
   
$name = strip_tags(htmlspecialchars($_POST['name']));
$direccion = strip_tags(htmlspecialchars($_POST['direccion']));
$correo = strip_tags(htmlspecialchars($_POST['correo']));
$marca = strip_tags(htmlspecialchars($_POST['marca']));
$celular = strip_tags(htmlspecialchars($_POST['celular']));
$actividad = strip_tags(htmlspecialchars($_POST['actividad']));
$otro = strip_tags(htmlspecialchars($_POST['otro']));
   
// Create the email and send the message
$to = 'gonzalo.vega@gmail.com'; 
$email_subject = "SOLICITUD DE HORA";
$email_body = "Tienes una nueva solicitude de hora desde el sitio web.\n\n".
"Aquí están los detalles:\n\n".
"Nombre: $name\n\n".
"RUT: $rut\n\n".
"Email: $correo\n\n".
"Teléfono: $celular\n\n".
"Dirección: $direccion\n\n".
"Marca: $marca\n\n".
"Actividad: $actividad\n\n".
"Actividad (otro): $otro\n\n".
$headers = "From: noreply@serviciosmilla.cl\n"; // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com.
$headers .= "Reply-To: $correo";  
//mail($to,$email_subject,$email_body,$headers);
//return true;         



$httpClient = new GuzzleAdapter(new Client());
$sparky = new SparkPost($httpClient, ['key'=>getEnv('SPARKPOST_API_KEY')]);

$sparky->setOptions(['async' => false]);
file_put_contents("php://stderr", "sparky: " . $sparky . "\n");
file_put_contents("php://stderr", "transmission: " . $sparky->transmission . "\n");
$response = $sparky->transmission->post([
  'options' => [
    'sandbox' => false
  ],
  'content' => [
    'from'=>$correo,
    'subject'=> $email_subject,
    'html'=>$email_body
  ],
  'recipients'=>[
    ['address'=>['email'=>'gonzalo.vega@gmail.com']]
  ]
]);

file_put_contents("php://stderr", "Status code: " . $response->statusCode() . "\n");
file_put_contents("php://stderr", "Body: " . $response->body() . "\n");



/*
$email = new \SendGrid\Mail\Mail(); 
$email->setFrom($correo, $correo);
$email->setSubject($email_subject);
$email->addTo("gonzalo.vega@gmail.com", "Example User");
$email->addContent("text/plain", $email_body);
$sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
try {
    $response = $sendgrid->send($email);
    file_put_contents("php://stderr", "Status code: " . $response->statusCode() . "\n");
    file_put_contents("php://stderr", "Body: " . $response->body() . "\n");
} catch (Exception $e) {
    file_put_contents("php://stderr", "Status code: " . $e->getMessage . "\n");
}*/

return true;
?>
