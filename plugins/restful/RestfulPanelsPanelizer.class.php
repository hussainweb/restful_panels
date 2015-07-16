<?php
/**
 * @file
 * Panelizer resource output.
 */

class RestfulPanelsPanelizer extends RestfulPanelsDataProviderDisplay {

  /**
   * @var string
   *   The type of the entity to load.
   */
  protected $entityType;

  /**
   * @var string
   *   The bundle of the entities to load.
   */
  protected $bundle;

  /**
   * @var string
   *   The view mode to use to load the display.
   */
  protected $viewMode;

  /**
   * Constructs a RestfulPanelizer object.
   *
   * @param array $plugin
   *   Plugin definition.
   * @param RestfulAuthenticationManager $auth_manager
   *   (optional) Injected authentication manager.
   * @param DrupalCacheInterface $cache_controller
   *   (optional) Injected cache backend.
   * @param string $language
   *   (optional) The language to return items in.
   */
  public function __construct(array $plugin, \RestfulAuthenticationManager $auth_manager = NULL, \DrupalCacheInterface $cache_controller = NULL, $language = NULL) {
    parent::__construct($plugin, $auth_manager, $cache_controller, $language);

    // Validate keys exist in the plugin's "data provider options".
    $required_keys = array(
      'entity_type',
      'bundle',
      'view_mode',
    );
    $options = $this->processDataProviderOptions($required_keys);

    $this->entityType = $options['entity_type'];
    $this->bundle = $options['bundle'];
    $this->viewMode = $options['view_mode'];
  }

  /**
   * @inheritDoc
   */
  public function index() {
    // Don't worry about this for now.
    $this->notImplementedCrudOperation(__FUNCTION__);
  }

  /**
   * @inheritDoc
   */
  public function view($id) {
    $entities = entity_load($this->entityType, array($id));
    if (empty($entities[$id])) {
      // TODO: Throw the proper exception.
      throw new Exception();
    }

    $entity = $entities[$id];
    if (empty($entity->panelizer[$this->viewMode])) {
      // TODO: Throw the proper exception.
      throw new Exception();
    }
    return parent::view($entity->panelizer[$this->viewMode]->did);
  }

}
