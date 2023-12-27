<?php
// Inclure l'autoloader de Composer pour PHPMailer
require 'C:\wamp64\www\recensement\vendor/autoload.php';

$serveur = "localhost";
$utilisateur = "root";
$motDePasse = "";
$baseDeDonnees = "recensement_etudiants_settat";

// Connexion à la base de données
$connexion = new mysqli($serveur, $utilisateur, $motDePasse, $baseDeDonnees);

// Vérifier la connexion
if ($connexion->connect_error) {
    die("Erreur de connexion : " . $connexion->connect_error);
}

// Récupérer les données du formulaire
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];
$ville = $_POST['ville'];
$matricule_amci = $_POST['matricule_amci'];  // Nouveau champ

// Préparer la requête d'insertion avec le nouveau champ
$insertion = "INSERT INTO etudiants (nom, prenom, email, ville, matricule_amci) VALUES ('$nom', '$prenom', '$email', '$ville', '$matricule_amci')";

// Exécuter la requête
if ($connexion->query($insertion) === TRUE) {
    echo "Enregistrement réussi !";

    // Envoi d'un e-mail de confirmation
      $mail = new \PHPMailer\PHPMailer\PHPMailer();  try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Remplacez par votre serveur SMTP
        $mail->SMTPAuth   = true;
        $mail->Username   = 'serignesidyndack207@gmail.com'; // Remplacez par votre e-mail SMTP
        $mail->Password   = 'Almoukhtar2001'; // Remplacez par votre mot de passe SMTP
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('serignesidyndack207@gmail.com', 'AL Moukhtar');
        $mail->addAddress($email, $nom); // Utiliser l'e-mail et le nom récupérés depuis le formulaire
        $mail->Subject = 'Confirmation de votre inscription';
        $mail->Body    = 'Bonjour ' . $nom . ',<br><br>Votre inscription a été confirmée avec succès!<br>Merci de vous être enregistré.<br><br>Cordialement,<br>Votre équipe de recensement';

        $mail->send();
        echo 'Un e-mail de confirmation a été envoyé à ' . $email . '.';
    } catch (Exception $e) {
        echo 'Erreur lors de l\'envoi de l\'e-mail : ', $mail->ErrorInfo;
    }
} else {
    echo "Erreur : " . $insertion . "<br>" . $connexion->error;
}

// Fermer la connexion
$connexion->close();
?>
