<?php 
namespace UserFrosting;
  
        class MySqlPBidea extends MySqlDatabaseObject {

 
  public function __construct($properties, $id = null) {
                $this->_table = static::getTable('pbidea');
        
                parent::__construct($properties, $id);
            }
  
    
      
 
  public function __get($name){
           if ($name == "_pbidea")
               return $this->getPBidea();
           else
               return parent::__get($name);
        }
        
        public function __isset($name){
           if ($name == "_pbidea")
               return $this->_pbidea ? true : false;
           else
               return parent::__get($name);
        }

   
   public function fresh(){
           $pbidea = new MySqlPBidea(parent::fresh(), $this->_id);
           $pbidea->_pbidea = $this->fetchPBideas();
           return $pbidea;
        }
 
        // Load _pbideas for pbidea 1
     //   $_pbideas = $pbidea->_pbideas;
        
        // Change one of those _pbideas
      //  $_pbideas[0]->title = "The New Kid in Town";
     //   
        // Refresh the pbidea, updating the _pbidea info
      //  $pbidea = $pbidea->fresh();
 
  
    public function store() {
        // Get connection
        $db = static::connection();
        $table = $this->_table->name;
        
        // If `id` is set, then try to update an existing object before creating a new one.
        if ($this->_id) {
            $set_terms = [];
            $sqlVars = [];
            foreach ($this->_properties as $name => $value){
                $column_list[] = "`$name`";
                $value_list[] = ":$name";                
                $set_terms[] = "`$name` = :$name" . "_2";
                $sqlVars[":$name"] = $value;
                $sqlVars[":$name" . "_2"] = $value;
            }
           
            $sqlVars[':id'] = $this->_id;
        
            $set_clause = implode(",", $set_terms);
            $column_clause = implode(",", $column_list);            
            $value_clause = implode(",", $value_list);
            
            $query = "
                INSERT INTO `$table`
                ( id, $column_clause )
                VALUES ( :id, $value_clause )
                ON DUPLICATE KEY UPDATE $set_clause";
                
            $stmt = $db->prepare($query);
            $stmt->execute($sqlVars);
        } else {
            $sqlVars = [];
            foreach ($this->_properties as $name => $value){
                $column_list[] = "`$name`";
                $value_list[] = ":$name";
                $sqlVars[":$name"] = $value;
            }
        
            $column_clause = implode(",", $column_list);            
            $value_clause = implode(",", $value_list);
            
            $query = "
                INSERT INTO `$table`
                ( $column_clause )
                VALUES ( $value_clause );";
        
            $stmt = $db->prepare($query);
            $stmt->execute($sqlVars);
            $this->_id = $db->lastInsertId();
        }
        return $this->_id;
    }
        
 
}