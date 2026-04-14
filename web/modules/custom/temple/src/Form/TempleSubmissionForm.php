<?php
 
namespace Drupal\temple\Form;
 
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;
use Drupal\taxonomy\Entity\Term;
 
class TempleSubmissionForm extends FormBase {
 
  public function getFormId() {
    return 'temple_submission_form';
  }
 
  public function buildForm(array $form, FormStateInterface $form_state) {
 
    // Temple Name
    $form['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Temple Name'),
      '#required' => TRUE,
    ];
 
    // Description
    $form['description'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Description'),
      '#required' => TRUE,
    ];
 
    // Location (taxonomy)
    $form['location'] = [
      '#type' => 'entity_autocomplete',
      '#title' => $this->t('Location'),
      '#target_type' => 'taxonomy_term',
      '#selection_settings' => [
        'target_bundles' => ['location'],
      ],
      '#required' => TRUE,
    ];
 
    // Spiritual Tradition
    $form['spiritual_tradition'] = [
      '#type' => 'entity_select_list',
      '#title' => $this->t('Spiritual Tradition'),
      '#target_type' => 'taxonomy_term',
      '#selection_settings' => [
        'target_bundles' => ['spiritual_tradition'],
      ],
      '#required' => TRUE,
    ];
 

 
    // Submit button
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit Temple'),
    ];
 
    return $form;
  }
 
  public function submitForm(array &$form, FormStateInterface $form_state) {
 
    $current_user = \Drupal::currentUser();
 
    // Create node
    $node = Node::create([
      'type' => 'temple',
      'title' => $form_state->getValue('title'),
      'uid' => $current_user->id(),
      'status' => 0, // Draft
      'field_description' => [
        'value' => $form_state->getValue('description'),
        'format' => 'basic_html',
      ],
      'field_location' => [
        'target_id' => $form_state->getValue('location'),
      ],
      'field_spiritual_tradition' => [
        'target_id' => $form_state->getValue('spiritual_tradition'),
      ],
    ]);
 
    $node->save();
 
    \Drupal::messenger()->addMessage($this->t('Temple submitted successfully and is pending review.'));
  }
 
}