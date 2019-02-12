<?php

namespace Drupal\dropsolid_dependency_injection\Services;

use Drupal\Core\Language\LanguageManager;
use Drupal\Core\Language\LanguageDefault;

/**
 * Class CustomLanguageManager.
 */
class CustomLanguageManager extends LanguageManager {

  /**
   * New service constructor.
   *
   * @param \Drupal\Core\Language\LanguageManager $languageManager
   *   The original service.
   */
  public function __construct(LanguageManager $languageManager) {
    $defaultLanguage = new LanguageDefault([]);
    $defaultLanguage->set($languageManager->getDefaultLanguage());

    parent::__construct($defaultLanguage);
  }

  /**
   * Fake method to test the decorator.
   *
   * @return string
   *   Just a hello world.
   */
  public function sayHello(): string {
    return 'Hello from CustomLanguageManager!';
  }

}
