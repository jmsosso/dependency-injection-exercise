<?php

namespace Drupal\dropsolid_dependency_injection;

use Drupal\Core\Breadcrumb\Breadcrumb;
use Drupal\Core\Breadcrumb\BreadcrumbBuilderInterface;
use Drupal\Core\Link;
use Drupal\Core\Routing\RouteMatchInterface;

/**
 * Class CustomBreadcrumbBuilder.
 */
class CustomBreadcrumbBuilder implements BreadcrumbBuilderInterface {
  const PICTURES_ROUTE_NAME = 'dropsolid_dependency_injection.rest_output_controller_showPhotos';

  /**
   * {@inheritdoc}
   */
  public function applies(RouteMatchInterface $route_match) {
    $route = $route_match->getCurrentRouteMatch();
    return $route->getRouteName() == self::PICTURES_ROUTE_NAME;
  }

  /**
   * {@inheritdoc}
   */
  public function build(RouteMatchInterface $route_match) {
    $breadcrumb = new Breadcrumb();
    $breadcrumb->addCacheContexts(['route']);

    // Add all links to the breadcrumb.
    $links[] = Link::createFromRoute(t('Home'), '<front>');
    $links[] = Link::createFromRoute(t('Dropsolid'), '<front>');
    $links[] = Link::createFromRoute(t('Example'), '<front>');
    $links[] = Link::createFromRoute(t('Photos'), self::PICTURES_ROUTE_NAME);

    $breadcrumb->setLinks($links);

    return $breadcrumb;
  }

}
