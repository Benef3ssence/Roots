<?php 
namespace UserFrosting;
  
        class MySqlBud extends MySqlDatabaseObject {

 
  public function __construct($properties, $id = null) {
                $this->_table = static::getTable('bud');
				
                parent::__construct($properties, $id);
            }

    public function getGroups(){
        if (!isset($this->_groups))
            $this->_groups = $this->fetchGroups();
            
        return $this->_groups;
    }
 
 


    public function __get($name){
           if ($name == "users")
               return $this->getUsers();
           else
               return parent::__get($name);
        }
        
        public function __isset($name){
           if ($name == "users")
               return $this->_users ? true : false;
           else
               return parent::__get($name);
        }
   public function fresh(){
           $bud = new MySqlBud(parent::fresh(), $this->_id);
           $bud->_users = $this->fetchUsers();
           return $bud;
        }
 
        // Load users for bud 1
     //   $users = $bud->users;
        
        // Change one of those users
      //  $users[0]->title = "The New Kid in Town";
     //   
        // Refresh the bud, updating the user info
      //  $bud = $bud->fresh();

     public function addUser($user_id){
           // First, load current users for event
           $this->getUsers();
           // Return if user already in event
           if (isset($this->_users[$user_id]))
               return $this;
           
           // Next, check that the requested user actually exists
           if (!UserLoader::exists($user_id))
               throw new \Exception("The specified user_id ($user_id) does not exist.");
                   
           // Ok, add to the list of users
           $this->_users[$user_id] = UserLoader::fetch($user_id);
           
           return $this;        
        }
            
        public function removeUser($user_id){
           // First, load current users for bud
           $this->getUsers();
           // Return if user not assigned to bud
           if (!isset($this->_users[$user_id]))
               return $this;
                   
           // Ok, remove from the list of users
           unset($this->_users[$user_id]);
           
           return $this;           
            
        }
   
        public function store(){
           // Update the bud record itself
           parent::store();
           
           // Get the object's associated users
           $this->getUsers();
           
           // Get the bud's users as stored in the DB
           $db_users = $this->fetchUsers();
        
           $link_table = static::getTable('votes_bud')->name;
        
           // Add links to any users linked in object that are not in DB yet
           $db = static::connection();
           $query = "
               INSERT INTO `$link_table` (user_id, bud_id)
               VALUES (:user_id, :bud_id);";
           $stmt = $db->prepare($query);   
           
           foreach ($this->_users as $user_id => $user){       
               // If relationship not in the DB, then add it
               if (!isset($db_users[$user_id])){
                   $sqlVars = [
                       ':user_id' => $user_id,
                       ':bud_id' => $this->_id
                   ];
                   $stmt->execute($sqlVars);
               } 
           }
           
           // Remove any links in DB that are no longer modeled in this object
           if ($db_users){
               $db = static::connection();
               $query = "
                   DELETE FROM `$link_table`
                   WHERE user_id = :user_id
                   AND bud_id = :bud_id LIMIT 1";
               
               $stmt = $db->prepare($query);          
               foreach ($db_users as $user_id => $user){
                   if (!isset($this->_users[$user_id])){
                       $sqlVars = [
                           ':user_id' => $user_id,
                           ':bud_id' => $this->_id
                       ];
                       $stmt->execute($sqlVars);
                   }
               }
           }
           
           // Store function should always return the id of the object
           return $this->_id;
        }
         
        



        public function delete(){        
           // Can only delete an object where `id` is set
           if (!$this->_id) {
               return false;
           }
           
           // Delete the record itself
           $result = parent::delete();
           
           // Get connection
           $db = static::connection();
           $link_table = static::getTable('votes_bud')->name;
           
           // Delete the links
           
           $sqlVars[":id"] = $this->_id;
           
           $query = "
               DELETE FROM `$link_table`
               WHERE bud_id = :id";
               
           $stmt = $db->prepare($query);
           $stmt->execute($sqlVars);    
        
           return $result;
        }
        
}
