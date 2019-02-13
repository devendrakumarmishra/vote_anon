<?php

namespace Drupal\vote_anon\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\NodeInterface;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\AppendCommand;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Ajax\InvokeCommand;
use Drupal\Core\Url;
use Symfony\Component\HttpFoundation\Response;

use Drupal\Core\Database\Connection;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Form\ConfigFormBase;
/**
 * Class VoteAjaxController.
 */
class VoteAjaxController extends ControllerBase {

  /**
   * Rendervotelinkrenderable.
   *
   * @return string
   *   Return Hello string.
   */
  public function renderVoteLinkRenderable($node, $nojs = 'ajax') {
    // Determine whether the request is coming from AJAX or not.
    if ($nojs == 'ajax') {
      $config = \Drupal::config('vote_anon.voteconfiguration');
      $cookie = $config->get('voting_cookie');
      if (!isset($_COOKIE[$cookie])) {
        $vote_id = \Drupal::database()->select('vote_anon_counts', 'vote')
          ->fields('vote', ['vote_id'])
          ->condition('entity_id', $node)
          ->execute()->fetchField();
        if ($vote_id) {
          \Drupal::database()->update('vote_anon_counts')
          ->expression('count', 'count + 1')
          ->condition('vote_id', $vote_id)
          ->condition('entity_id', $node)
          ->execute();
        }
        else {
          \Drupal::database()->insert('vote_anon_counts')->fields(
            array(
              'entity_type' => 'node',
              'count' => 1,
              'entity_id' => $node,
              'last_updated' => time()
            )
          )->execute();
       }
        $cookie_name = $cookie;
        $cookie_value = 1;
        setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
        $output = '<div class="ajax-message">' . $this->t("Thank you for vote") . '</div>';
      }
      else {
        $output = '<div class="ajax-message">' . $this->t("You have already submitted") . '</div>';
      }
      $response = new AjaxResponse();
      $response->addCommand(new ReplaceCommand("#votedestinationdiv{$node}", $output));
      $response->addCommand(new InvokeCommand(NULL, 'disableVoteLinks', ['/']));
      return $response;
    }
  }
  /**
   * Votecount.
   *
   * @return string
   *   Return Hello string.
   */
  public function voteCount() {
    $items = array();
    $query = \Drupal::database()->select('vote_anon_counts', 'vote');
    $query->fields('vote', array('entity_id','count'));
    $query->join('node_field_data','node', 'vote.entity_id = node.nid');
    $query->fields('node', array('title'));
    $results = $query->execute()->fetchAll();
     
    if(sizeof($results) > 0) {
      foreach($results as $result) {
        $items[] = $result->title .' Total Votes: ' . $result->count;  
      } 
    }
    
    return $output['voting'] = [
      '#title' => 'Voting Details',
      '#theme' => 'item_list',
      '#items' => $items,
    ];
  }

}
