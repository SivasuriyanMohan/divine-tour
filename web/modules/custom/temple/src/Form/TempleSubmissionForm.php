<?php
 
namespace Drupal\temple\Form;
 
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;
use Drupal\file\Entity\File;
 
class TempleSubmissionForm extends FormBase {
 
  public function getFormId() {
    return 'temple_submission_form';
  }
 
  public function buildForm(array $form, FormStateInterface $form_state) {
 
    
    $form['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Temple Name'),
      '#required' => TRUE,
    ];
 
  
    $form['description'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Description'),
      '#required' => TRUE,
    ];
 

    $form['address'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Address'),
      '#required' => TRUE,
    ];
 
    // Spiritual Tradition (Select)
    $form['spiritual_tradition'] = [
      '#type' => 'select',
      '#title' => $this->t('Spiritual Tradition'),
      '#options' => $this->getTaxonomyOptions('spiritual_tradition'),
      '#required' => TRUE,
    ];
 
    // Location (Select)
    $form['location'] = [
      '#type' => 'select',
      '#title' => $this->t('Location'),
      '#options' => $this->getTaxonomyOptions('location'),
      '#required' => TRUE,
    ];
 
     // Address
    $form['popular_for'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Popular For'),
      '#required' => TRUE,
    ];
 
    // Image Upload
    $form['image'] = [
      '#type' => 'managed_file',
      '#title' => $this->t('Temple Image'),
      '#upload_location' => 'public://temple_images/',
      '#required' => TRUE,
      '#upload_validators' => [
        'file_validate_extensions' => ['png jpg jpeg'],
      ],
    ];
 
    // Submit
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit Temple'),
    ];
 
    return $form;
  }
 
  public function submitForm(array &$form, FormStateInterface $form_state) {
 
    $current_user = \Drupal::currentUser();
 
    // Handle image
    $file = File::load($form_state->getValue('image')[0]);
    $file->setPermanent();
    $file->save();
 
    // Create node
    $node = Node::create([
      'type' => 'temple',
      'title' => $form_state->getValue('title'),
      'uid' => $current_user->id(),
      'status' => 0, // Draft
 
      'body' => [
        'value' => $form_state->getValue('description'),
        'format' => 'basic_html',
      ],
 
      'field_address' => [
        'value' => $form_state->getValue('address'),
      ],
 
      'field_spirituality' => [
        'target_id' => $form_state->getValue('spiritual_tradition'),
      ],
 
      'field_templelocation' => [
        'target_id' => $form_state->getValue('location'),
      ],
 
      'field_popular' => [
        'value' => $form_state->getValue('popular_for'),
      ],
 
      'field_images' => [
        'target_id' => $file->id(),
      ],
 

    ]);
 
    $node->save();
 
    \Drupal::messenger()->addMessage($this->t('Temple submitted successfully and is pending review.'));
  }
 
  private function getTaxonomyOptions($vocabulary) {
    $terms = \Drupal::entityTypeManager()
      ->getStorage('taxonomy_term')
      ->loadTree($vocabulary);
 
    $options = [];
    foreach ($terms as $term) {
      $options[$term->tid] = $term->name;
    }
 
    return $options;
  }
 
}