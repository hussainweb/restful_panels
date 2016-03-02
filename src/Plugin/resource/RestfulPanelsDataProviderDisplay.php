<?php
/**
 * @file
 * Generic data provider for panel displays.
 */

namespace Drupal\restful_panels\Plugin\resource;

use Drupal\restful\Plugin\resource\Resource;

class RestfulPanelsDataProviderDisplay extends Resource {

  /**
   * @inheritDoc
   */
  protected function publicFields() {
    $fields = array();
    $fields['did'] = array();
    $fields['layout'] = array();
    $fields['content'] = array();

    return $fields;
  }

  /**
   * @inheritDoc
   */
  public function index($path) {
    $result = db_select('panels_display', 'd')
      ->fields('d')
      ->execute();

    $return = array();
    foreach ($result as $row) {
      $return[] = array(
        'display_id' => $row->did,
        'layout' => $row->layout,
      );
    }

    return $return;
  }

  /**
   * @inheritDoc
   */
  public function view($identifier) {
    ctools_include('plugins', 'panels');
    $display = panels_load_display($identifier);
    $display->context = $this->getContexts();

    /** @var RestfulPanelsStructuredRenderer $renderer */
    $renderer = panels_get_renderer_handler('structured', $display);

    $rendered = $renderer->render($display);
    return (array) $rendered;
  }

  /**
   * Retrieve contexts to be passed to the Panels system.
   */
  public function getContexts() {
    ctools_include('context');
    $object = new \StdClass();
    $object->base_contexts = array('restful_panels' => ctools_context_create_empty('string'));
    return ctools_context_load_contexts($object);
  }

}
