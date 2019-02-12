<?php

namespace Drupal\dropsolid_dependency_injection\EventSubscriber;

use Drupal\Core\Language\LanguageManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class Subscriber.
 *
 * @package Drupal\my_module
 */
class LanguageAccessSubscriber implements EventSubscriberInterface {
  /**
   * The language manager.
   *
   * @var \Drupal\Core\Language\LanguageManagerInterface
   */
  protected $languageManager;

  /**
   * Constructor.
   *
   * @param \Drupal\Core\Language\LanguageManagerInterface $languageManager
   *   The language manager.
   */
  public function __construct(LanguageManagerInterface $languageManager) {
    $this->languageManager = $languageManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[KernelEvents::REQUEST] = ['onRequest'];
    return $events;
  }

  /**
   * This method is called whenever the kernel.request event is dispatched.
   *
   * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
   *   The event.
   */
  public function onRequest(GetResponseEvent $event) {
    /*
     * Not sure what to to here.
     * To be honest I don't really understand what the exercise requires:
     * "Take over the LanguageManager service in a way that doesn't preclude others
     * from also taking over the LanguageManager service".
     */

    \drupal_set_message($this->languageManager->getCurrentLanguage()->getName());
  }

}
