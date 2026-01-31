<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Configuración del destinatario
    $receiving_email_address = 'juanantonio.velasco@outlook.com'; // **¡CÁMBIALO!**

    // 2. Recolección de datos
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $phone = trim($_POST["telefono"]);
    $inquiry = trim($_POST["inquiry"]);
    $message = trim($_POST["message"]);
    //$subject = trim($_POST["_subject"]);
    $subject = "Contacto Pagina WEB";

    // 3. Validación básica
    if (empty($name) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Por favor, completa el formulario y asegúrate de que el email es válido.";
        exit;
    }

    // 4. Construcción del contenido del correo
    $email_content = "Nombre: $name\n";
    $email_content .= "Email: $email\n";
    $email_content .= "Teléfono: $phone\n";
    $email_content .= "Interés: $inquiry\n\n";
    $email_content .= "Mensaje:\n$message\n";

    // 5. Construcción de las cabeceras del correo
    $email_headers = "From: Formulario Web <no-reply@tudominio.com>";

    // 6. Envío del correo
    if (mail($receiving_email_address, $subject, $email_content, $email_headers)) {
        // Redirigir al usuario a una página de agradecimiento
        header("Location: thank_you.html");
        exit;
    } else {
        http_response_code(500);
        echo "¡Ups! Algo salió mal y no pudimos enviar tu mensaje.";
    }

} else {
    // No es una solicitud POST, redirigir al formulario.
    header("Location: index.html");
    exit;
}
?>