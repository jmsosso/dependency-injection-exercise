<?php

namespace Drupal\dropsolid_dependency_injection\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\dropsolid_dependency_injection\Services\PicturesServiceInterface;

/**
 * Provides a 'RestOutputBlock' block.
 *
 * @Block(
 *  id = "rest_output_block",
 *  admin_label = @Translation("Rest output block"),
 * )
 */
class RestOutputBlock extends BlockBase implements ContainerFactoryPluginInterface {
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
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition): RestOutputBlock {
    return new static(
      $container->get('dropsolid_dependency_injection.pictures')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [
      '#cache' => [
        'max-age' => 60,
        'contexts' => ['url'],
      ],
    ];

    $albumId = random_int(1, 20);

    $decoded = $this->pictureService->getAlbum($albumId);

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
