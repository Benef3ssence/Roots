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
class OsiController extends \UserFrosting\BaseController {

    /**
     * Create a new UserController object.
     *
     * @param UserFrosting $app The main UserFrosting app.
     */
    public function __construct($app){
        $this->_app = $app;
    }

     
 
 
	 
 public function viewo(){
       $qe = OsiLoader::fetchAll();
        $this->_app->render('osi.html', ["osi" => $qe ]);          
     }
   


}
