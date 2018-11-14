<?php
require("../libs/sendgrid-php/sendgrid-php.php");

switch ($_SERVER['HTTP_ORIGIN']) {
    case 'http://serviciosmilla.cl': case 'https://serviciosmilla.cl':
    header('Access-Control-Allow-Origin: '.$_SERVER['HTTP_ORIGIN']);
    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
    header('Access-Control-Max-Age: 1000');
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
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

$request_body = json_decode('{
  "personalizations": [
    {
      "to": [
        {
          "email": $to
        }
      ],
      "subject": $email_subject
    }
  ],
  "from": {
    "email": $email_address
  },
  "content": [
    {
      "type": "text/plain",
      "value": $email_body
    }
  ]
}');

$apiKey = getenv('SENDGRID_API_KEY');
$sg = new \SendGrid($apiKey);

$response = $sg->client->mail()->send()->post($request_body);
file_put_contents("php://stderr", "Status code: " . $response->statusCode() . "\n");
file_put_contents("php://stderr", "Body: " . $response->body() . "\n");

echo $response->statusCode();
echo $response->body();
echo $response->headers();
return true;
?>
