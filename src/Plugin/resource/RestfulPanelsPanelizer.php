<?php
/**
 * @file
 * Panelizer resource output.
 */
namespace Drupal\restful_panels\Plugin\resource;

use Drupal\restful\Plugin\resource\ResourceEntity;
use Drupal\restful\Exception\NotFoundException;
use Drupal\restful\Exception\UnprocessableEntityException;
use Drupal\restful\Exception\NotImplementedException;
use Drupal\restful\Exception\InternalServerErrorException;

class RestfulPanelsPanelizer extends ResourceEntity {

  /**
   * @var string
   *   The view mode to use to load the display.
   */
  protected $viewMode;


  public function __construct(array $configuration, $plugin_id, $plugin_definition) {
    if (empty($plugin_definition['dataProvider']['entityType'])) {
      throw new InternalServerErrorException('The entity type was not provided.');
    }
    $this->entityType = $plugin_definition['dataProvider']['entityType'];
    if (isset($plugin_definition['dataProvider']['bundles'])) {
      $this->bundles = $plugin_definition['dataProvider']['bundles'];
    }
    $this->viewMode = $plugin_definition['dataProvider']['viewMode'];
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  /**
   * {@inheritdoc}
   */
  public function view($identifier) {
    $entities = entity_load($this->entityType, array($identifier));
    if (empty($entities[$identifier])) {
      throw new NotFoundException(format_string('Entity of type @type with id @id could not be found.', array(
        '@type' => $this->entityType,
        '@id' => $identifier,
      )));
    }

    $entity = $entities[$identifier];
    if (empty($entity->panelizer[$this->viewMode])) {
      throw new UnprocessableEntityException(format_string('The specified display for entity of type @type with id @id could not be loaded.', array(
        '@type' => $this->entityType,
        '@id' => $identifier,
      )));
    }
    return parent::view($entity->panelizer[$this->viewMode]->did);
  }

}
