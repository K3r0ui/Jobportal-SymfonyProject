<?php
namespace App\Service;

use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class Mailer{
    /**
     * @var MailerInterface
     */
    private $mailer;
    
    public function _construct(MailerInterface $mailer){
        $this->mailer=$mailer;
    }
    public function sendEmail($email,$token){
        $email = (new TemplatedEmail())
        
        ->from('registration@example.com')
        ->to(new Address($email))
        ->subject('Thanks for signing up!')
    
        // path of the Twig template to render
        ->htmlTemplate('emails/signup.html.twig')
    
        // pass variables (name => value) to the template
        ->context([
            
            'token' => $token,
        ])
    ;

         $this->mailer->send($email);
    }
}