<?php
/**
 * @file
 * Panels Display Resource class.
 */

namespace Drupal\restful_panels\Plugin\resource;

use Drupal\restful\Plugin\resource\DataInterpreter\DataInterpreterInterface;
use Drupal\restful\Plugin\resource\Field\ResourceFieldInterface;
use Drupal\restful\Plugin\resource\ResourceEntity;
use Drupal\restful\Plugin\resource\ResourceInterface;

/**
 * Class PanelsDisplay__1_0
 * @package Drupal\restful_panels\Plugin\resource
 *
 * @Resource(
 *   name = "panels_display:1.0",
 *   resource = "panels_display",
 *   label = "Panels Display",
 *   description = "Expose a GET for panels by display ID.",
 *   authenticationTypes = TRUE,
 *   authenticationOptional = TRUE,
 *   majorVersion = 1,
 *   minorVersion = 0
 * )
 */
class PanelsDisplay__1_0 extends RestfulPanelsDataProviderDisplay { }
