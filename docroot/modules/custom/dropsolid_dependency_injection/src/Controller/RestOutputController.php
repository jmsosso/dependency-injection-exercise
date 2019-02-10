<?php

namespace Drupal\dropsolid_dependency_injection\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\dropsolid_dependency_injection\Services\PicturesServiceInterface;

/**
 * Class RestOutputController.
 *
 * @package Drupal\dropsolid_dependency_injection\Controller
 */
class RestOutputController extends ControllerBase implements ContainerInjectionInterface {
  /**
   * The Album/Pictures service.
   *
   * @var Drupal\dropsolid_dependency_injection\Services\PicturesServiceInterface
   */
  private $pictureService;

  /**
   * Create a new object.
   *
   * @param Drupal\dropsolid_dependency_injection\Services\PicturesServiceInterface $pictureService
   *   Service to retrieve the remote pictures.
   */
  public function __construct(PicturesServiceInterface $pictureService) {
    $this->pictureService = $pictureService;
  }

  /**
   * Container injection implementation.
   *
   * @param Symfony\Component\DependencyInjection\ContainerInterface $container
   *   The container.
   */
  public static function create(ContainerInterface $container): RestOutputController {
    return new static(
      $container->get('dropsolid_dependency_injection.pictures')
    );
  }

  /**
   * Return the renderable array with the pictures.
   *
   * @return array
   *   The array
   */
  public function showPhotos() {
    $build = [
      '#cache' => [
        'max-age' => 60,
        'contexts' => ['url'],
      ],
    ];

    $decoded = $this->pictureService->getAlbum(5);

    if (empty($decoded['error'])) {
      foreach ($decoded as $item) {
        $build['rest_output_block']['photos'][] = [
          '#theme' => 'image',
          '#uri' => $item->thumbnailUrl,
          '#alt' => $item->title,
          '#title' => $item->title,
        ];
      }
    }

    return $build;
  }

}
