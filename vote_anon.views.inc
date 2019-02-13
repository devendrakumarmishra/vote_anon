<?php

/**
 * @file
 * Contains views API hooks for vote_anon module.
 */

/**
 * Implements hook_views_data().
 */
function vote_anon_views_data() {
  $data = [];
  $data['vote_anon_counts'] = array();
  $data['vote_anon_counts']['table'] = array();
  $data['vote_anon_counts']['table']['group'] = t('Anonymous Vote');
  $data['vote_anon_counts']['table']['provider'] = 'vote_anon';
  
  $data['vote_anon_counts']['table']['base'] = [
    'field' => 'vote_id',
    'title' => t('Vote For Anonymous'),
    'help' => t('Vote For Anonymous.'),
    'weight' => -10,
  ];
  $data['vote_anon_counts']['table']['join'] = [
    'node_field_data' => [
      'left_field' => 'nid',
      'field' => 'entity_id',
      'extra' => [
        0 => [
          'field' => 'published',
          'value' => TRUE,
        ],
      ],
    ],
  ];
  $data['vote_anon_counts']['entity_id'] = array(
    'title' => t('Vote entity id'),
    'help' => t('Vote entity id'),
    'relationship' => array(
      'base' => 'node_field_data',
      'base field' => 'nid',
      'id' => 'standard',
      'label' => t('Entity Voting node ID'),
    ),
  );
  $data['vote_anon_counts']['count'] = [
    'title' => t('Vote counter'),
    'help' => t('The number of times a piece of content is votted by any user.'),
    'field' => [
      'id' => 'numeric',
      'click sortable' => TRUE,
    ],
    'sort' => array(
      'id' => 'groupby_numeric',
    ),
    'filter' => array(
      'id' => 'numeric',
    ),
    'argument' => array(
      'id' => 'numeric',
    ),
  ];
  $data['vote_anon_counts']['last_updated'] = [
    'title' => t('Time last vote'),
    'help' => t('The time a piece of content was most recently vote by any user.'),
    'field' => [
      'id' => 'date',
      'click sortable' => TRUE,
    ],
    'sort' => array(
      'id' => 'date',
    ),
    'filter' => array(
      'id' => 'date',
    ),
    'argument' => array(
      'id' => 'date',
    ),
  ];
  return $data;
}
