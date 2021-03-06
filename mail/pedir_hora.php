<?php
switch ($_SERVER['HTTP_ORIGIN']) {
    case 'http://serviciosmilla.cl': case 'https://serviciosmilla.cl':
    header('Access-Control-Allow-Origin: '.$_SERVER['HTTP_ORIGIN']);
    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
    header('Access-Control-Max-Age: 1000');
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
    break;
}
   
$name = strip_tags(htmlspecialchars($_POST['name']));
$rut = strip_tags(htmlspecialchars($_POST['rut']));
$direccion = strip_tags(htmlspecialchars($_POST['direccion']));
$correo = strip_tags(htmlspecialchars($_POST['correo']));
$marca = strip_tags(htmlspecialchars($_POST['marca']));
$celular = strip_tags(htmlspecialchars($_POST['celular']));
$actividad = strip_tags(htmlspecialchars($_POST['actividad']));
$otro = strip_tags(htmlspecialchars($_POST['otro']));
   
// Create the email and send the message
$to = 'serviciosmilla@gmail.com'; 
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
$headers = "From: formulario@serviciosmilla.cl\n"; 
$headers .= "Reply-To: $correo";  

$salida = mail($to, $email_subject, $email_body, $headers);
file_put_contents("php://stderr", "salida mail: $salida\n");



return true
?>
