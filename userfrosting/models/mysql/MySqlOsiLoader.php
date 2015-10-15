<?php 
namespace UserFrosting;
        
        class MySqlOsiLoader extends MySqlObjectLoader implements OsiLoaderInterface{
            protected static $_table;       // The table whose rows this class represents. 
                
            public static function exists($value, $name = "id"){
                return parent::fetch($value, $name);
            }
           
            public static function fetch($value, $name = "id"){
                $results = parent::fetch($value, $name);
                
                if ($results)
                    return new MySqlOsi($results, $results['id']);
                else
                    return false;
            }
        
            public static function fetchAll($value = null, $name = null){
                $resultArr = parent::fetchAll($value, $name);
                
                $results = [];
                foreach ($resultArr as $id => $group)
                    $results[$id] = new MySqlOsi($group, $id);
                return $results;
            }
            
     
        
          public function wsall(){ 
		  }  
// SELECT * FROM users WHERE id = ?
 
      
 
}
          
        // Fetch a single event by id
          // $event1 = MySqlBudLoader::fetch("1");
        // 
        // Fetch a single event by location
        // $event1 = MySqlEventLoader::fetch("Room 101", "location");
        
        // Fetch all events as an array of MySqlEvent objects
        // $events = MySqlEventLoader::fetchAll();
        
        // Fetch all events for a specific location, as an array of MySqlEvent objects
         //$events = MySqlBudLoader::fetchAll("Room 101", "location");
        
        ?>