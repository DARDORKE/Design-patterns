<?php
// Enoncé
//Pour les besoins d'un site de vente en ligne, vous êtes chargé de mettre en place un système permettant d'informer un client que sa commande a été expédiée.
//
//Le code ci-dessous implémente la classe Client et vous fournit une liste de clients que vous devrez contacter.
//
//Un client est toujours contacté selon son moyen de contact favori, représenté par la propriété $contactWith.
//
//Selon celui-ci, la méthode getContactInformation() permet de retourner son numéro de téléphone ou son adresse e-mail.

// Question 1
//Chacun des clients de la liste dont vous disposez doit être informé par une notification selon son moyen de contact favori.
//
//À ce jour, un client peut être notifié par e-mail ou par SMS, mais la société envisage, à terme, de prendre contact avec ses clients au moyen de messageries instantanées. Le système que vous allez implémenter devra prendre en compte cette contrainte d'évolutivité.
//
//Selon le script et les informations dont vous disposez, implémentez les classes nécessaires à la gestion de ces notifications, ainsi que le script permettant leur envoi.
//
//Par simplification, on considérera que l'envoi d'une notification consistera à indiquer "%type de notification% de confirmation envoyé à %moyen contact% ".


/**
 * Class Notification
 */
abstract class Notification
{
    // Tout type de notification doit implémenter une méthode send()
    protected abstract function send(string $recipient, string $message);

    public function manageNotification($recipient, $message)
    {
        $this->send($recipient, $message);
    }
}

/**
 * Class EmailNotification
 */
class EmailNotification extends Notification
{
    protected function send(string $recipient, string $message)
    {
        echo sprintf("Email envoyé au %s contenant le message %s  <br/>", $recipient, $message);
    }
}

/**
 * Class SMSNotification
 */
class SMSNotification extends Notification
{
    protected function send(string $recipient, string $message)
    {
        echo sprintf("SMS envoyé au %s contenant le message %s <br/>", $recipient, $message);
    }
}

/**
 * Class NotificationFactory
 */
class NotificationFactory
{
    // La mise en place du modèle Factory permettra de futures évolutions
    /**
     * @param string $contactType
     * @return EmailNotification|SMSNotification
     */
    public static function createNotification(string $contactType)
    {
        switch ($contactType) {
            case 'sms':
                return new SMSNotification();
                break;
            case 'email':
            default:
                return new EmailNotification();
        }
    }
}

/**
 * Class Client
 */
class Client
{
    public $name;
    public $contactWith;
    public $email;
    public $phoneNumber;

    public function __construct(string $name, string $contactBy, string $email, string $phoneNumber)
    {
        $this->name = $name;
        $this->contactWith = $contactBy;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
    }

    public function getContactInformation()
    {
        switch ($this->contactWith) {
            case 'sms':
                return $this->phoneNumber;
                break;
            case 'email':
            default:
                return $this->email;
                break;
        }
    }
}

$message = "Commande expédiée";
$clientsToNotifyToNotify = [];

$clientsToNotify[] = new Client("Karine", "email", "karine@mail.fr", "01.02.03.04.05.06");
$clientsToNotify[] = new Client("Julien", "sms", "julien@mail.fr", "01.02.03.04.05.07");
$clientsToNotify[] = new Client("Karim", "sms", "karim@mail.fr", "01.02.03.04.05.08");
$clientsToNotify[] = new Client("Justine", "email", "justine@mail.fr", "01.02.03.04.05.09");


foreach ($clientsToNotify as $client)
{
    $notification = NotificationFactory::createNotification($client->contactWith);
    $notification->manageNotification($client->getContactInformation(), $message);
}