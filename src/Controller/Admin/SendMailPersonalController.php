<?php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class SendMailPersonalController extends AbstractDashboardController
{
  #[Route('admin/send-mail-personal', name: 'app_send_mail_personal')]
  public function SendEMailIndex()
  {
    return $this->render('admin/sendEmail.html.twig');
  }

  #[Route(path: 'admin/send-mail-personal/send', name: 'app_send_mail_personal_send')]
  public function sendPersonalMail(MailerInterface $mailer, UserRepository $userRepository)
  {
    $allUsers = $userRepository->findAll();

    //        foreach ($allUsers as $index => $user) {
    //            $email = (new Email())
    //                ->from('freirelf06@gmail.com')
    //                ->to($user->getEmail())
    //                //->cc('cc@example.com')
    //                //->bcc('bcc@example.com')
    //                ->replyTo('l.casfreirelopes@gmail.com')
    //                //->priority(Email::PRIORITY_HIGH)
    //                ->subject('Teste den envio de e-mail pessoal')
    //                ->html('<p>Parabéns, seu sistema de e-mails funciona!</p>');
    //
    //            $mailer->send($email);
    //            $this->addFlash(
    //                'success',
    //                'Mensagem enviada com sucesso!'
    //            );
    //        }

    $email = (new Email())
      ->from('freirelf06@gmail.com')
      ->to($this->getUser()->getEmail())
      //->cc('cc@example.com')
      //->bcc('bcc@example.com')
      ->replyTo('l.casfreirelopes@gmail.com')
      //->priority(Email::PRIORITY_HIGH)
      ->subject('Teste den envio de e-mail pessoal')
      ->html('<p>Parabéns, seu sistema de e-mails funciona!</p>');

    $mailer->send($email);
    $this->addFlash(
      'success',
      'Mensagem enviada com sucesso!'
    );

    return $this->redirectToRoute('admin');
  }
}
