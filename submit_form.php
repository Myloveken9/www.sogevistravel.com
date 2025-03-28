<?php
// Vérifier si les données du formulaire ont été envoyées via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Nettoyer les valeurs du formulaire pour éviter les attaques XSS et enlever les espaces superflus
    $name = trim(htmlspecialchars($_POST['name']));
    $email = trim(htmlspecialchars($_POST['email']));
    $subject = trim(htmlspecialchars($_POST['subject']));
    $message = trim(htmlspecialchars($_POST['message']));

    // Vérifier si les champs obligatoires sont remplis
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        echo "Tous les champs doivent être remplis.";
        exit;
    }

    // Validation de l'email
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "L'adresse email fournie est invalide. Veuillez vérifier.";
        exit;
    }

    // Définir l'adresse email du destinataire
    $to = "sogevis.viagens@gmail.com";  // Remplace par l'adresse email où tu veux recevoir les messages
    
    // Sujet de l'email
    $email_subject = "Message de votre site web : " . $subject;

    // Corps du message
    $email_message = "Nom: " . $name . "\n";
    $email_message .= "Email: " . $email . "\n";
    $email_message .= "Sujet: " . $subject . "\n";
    $email_message .= "Message: \n" . $message . "\n";  // Ajout du saut de ligne pour le message
    
    // En-têtes de l'email
    $headers = "From: " . $email . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    // Envoi de l'email
    if (mail($to, $email_subject, $email_message, $headers)) {
        // Si l'email est envoyé avec succès, afficher un message de succès
        echo "Votre message a été envoyé avec succès. Merci de nous avoir contacté.";
    } else {
        // En cas d'erreur lors de l'envoi
        echo "Désolé, une erreur est survenue. Veuillez réessayer plus tard.";
    }
}
?>
