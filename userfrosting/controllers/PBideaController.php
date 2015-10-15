<?php

namespace UserFrosting;
function __construct() {
    parent::__construct();
}
/**
 * UserController Class
 *
 * Controller class for /users/* URLs.  Handles user-related activities, including listing users, CRUD for users, etc.
 *
 * @package UserFrosting
 * @author Alex Weissman
 * @link http://www.userfrosting.com/navigating/#structure
 */
class PBideaController extends \UserFrosting\BaseController {
 public function run($data)
       {
          $stam =  $this->db->prepare('INSERT INTO pbidea (`data`) VALUES (:data)');

          $stam->execute(array(
           ':data' => $data['data']
                ));
    }
        public function pageParticipatory(){
           // Access-controlled resource
           if (!$this->_app->user->checkAccess('uri_dashboard')){
               $this->_app->notFound();
           }
            
           // Get a list of all groups
            
           
           $this->_app->render('pbidea.html', [
               'page' => [
                   'author' =>         $this->_app->site->author,
                   'title' =>          "Update Group Titles",
                   'description' =>    "Update the title for every user in a particular group",
                   'alerts' =>         $this->_app->alerts->getAndClearMessages()
               ],
               
           ]);   
        }

          public function PBidea(){
          
           
           // Fetch the POSTed data
           $post = $this->_app->request->post();
           
           // Load the request schema
           $requestSchema = new \Fortress\RequestSchema($this->_app->config('schema.path') . "/forms/pb-idea.json");
           
           // Get the alert message stream
           $ms = $this->_app->alerts; 
        
           // Set up Fortress to process the request
           $rf = new \Fortress\HTTPRequestFortress($ms, $requestSchema, $post);                    
            
           // Sanitize
           $rf->sanitize();
            
           // Validate, and halt on validation errors.
           if (!$rf->validate()) {
             $this->_app->halt(400);
           }   
                  
           // Get the filtered data
           $data = $rf->data();
           



           $pbidea->run($data);
           // Load all users whose primary group matches the requested group 
           
           // Update title for these users
  
    $pbidea->fnm = $post['fnm'];
    $pbidea->lnm = $post['lnm'];
    $pbidea->addr = $post['addr'];
    $pbidea->apt = $post['apt'];
    $pbidea->cty = $post['cty'];
    $pbidea->zip = $post['zip'];
    $pbidea->taidea = $post['taidea'];
    $pbidea->taloc = $post['taloc'];
    $pbidea->tawhy = $post['tawhy'];
    $pbidea->taadd = $post['taadd'];
    $pbidea->ts = $post['ts'];
    $pbidea->user_id = $post['user_id'];
    $pbidea->district = $post['district'];
              $pbidea->store();
          
            
            // Give us a nice success message
            $ms->addMessageTranslated("success", "Everyone's title has been updated to {{title}}!", $post);
            
        }

}
