<?php

namespace Drupal\vote_anon\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Entity\EntityTypeBundleInfoInterface;

/**
 * Class VoteConfigurationForm.
 */
class VoteConfigurationForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'vote_anon.voteconfiguration',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'vote_configuration_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('vote_anon.voteconfiguration');
    $form['message_after_voting'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Message After Voting'),
      '#description' => $this->t('Show a thank you message after voting'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('message_after_voting'),
    ];
    $form['warning_for_duplicate_voting'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Warning for duplicate voting'),
      '#description' => $this->t('Show a warning message that you have already vote'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('warning_for_duplicate_voting'),
    ];
    $form['voting_cookie'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Voting cookie'),
      '#description' => $this->t('Voting cookie'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('voting_cookie'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('vote_anon.voteconfiguration')
      ->set('message_after_voting', $form_state->getValue('message_after_voting'))
      ->set('warning_for_duplicate_voting', $form_state->getValue('warning_for_duplicate_voting'))
      ->set('voting_cookie', $form_state->getValue('voting_cookie'))
      ->save();
  }

}
