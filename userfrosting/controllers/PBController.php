<?php

namespace UserFrosting;

/**
 * UserController Class
 *
 * Controller class for /users/* URLs.  Handles user-related activities, including listing users, CRUD for users, etc.
 *
 * @package UserFrosting
 * @author Alex Weissman
 * @link http://www.userfrosting.com/navigating/#structure
 */
class PBController extends \UserFrosting\BaseController {
 
        public function pageGroupTitles(){
           // Access-controlled resource
           if (!$this->_app->user->checkAccess('uri_group_titles')){
               $this->_app->notFound();
           }
            
           // Get a list of all groups
           $groups = GroupLoader::fetchAll();
           
           $this->_app->render('group-titles.html', [
               'page' => [
                   'author' =>         $this->_app->site->author,
                   'title' =>          "Update Group Titles",
                   'description' =>    "Update the title for every user in a particular group",
                   'alerts' =>         $this->_app->alerts->getAndClearMessages()
               ],
               "groups" => $groups     
           ]);   
        }

}
