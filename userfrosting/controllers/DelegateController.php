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
class DelegateController extends \UserFrosting\BaseController {

    /**
     * Create a new UserController object.
     *
     * @param UserFrosting $app The main UserFrosting app.
     */
    public function __construct($app){
        $this->_app = $app;
    }

     
 public function view(){
       
        $this->_app->render('delegation.html');          
     }

     

}
