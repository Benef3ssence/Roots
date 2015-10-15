<?php 
namespace UserFrosting;
        
        class MySqlPBideaLoader extends MySqlObjectLoader implements PBideaLoaderInterface{
            protected static $_table;       // The table whose rows this class represents. 
                
            public static function exists($value, $name = "id"){
                return parent::fetch($value, $name);
            }
           
            public static function fetch($value, $name = "id"){
                $results = parent::fetch($value, $name);
                
                if ($results)
                    return new MySqlPBidea($results, $results['id']);
                else
                    return false;
            }
        
          
            
     
   
     }        
        // Fetch a single event by id
          // $event1 = MySqlPBideaLoader::fetch("1");
        // 
        // Fetch a single event by location
        // $event1 = MySqlEventLoader::fetch("Room 101", "location");
        
        // Fetch all events as an array of MySqlEvent objects
        // $events = MySqlEventLoader::fetchAll();
        
        // Fetch all events for a specific location, as an array of MySqlEvent objects
         //$events = MySqlPBideaLoader::fetchAll("Room 101", "location");
        
        ?>