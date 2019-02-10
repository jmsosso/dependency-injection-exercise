<?php

namespace Drupal\dropsolid_dependency_injection\Services;

/**
 * Interface for the PicturesService.
 */
interface PicturesServiceInterface {

  /**
   * Return the pictures from the web service JSONPlaceholder.
   *
   * @param int $albumId
   *   The Id of the album to retrieve.
   *
   * @return array
   *   The returned data.
   */
  public function getAlbum(int $albumId): array;

}
