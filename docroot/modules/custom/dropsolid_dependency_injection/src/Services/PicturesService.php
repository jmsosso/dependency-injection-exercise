<?php

namespace Drupal\dropsolid_dependency_injection\Services;

use GuzzleHttp\Client;

/**
 * Class PicturesService.
 */
class PicturesService implements PicturesServiceInterface {
  const API_ADDRESS = 'https://jsonplaceholder.typicode.com';
  const MAX_ITEMS   = 25;

  /**
   * Guzzle Http Client.
   *
   * @var GuzzleHttp\Client
   */
  protected $httpClient;

  /**
   * Constructs a new PicturesService object.
   */
  public function __construct(Client $httpClient) {
    $this->httpClient = $httpClient;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('http_client')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getAlbum(int $albumId): array {
    $decoded = [];

    try {
      $response = $this->httpClient->request('GET', self::API_ADDRESS . "/albums/$albumId/photos");
      $data     = $response->getBody()->getContents();
      $decoded  = json_decode($data);

      if (!$decoded) {
        throw new \Exception('Invalid data returned from API');
      }
    }
    catch (\Exception $e) {
      return [
        'error' => TRUE,
        'message' => $e->getMessage(),
      ];
    }

    // Limit number of items just for development to avoid a huge page.
    return array_slice($decoded, 0, self::MAX_ITEMS);
  }

}
