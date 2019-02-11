<?php

namespace Drupal\dropsolid_dependency_injection\Plugin\Mail;

use Drupal\Core\Mail\Plugin\Mail\PhpMail;

/**
 * Class to redirect all Drupal mail.
 *
 * @Mail(
 *   id = "mail_redirect",
 *   label = @Translation("Redirects all mail to nope@doesntexist.com"),
 *   description = @Translation("Sends the message as plain text, using PHP's native mail() function.")
 * )
 */
class MailRedirect extends PhpMail {
  const REDIRECT_ADDRESS = 'nope@doesntexist.com';

  /**
   * {@inheritdoc}
   */
  public function mail(array $message) {
    $message['to'] = self::REDIRECT_ADDRESS;
    return parent::mail($message);
  }

}
