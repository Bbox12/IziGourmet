<?php

class DB_Functions {
 
    private $conn;
 
       
    // constructor
    function __construct() {
        require_once 'DB_Connect.php';
        // connecting to database
        $db = new Db_Connect();
        $this->conn = $db->connect();
        
 
    }
 
    // destructor
    function __destruct() {
         
    }




 public function add_order_meat($mobile,$ID,$data,$total,$gross,$del,$package,$discount,$address,$from_lat,$from_long,$checked,$IP,$distance,$pay,$charge){
              $uID=0;

        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i");
        $date=date("Y-m-d");
        $otp=rand(1000,9999);
        $uID=$mobile;
        $unique_id = uniqid(rand(), true);
        $canecl=0;


      
     

        $result=false;

    $myArray=array();
        if(strpos($data, ",")!==false){
        $myArray = explode(',', $data);
    
    }else{
         $myArray = $data;
        $laterDate=$data;
    
    }
 
   
        if(count($myArray)>1){
            $dataArray=array();
        $myArray = explode(',', $data);
        foreach($myArray as $laterDate){
               if(strpos($laterDate, "_")!==false){

               // echo $laterDate;
        $dataArray = explode('_', $laterDate);

            if($uID!=0){
            $stmt=$this->conn->prepare("INSERT INTO `store_order`(`UserID`,`OrderID`, `CanteenID`, `FoodID`, `NoofItems`,`Date`,`Time`) VALUES (?,?,?,?,?,?,?)");
            $stmt->bind_param("iiiiiss",$uID,$otp,$ID,$dataArray[0],$dataArray[1],$date,$hour);
            $result=$stmt->execute();

             if($stmt->errno==0){
                $result=true;
            }

            $stmt->close();
             
        }

                            }
        }
           }else{
         $myArray = $data;
         if(strpos($data, "_")!==false){
         $dataArray = explode('_', $data);

            if($uID!=0){
            $stmt=$this->conn->prepare("INSERT INTO `store_order`(`UserID`,`OrderID`, `CanteenID`, `FoodID`, `NoofItems`,`Date`,`Time`) VALUES (?,?,?,?,?,?,?)");
            $stmt->bind_param("iiiiiss",$uID,$otp,$ID,$dataArray[0],$dataArray[1],$date,$hour);
            $result=$stmt->execute();
             if($stmt->errno==0){
                $result=true;
            }
        
            $stmt->close();
             
        }

                            }
            }

      
        if($result){
 
               $result=false;
       
           $stmt=$this->conn->prepare("INSERT INTO `update_user_order`(`UserID`, `OrderID`, `Gross`, `Discount`, `Packaging`, `Delievery`, `Total`, `Date`, `Time`) VALUES  (?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param("iidddddss",$uID,$otp,$gross,$discount,$package,$del,$total,$date,$hour);
            $result=$stmt->execute();
             if($stmt->errno==0){
                $result=true;
            }
      
            $stmt->close();
         
        if($result){
                 $stmt=$this->conn->prepare("INSERT INTO `delievered`(`OrderID`,`Date`, `Time`) VALUES  (?,?,?)");
            $stmt->bind_param("iss",$otp,$date,$hour);
            $result=$stmt->execute();
              $last_id=$stmt->insert_id;
             $error=$stmt->errno;
    
            $stmt->close();



            if($error==0){
         $stmt = $this->conn->prepare("INSERT INTO book_ride(`OTP`,`Unique_Ride_Code`,`IDDelivery`, `User_ID`,`From_Address`,`From_Latitude`, `From_Longitude`, `Booking_Date`,`Booking_Time`,Distance_Travel,Cost,`PaymentMode`,`Date`, `Time`, `User`, `IP`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("isiisddssddissss",$otp,$unique_id,$last_id,$mobile,$address,$from_lat,$from_long,$date,$hour,$distance,$total,$pay,$date,$hour,$mobile,$IP);
                $stmt->execute();
         
              if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();



        if($checked==1){
              $stmt=$this->conn->prepare("UPDATE `user_details` SET `Favorite_Home_Address`=? WHERE `ID`=?");
        $stmt->bind_param("si",$address,$mobile);
        $stmt->execute();
       
        $stmt->close();
           }else if($checked==2){
              $stmt=$this->conn->prepare("UPDATE `user_details` SET `Favourite_Work_Address`=? WHERE `ID`=?");
        $stmt->bind_param("si",$address,$mobile);
        $stmt->execute();
        $stmt->close();
           }else if($checked==3){
              $stmt=$this->conn->prepare("UPDATE `user_details` SET `Favourite_Other_Address`=? WHERE `ID`=?");
        $stmt->bind_param("si",$address,$mobile);
        $stmt->execute();
        $stmt->close();
           }


            }

             }


                     
 }
 
        if ($result) {
      
            $stmt = $this->conn->prepare("SELECT * FROM book_ride WHERE  User_ID=? AND `Unique_Ride_Code`=?");
            $stmt->bind_param("is", $mobile,$unique_id);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $user;
        } else {
            return false;
        
    }
       
    }


 public function storerating($unique,$rating){

        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i:sa");
        $date=date("Y-m-d");
        $result=false;

        $stmt=$this->conn->prepare("SELECT ID FROM book_ride WHERE Unique_Ride_Code=? ");
        $stmt->bind_param("i", $unique);
        $stmt->execute();
        $user2 = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $ID=$user2["ID"];

        if($ID!=0){
  
            $stmt = $this->conn->prepare("UPDATE book_ride SET Driver_Rating_By_User=? WHERE ID=?");

            $stmt->bind_param("di",$rating,$ID);
            $stmt->execute();
             printf("Error: %d.\n", $stmt->errno);
   if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
       
   
}
            // Check for successful insertion
            if ($result) {
        
               return true;
            } else {
                // Failed to create user
               return false;
            }
        

       
    }






         public function logout($mobile){

        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i:sa");
        $date=date("Y-m-d");
        $result=false;

        $stmt=$this->conn->prepare("SELECT ID FROM user_details WHERE ID=? ");
        $stmt->bind_param("i", $mobile);
        $stmt->execute();
        $user2 = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $ID=$user2["ID"];

        if($ID!=0){
  
            $stmt = $this->conn->prepare("UPDATE user_details SET Logout=1 WHERE ID=?");

            $stmt->bind_param("i",$ID);
            $stmt->execute();
  printf("Error: %d.\n", $stmt->errno);
   if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
       
   
}
            // Check for successful insertion
            if ($result) {
        
               return true;
            } else {
                // Failed to create user
               return false;
            }
        

       
    }




         public function storeCheck($uniqueid,$mobile,$file_path){

        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i:sa");
        $date=date("Y-m-d");
        $result=false;
        $bID=0;

        $stmt=$this->conn->prepare("SELECT ID FROM user_details WHERE ID=? ");
        $stmt->bind_param("i", $mobile);
        $stmt->execute();
        $user2 = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $ID=$user2["ID"];

        if(count($user2)!=0){
        $stmt=$this->conn->prepare("SELECT ID,Unique_Ride_Code FROM book_ride WHERE Unique_Ride_Code=? AND User_ID=? ");
        $stmt->bind_param("si", $uniqueid,$ID);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
             $bID=$user["ID"];
        
        
          if($bID!=0){
            $stmt = $this->conn->prepare("UPDATE book_ride SET PaymentMode=2 WHERE Unique_Ride_Code=?");
            $stmt->bind_param("s",$uniqueid);
            $stmt->execute();
            printf("Error: %d.\n", $stmt->errno);
            if($stmt->errno==0){
                $stmt = $this->conn->prepare("INSERT INTO `checks`(`UserID`, `BookingID`, `Filepath`, `Date`, `Time`) VALUES(?,?,?,?,?)");
        $stmt->bind_param("iisss", $mobile,$bID,$file_path,$date,$hour);
        $result = $stmt->execute();
        $error= $stmt->errno;
        printf("Erppror: %d.\n", $stmt->errno);
         if( $stmt->errno==0){
                $result=true;
        
        }else {
             $result=false;
        } 
        $stmt->close(); 
            }
            $stmt->close();
       
    }
}
            // Check for successful insertion
            if ($result) {
        
               return true;
            } else {
                // Failed to create user
               return false;
            }
        

       
    }


     public function signin($mobile,$password,$change){

        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i");
        $date=date("Y-m-d");
        $ParlourID=0;
        $user=0;
        $email=$mobile;
        $Password=sha1($password);
        $PID=0; 
 

        $stmt=$this->conn->prepare("SELECT ID FROM user_details WHERE (Phone_No=?) ");
        $stmt->bind_param("s",$mobile);
        $stmt->execute();
        $user=$stmt->get_result()->fetch_assoc();
        $stmt->close();
        $ParlourID=$user["ID"]; 
      
        if($ParlourID!=0){

        if($change==0){
        $stmt=$this->conn->prepare("SELECT ID,Name FROM user_details WHERE Password=? AND ID=? ");
        $stmt->bind_param("si",$Password,$ParlourID);
        $stmt->execute();
        $user=$stmt->get_result()->fetch_assoc();
        $stmt->close();
        $PID=$user["ID"]; 
         if( $PID!=0){

        $stmt=$this->conn->prepare("SELECT * FROM user_details WHERE ID=? ");
        $stmt->bind_param("i",$ParlourID);
        $stmt->execute();
        $user=$stmt->get_result()->fetch_assoc();
        $stmt->close();
   
        
        }else {
            $user=0;
    
        } 
    }else{
               printf("Erppror: %s.\n", $Password);

                     printf("Erppror: %d.\n", $ParlourID);

        $stmt=$this->conn->prepare("UPDATE user_details SET  Password=? WHERE ID=? ");
        $stmt->bind_param("si",$Password,$ParlourID);
        $stmt->execute();

         if( $stmt->errno==0){
                $result=true;
        
        }else {
             $result=false;
        } 
        $stmt->close();
    
        if($result){
                  $stmt=$this->conn->prepare("SELECT * FROM user_details WHERE ID=? ");
        $stmt->bind_param("i",$ParlourID);
        $stmt->execute();
        $user=$stmt->get_result()->fetch_assoc();
        $stmt->close();
        }
  
   
   
       
    }
        
     
    }



       
       
       return $user; 
    }


     public function signup($name,$mobile,$password,$file_path){

        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i");
        $date=date("Y-m-d");
        $ParlourID=0;
        $result=false;
        $ParlourID=0; 
        $Password=sha1($password);


        
        $stmt=$this->conn->prepare("SELECT ID FROM user_details WHERE Phone_No=?  ");
        $stmt->bind_param("s",$mobile);
        $stmt->execute();
        $user=$stmt->get_result()->fetch_assoc();
        $stmt->close();
        $ParlourID=$user["ID"];   


              if($ParlourID==0){
              $stmt = $this->conn->prepare("INSERT INTO `user_details`(`Name`, `Password`, `Photo`, `Phone_No`, `Date`, `Time`) VALUES(?,?,?,?,?,?)");
        $stmt->bind_param("ssssss", $name,$Password,$file_path,$mobile,$date,$hour);
        $result = $stmt->execute();
        $last_id = $stmt->insert_id;
        $error= $stmt->errno;
     
         if( $stmt->errno==0){
                $result=true;
        
        }else {
             $result=false;
        } 
        $stmt->close(); 
    }else{
         $stmt = $this->conn->prepare("UPDATE `user_details`SET `Name`=?,`Photo`=?, `Phone_No`=?,`Password`=?, `Date`=?, `Time`=? WHERE ID=?");
        $stmt->bind_param("ssssssi", $name,$file_path,$mobile,$Password,$date,$hour,$ParlourID);
        $result = $stmt->execute();
        $last_id = $ParlourID;
        $error= $stmt->errno;
     
         if( $stmt->errno==0){
                $result=true;
        
        }else {
             $result=false;
        } 
        $stmt->close(); 
    }
      
       if($result){
           $stmt=$this->conn->prepare("SELECT * FROM user_details WHERE ID=? ");
        $stmt->bind_param("i",$last_id);
        $stmt->execute();
        $user=$stmt->get_result()->fetch_assoc();
        $stmt->close();
       }
    

       

       return $user;

       
    }




     public function add_order_payment($mobile,$uniqueid,$pay){

        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i:sa");
        $date=date("Y-m-d");
        $result=false;

        $stmt=$this->conn->prepare("SELECT ID FROM user_details WHERE ID=? ");
        $stmt->bind_param("s", $mobile);
        $stmt->execute();
        $user2 = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $ID=$user2["ID"];

        if(count($user2)!=0){
        $stmt=$this->conn->prepare("SELECT Unique_Ride_Code FROM book_ride WHERE Unique_Ride_Code=? AND User_ID=? ");
        $stmt->bind_param("si", $uniqueid,$ID);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        
        
          if(count($user)!=0){
            $stmt = $this->conn->prepare("UPDATE book_ride SET PaymentMode=? WHERE Unique_Ride_Code=?");

            $stmt->bind_param("is",$pay,$uniqueid);
            $stmt->execute();
  printf("Error: %d.\n", $stmt->errno);
   if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
       
    }
}
            // Check for successful insertion
            if ($result) {
        
               return true;
            } else {
                // Failed to create user
               return false;
            }
        

       
    }




          public function Update_food_hotel($ID,$available,$Price,$Discount,$NewPrice){

        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i");
        $date=date("Y-m-d");
        $stmt=$this->conn->prepare("SELECT ID FROM foods WHERE ID=?");
        $stmt->bind_param("i", $ID);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $uID=$user["ID"];

        $result=false;
      

        if($uID!=0){

     $stmt=$this->conn->prepare("UPDATE `foods` SET `Price`=?,`eTEZ_Price`=?,`Discount`=?,`Available`=? WHERE ID=?");
            $stmt->bind_param("dddii",$Price,$NewPrice,$Discount,$available,$ID);
            $result=$stmt->execute();
             if($stmt->errno==0){
                $result=true;
            }
             printf("noError: %d.\n", $stmt->errno);
            $stmt->close();
             
        }
 
        // check for successful store
       
            return $result;
       
    }

      public function postCanteenreview($title,$rating,$ID,$mobile){

        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i");
        $date=date("Y-m-d");
        $stmt=$this->conn->prepare("SELECT ID FROM user_details WHERE Phone_No=?");
        $stmt->bind_param("s", $mobile);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $uID=$user["ID"];

        $result=false;
      

        if($uID!=0){

   

            $stmt=$this->conn->prepare("INSERT INTO `canteen_review`(`UserID`, `CanteenID`, `Review`, `Rating`, `Date`, `Time`)   VALUES (?,?,?,?,?,?)");
            $stmt->bind_param("iisdss",$uID,$ID,$title,$rating,$date,$hour);
            $result=$stmt->execute();
             if($stmt->errno==0){
                $result=true;
            }
             printf("Error: %d.\n", $stmt->errno);
            $stmt->close();


            if($result){
                 $stmt=$this->conn->prepare("SELECT NoofPerson,Rating FROM  tez_Canteen WHERE ID=?");
        $stmt->bind_param("i", $ID);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $Rating1=$user["Rating"]*$user["NoofPerson"]+$rating;
         $NoofPerson=$user["NoofPerson"]+1;
         $newRating=$Rating1/$NoofPerson;
         echo $newRating;
         echo $NoofPerson;
                 $stmt=$this->conn->prepare("UPDATE `tez_Canteen` SET `NoofPerson`=?,`Rating`=? WHERE ID=?");
            $stmt->bind_param("idi",$NoofPerson,$newRating,$ID);
            $result=$stmt->execute();
             if($stmt->errno==0){
                $result=true;
            }
             printf("noError: %d.\n", $stmt->errno);
            $stmt->close();
            }

             
        }
 
        // check for successful store
       
            return $result;
       
    }

      public function postreview($title,$rating,$ID,$mobile){

        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i");
        $date=date("Y-m-d");
        $stmt=$this->conn->prepare("SELECT ID FROM user_details WHERE Phone_No=?");
        $stmt->bind_param("s", $mobile);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $uID=$user["ID"];

        $result=false;
      

        if($uID!=0){

   

            $stmt=$this->conn->prepare("INSERT INTO `food_review`(`UserID`, `FoodID`, `Review`, `Rating`, `Date`, `Time`)  VALUES (?,?,?,?,?,?)");
            $stmt->bind_param("iisdss",$uID,$ID,$title,$rating,$date,$hour);
            $result=$stmt->execute();
             if($stmt->errno==0){
             $stmt=$this->conn->prepare("SELECT NoofPerson,Rating FROM  foods WHERE ID=?");
        $stmt->bind_param("i", $ID);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $Rating1=$user["Rating"]*$user["NoofPerson"]+$rating;
         $NoofPerson=$user["NoofPerson"]+1;
         $newRating=$Rating1/$NoofPerson;
         echo $newRating;
         echo $NoofPerson;
        $stmt=$this->conn->prepare("UPDATE `foods` SET `NoofPerson`=?,`Rating`=? WHERE ID=?");
            $stmt->bind_param("idi",$NoofPerson,$newRating,$ID);
            $result=$stmt->execute();
             if($stmt->errno==0){
                $result=true;
            }
             printf("noError: %d.\n", $stmt->errno);
            $stmt->close();
            }
             printf("Error: %d.\n", $stmt->errno);
            $stmt->close();
             
        }
 
        // check for successful store
       
            return $result;
       
    }

        public function add_order($mobile,$ID,$data,$total,$gross,$del,$package,$discount){
              $uID=0;

        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i");
        $date=date("Y-m-d");
        $otp=rand(1000,9999);
        $uID=$mobile;
      

            printf("uID: %d.\n", $uID);
      
     

        $result=false;

    $myArray=array();
        if(strpos($data, ",")!==false){
        $myArray = explode(',', $data);
    
    }else{
         $myArray = $day;
        $laterDate=$day;
    
    }
 
 
        if(count($myArray)>1){
            $dataArray=array();
        $myArray = explode(',', $data);
        foreach($myArray as $laterDate){
               if(strpos($laterDate, "_")!==false){

               // echo $laterDate;
        $dataArray = explode('_', $laterDate);

            if($uID!=0){
            $stmt=$this->conn->prepare("INSERT INTO `store_order`(`UserID`,`OrderID`, `CanteenID`, `FoodID`, `NoofItems`,`Date`,`Time`) VALUES (?,?,?,?,?,?,?)");
            $stmt->bind_param("iiiiiss",$uID,$otp,$ID,$dataArray[0],$dataArray[1],$date,$hour);
            $result=$stmt->execute();
             if($stmt->errno==0){
                $result=true;
            }
         
            $stmt->close();
             
        }
         

                            }
        }
           }else{
         $myArray = $data;
         if(strpos($data, "_")!==false){
        $dataArray = explode('_', $data);

          
            if($uID!=0){
            $stmt=$this->conn->prepare("INSERT INTO `store_order`(`UserID`,`OrderID`, `CanteenID`, `FoodID`, `NoofItems`,`Date`,`Time`) VALUES (?,?,?,?,?,?,?)");
            $stmt->bind_param("iiiiiss",$uID,$otp,$ID,$dataArray[0],$dataArray[1],$date,$hour);
            $result=$stmt->execute();
             if($stmt->errno==0){
                $result=true;
            }
        
            $stmt->close();
             
        }
          

                            }
            }

      
        if($result){


               $result=false;
       
                      $stmt=$this->conn->prepare("INSERT INTO `update_user_order`(`UserID`, `OrderID`, `Gross`, `Discount`, `Packaging`, `Delievery`, `Total`, `Date`, `Time`) VALUES  (?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param("iidddddss",$uID,$otp,$gross,$discount,$package,$del,$total,$date,$hour);
            $result=$stmt->execute();
             if($stmt->errno==0){
                $result=true;
            }
             printf("Error: %d.\n", $stmt->errno);
            $stmt->close();
         
        if($result){
                 $stmt=$this->conn->prepare("INSERT INTO `delievered`(`OrderID`,`Date`, `Time`) VALUES  (?,?,?)");
            $stmt->bind_param("iss",$otp,$date,$hour);
            $result=$stmt->execute();
             if($stmt->errno==0){
                $result=true;
            }
             printf("Error: %d.\n", $stmt->errno);
            $stmt->close();
             }
                     
 }
        
            return $result;
       
    }

         public function createBooking($ID,$mobile,$persons,$date1,$time1){

        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i");
        $date=date("Y-m-d");
        $stmt=$this->conn->prepare("SELECT ID FROM user_details WHERE Phone_No=?");
        $stmt->bind_param("s", $mobile);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $uID=$user["ID"];

        $result=false;
      

        if(count($user)!=0){

   

            $stmt=$this->conn->prepare("INSERT INTO `dinner_booking`( `UserID`, `CanteenID`,`No_of_persons`, `Booking_Date`, `Booking_time`, `Date`, `Time`) VALUES (?,?,?,?,?,?,?)");
            $stmt->bind_param("iiissss",$uID,$ID,$persons,$date1,$time1,$date,$hour);
            $result=$stmt->execute();
             if($stmt->errno==0){
                $result=true;
            }
             printf("Error: %d.\n", $stmt->errno);
            $stmt->close();
             
        }
 
        // check for successful store
       
            return $result;
       
    }

        public function start_ride_after_otp($mobile,$unique_id,$OTP){

        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i:sa");
        $date=date("Y-m-d");
        $result=false;

        $stmt=$this->conn->prepare("SELECT ID FROM driver_details WHERE Phone_No=? ");
        $stmt->bind_param("s", $mobile);
        $stmt->execute();
        $user2 = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $ID=$user2["ID"];

        if(count($user2)!=0){
        $stmt=$this->conn->prepare("SELECT Unique_Ride_Code FROM book_ride WHERE Driver_ID=? AND OTP=? ");
        $stmt->bind_param("ii", $ID,$OTP);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        
        
          if(count($user)!=0){
            $stmt = $this->conn->prepare("UPDATE book_ride SET Is_Running=1,Start_Date=?,Start_time=? WHERE Unique_Ride_Code=?");

            $stmt->bind_param("sss",$date,$hour,$unique_id);
            $stmt->execute();
  printf("Error: %d.\n", $stmt->errno);
   if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
       
    }
}
            // Check for successful insertion
            if ($result) {
        
               return true;
            } else {
                // Failed to create user
               return false;
            }
        

       
    }

    public function uploadVehicleImage($mobile,$vimage,$no,$Vehicle_no){
 
        $result=false;
        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i:sa");
        $date=date("Y-m-d");

        $stmt=$this->conn->prepare("SELECT ID FROM driver_details WHERE Phone_No=?");
        $stmt->bind_param("s", $mobile);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $ID=$user["ID"];
      
       $vehicle_no= str_replace(' ', '', $Vehicle_no);
       
            if(count($user)!=0){
        $stmt=$this->conn->prepare("SELECT * FROM vehicle_detail WHERE Vehicle_No=?");
        $stmt->bind_param("s", $vehicle_no);
        $stmt->execute();
        $user1 = $stmt->get_result()->fetch_assoc();
        $stmt->close();

      
        
          if(count($user1)!=0){
        
             
            $stmt = $this->conn->prepare("UPDATE vehicle_detail SET Registration_Certificate_No=?,Registration_Certificate_Photo=?,`Date`=?,`Time`=?,`User`=? WHERE Vehicle_no=?");
            $stmt->bind_param("ssssss",$no,$vimage,$date,$hour,$mobile,$vehicle_no);
            $result = $stmt->execute();
            printf("Error: %d.\n", $stmt->errno);
             if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
           
         }
    }
            return $result;
       
    }

    public function uploadVehicleOwner($mobile,$vehicle_no,$image_1,$image_2,$dNo,$rcNo,$month,$year,$IP){
      
        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i:sa");
        $date=date("Y-m-d");

        $result=false;
          $result1=false;
        $DRIVERID=0;
        
        $vehicle_no= str_replace(' ', '', $vehicle_no);
        $dNo= str_replace(' ', '', $dNo);
        $rcNo= str_replace(' ', '', $rcNo);


      
        $stmt=$this->conn->prepare("SELECT ID FROM driver_details WHERE Phone_No=?");
        $stmt->bind_param("s", $mobile);
        $stmt->execute();
        $user1 = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $DRIVERID=$user1["ID"];

         if($DRIVERID!==0){

            $stmt = $this->conn->prepare("UPDATE driver_details SET Driving_License_No=?, `Driving_License_Photo`=?, `Valid_month`=?,`Valid_year`=?,`Date`=?, `Time`=?, `User`=?, `IP`=? WHERE ID=?");

            $stmt->bind_param("ssssssssi",$dNo,$image_1,$month,$year,$date,$hour,$mobile,$IP,$DRIVERID);
            $stmt->execute();
            $err= $stmt->errno;
          
             if($err==0){
                $result1=true;
            }
            $stmt->close();     
    }
        if($result1){

        $stmt=$this->conn->prepare("SELECT ID FROM vehicle_detail WHERE Driver_ID=?");
        $stmt->bind_param("s", $DRIVERID);
        $stmt->execute();
        $user2 = $stmt->get_result()->fetch_assoc();
        $stmt->close();
            
    if(count($user2)==0){
      $stmt = $this->conn->prepare("INSERT INTO vehicle_detail(`Driver_ID`,`Vehicle_No`,`Registration_Certificate_No`,`Registration_Certificate_Photo`,`Date`,`Time`,`User`,`IP`) VALUES(?,?,?,?,?,?,?,?)");

          $stmt->bind_param("isssssss",$DRIVERID,$vehicle_no,$rcNo,$image_2,$date,$hour,$mobile,$IP);
         $stmt->execute();
           $err= $stmt->errno;
            printf("Errorno: %d.\n",$stmt->errno);
             if($err==0){
                $result=true;
            }
            $stmt->close();    
    }else{
       $stmt = $this->conn->prepare("UPDATE vehicle_detail SET Vehicle_No=?,Registration_Certificate_No=?,Registration_Certificate_Photo=?,`Date`=?,`Time`=?,`User`=?,`IP`=? WHERE Driver_ID=? ");

            $stmt->bind_param("sssssssi",$vehicle_no,$rcNo,$image_2,$date,$hour,$mobile,$IP,$DRIVERID);
         $stmt->execute();
           $err= $stmt->errno;
            printf("Errorno: %d.\n",$stmt->errno);
             if($err==0){
                $result=true;
            }
            $stmt->close();    
    }
            
    }
   
           
               return $result;
            
    }
       public function uploadDocument($Driver_phone,$Driver_doc){

        $result=false;

        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i:sa");
        $date=date("Y-m-d");
        $stmt=$this->conn->prepare("SELECT * FROM driver_details WHERE Phone_No=?");
        $stmt->bind_param("s", $Driver_phone);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        echo $Driver_doc;
           echo $Driver_phone;
       if(count($user)!=0){
        $stmt = $this->conn->prepare("UPDATE driver_details SET Driving_License_Photo=? WHERE Phone_No = ? ");
        $stmt->bind_param("ss",$Driver_doc,$Driver_phone);
        $stmt->execute();
        if($stmt->errno==0){
                $result=true;
            }
        $stmt->close();
          }      
 
     return $result;
       
    }

 public function uploadDriver($mobile,$name,$Driver_Phone,$email,$Cut,$birth_date,$image,$address,$city,$state,$country,$zip,$lat,$long,$IP){
        $result=false;
        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i:sa");
        $date=date("Y-m-d");

        $stmt=$this->conn->prepare("SELECT ID FROM owner_details WHERE Phone_No=?");
        $stmt->bind_param("s", $mobile);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $ID=$user["ID"];
      

      echo $ID;
        
    if(count($user)!=0){
   
        $stmt=$this->conn->prepare("SELECT Driver_OTP FROM sms_codes_driver WHERE Phone_No=?");
        $stmt->bind_param("s", $Driver_Phone);
        $stmt->execute();
        $user3 = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $otp=$user3["Driver_OTP"];

        echo $otp;

        $stmt=$this->conn->prepare("SELECT ID FROM driver_details WHERE Phone_No=?");
        $stmt->bind_param("s", $Driver_Phone);
        $stmt->execute();
        $user2 = $stmt->get_result()->fetch_assoc();
        $stmt->close();
  

                     if(count($user2)!=0){


                     $stmt = $this->conn->prepare("UPDATE driver_details SET Owner_ID=?, Name=?,Date_Of_Birth=?,Email=?,Identification_Mark=?,Photo=?,Address=?,Country=?,State=?,City=?,Pin=?,`Date`=?,`Time`=?,User=?,IP=? WHERE Driver_OTP=? AND Phone_No=?");

            $stmt->bind_param("issssssssssssssis",$ID,$name,$birth_date,$email,$Cut,$image,$address,$country,$state,$city,$zip,$date,$hour,$mobile,$IP,$otp,$Driver_Phone);
           echo $name;
            $stmt->execute();
            printf("Error: %d.\n", $stmt->errno);
             if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
        
  }else{
      $stmt = $this->conn->prepare("INSERT INTO driver_details(`Owner_ID`, `Name`, `Date_Of_Birth`, `Phone_No`, `Email`, `Identification_Mark`, `Photo`, `Address`, `Country`, `State`, `City`, `Pin`,`Date`, `Time`, `User`, `IP`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

            $stmt->bind_param("isssssssssssssss",$ID,$name,$birth_date,$Driver_Phone,$email,$Cut,$image,$address,$country,$state,$city,$zip,$date,$hour,$mobile,$IP);

            $stmt->execute();
            printf("Error: %d.\n", $stmt->errno);
             if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
  }
     }     
            // Check for successful insertion
           return $result;

       
    }


public function uploadDriverHimself($mobile,$name,$Driver_Phone,$email,$Cut,$birth_date,$image,$address,$city,$state,$country,$zip,$lat,$long,$IP){
        $result=false;
        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i:sa");
        $date=date("Y-m-d");

        $stmt=$this->conn->prepare("SELECT ID,Driver_OTP FROM driver_details WHERE Phone_No=?");
        $stmt->bind_param("s", $mobile);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $ID=$user["ID"];
        $otp=$user["Driver_OTP"];
      


                     if(count($user)!=0){


                     $stmt = $this->conn->prepare("UPDATE driver_details SET  Name=?,Date_Of_Birth=?,Email=?,Identification_Mark=?,Photo=?,Address=?,Country=?,State=?,City=?,Pin=?,`Date`=?,`Time`=?,User=?,IP=? WHERE Driver_OTP=? AND Phone_No=?");

            $stmt->bind_param("ssssssssssssssis",$name,$birth_date,$email,$Cut,$image,$address,$country,$state,$city,$zip,$date,$hour,$mobile,$IP,$otp,$Driver_Phone);
           echo $name;
            $stmt->execute();
            printf("Error: %d.\n", $stmt->errno);
             if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
        
  }else{
      $stmt = $this->conn->prepare("INSERT INTO driver_details(`Name`, `Date_Of_Birth`, `Phone_No`, `Email`, `Identification_Mark`, `Photo`, `Address`, `Country`, `State`, `City`, `Pin`,`Date`, `Time`, `User`, `IP`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

            $stmt->bind_param("sssssssssssssss",$ID,$name,$birth_date,$Driver_Phone,$email,$Cut,$image,$address,$country,$state,$city,$zip,$date,$hour,$mobile,$IP);

            $stmt->execute();
            printf("Error: %d.\n", $stmt->errno);
             if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
  }   
            // Check for successful insertion
           return $result;

       
    }



     public function update_driver($mobile,$driver,$driver_otp){
                date_default_timezone_set(TIMEZONE);
  
        $result=false;
        $stmt = $this->conn->prepare("SELECT  * from owner_details WHERE Phone_No = ? ");
        $stmt->bind_param("s", $mobile);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $ID=$user["ID"];
        $stmt->close();
   
        if(count($user)!=0){
        $stmt = $this->conn->prepare("SELECT  * from driver_details WHERE Driver_OTP = ? AND  Owner_ID IS NULL");
        $stmt->bind_param("i", $driver_otp);
        $stmt->execute();
        $user2 = $stmt->get_result()->fetch_assoc();
        $ID2=$user2["ID"];
        $stmt->close();
      if(count($user2)!=0){
            $stmt=$this->conn->prepare("UPDATE driver_details SET Owner_ID=? WHERE  ID=?");
            $stmt->bind_param("ii",$ID,$ID2);
            $stmt->execute();
            if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
          }
      
        }
         if($result){
            $stmt = $this->conn->prepare("SELECT * FROM driver_details WHERE Owner_ID = ? AND ID=?");
            $stmt->bind_param("ii", $ID,$ID2);
            $stmt->execute();
            $stmt->error_list;
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $user;
         }
         return $result;
  
    }

      public function delete_driver($mobile,$driver){
                date_default_timezone_set(TIMEZONE);
        $result=false;
        $stmt = $this->conn->prepare("SELECT  * from owner_details WHERE Phone_No = ? ");
        $stmt->bind_param("s", $mobile);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $Owner_ID=$user["ID"];
        $stmt->close();
        if(count($user)!=0){
        $stmt = $this->conn->prepare("SELECT  * from driver_details WHERE Phone_No=? AND Owner_ID=?");
        $stmt->bind_param("si", $driver,$Owner_ID);
        $stmt->execute();
        $user2 = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $Driver_ID=$user2["ID"];
          echo $Driver_ID;
        if(count($user2)!=0){
            $stmt=$this->conn->prepare("UPDATE driver_details SET Owner_ID=NULL WHERE Phone_No=?");
            $stmt->bind_param("s",$driver);
            $stmt->execute();
            $stmt->close();

        $stmt = $this->conn->prepare("SELECT  * from vehicle_detail WHERE Owner_ID=? AND Driver_ID=?");
        $stmt->bind_param("ii", $Owner_ID,$Driver_ID);
        $stmt->execute();
        $user3 = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $Vehicle_ID=$user3["Vehicle_No"];
        if(count($user3)!=0){
             $stmt=$this->conn->prepare("UPDATE vehicle_detail SET Driver_ID=NULL WHERE Owner_ID=? AND Vehicle_No=?");
            $stmt->bind_param("is",$Owner_ID,$Vehicle_ID);
            $stmt->execute();
             if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
        }
            
     }
   }
        
          
          return $result;
      
  
    }

  public function uploadOwnerAsDriverDocument($Cam,$WHO,$mobile,$Driver_doc){

        $result=false;

        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i:sa");
        $date=date("Y-m-d");
        $stmt=$this->conn->prepare("SELECT ID FROM owner_details WHERE Phone_No=?");
        $stmt->bind_param("s", $mobile);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $ID=$user["ID"];
      
        
         
          if(strpos($Cam, 'Pancard')!== false ){
             $stmt = $this->conn->prepare("UPDATE driver_details SET   Pancard_Photo=? WHERE Owner_ID = ? ");
        $stmt->bind_param("si",$Driver_doc,$ID);
        $stmt->execute();
           printf("Error: %d.\n", $stmt->errno);
             if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
                  }else 

                  if(strpos($Cam, 'Addressproof')!== false ){
             $stmt = $this->conn->prepare("UPDATE driver_details SET Addressproof_Photo=? WHERE Owner_ID = ? ");
        $stmt->bind_param("si",$Driver_doc,$ID);
        $stmt->execute();
           printf("Error: %d.\n", $stmt->errno);
             if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
                  }else


                  if(strpos($Cam, 'Aadharcard')!== false ){
             $stmt = $this->conn->prepare("UPDATE driver_details SET Aadhar_Card_Photo=? WHERE Owner_ID = ? ");
        $stmt->bind_param("si",$Driver_doc,$ID);
       $stmt->execute();
           printf("Error: %d.\n", $stmt->errno);
             if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
                  }else

                          if(strpos($Cam, 'DL')!== false ){
             $stmt = $this->conn->prepare("UPDATE driver_details SET Driving_License_Photo=? WHERE Owner_ID = ? ");
        $stmt->bind_param("si",$Driver_doc,$ID);
         $stmt->execute();
           printf("Error: %d.\n", $stmt->errno);
             if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
                  }else
      
                  if(strpos($Cam, 'Cancelcheck')!== false ){
             $stmt = $this->conn->prepare("UPDATE driver_details SET Cancel_Cheque_Photo=? WHERE Owner_ID = ? ");
        $stmt->bind_param("si",$Driver_doc,$ID);
        $stmt->execute();
           printf("Error: %d.\n", $stmt->errno);
             if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
                  }


        return $result ;  
    }




public function uploadOwnerAsDriver($mobile,$Phoneno,$Owner_image,$Firstname,$Email,$Birthdate,$Street_address1,$City,$State,$Country,$Pin,$IP,$Identification,$Firebase_Token){

        $response = array();
        $result=false;
        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i:sa");
        $date=date("Y-m-d");
         $Unique_id = uniqid(rand(), true);
        
            // insert query

        $stmt=$this->conn->prepare("SELECT ID,App_Install_Date,App_Install_Time FROM owner_details WHERE Phone_No=? ");
        $stmt->bind_param("s", $mobile);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $ID=$user["ID"];
        $App_Install_Date=$user["App_Install_Date"];
        $App_Install_Time=$user["App_Install_Time"];
  
         
        if(count($user)!=0) {
        $stmt=$this->conn->prepare("SELECT Owner_OTP FROM sms_codes_owner WHERE Phone_No=? ");
        $stmt->bind_param("s", $mobile);
        $stmt->execute();
        $user2 = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $OTP=$user2["Owner_OTP"];


        $stmt=$this->conn->prepare("SELECT ID FROM driver_details WHERE Phone_No=? ");
        $stmt->bind_param("s", $mobile);
        $stmt->execute();
        $user1 = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $ID=$user["ID"];
        if(count($user1)!=0) {
          $stmt = $this->conn->prepare("UPDATE driver_details SET Name=?,Date_Of_Birth=?,`Email`=?,`Photo`=?,`Address`=?,`Country`=?,`State`=?,`City`=?,`Pin`=?,Firebase_Token=?,`Date`=?,`Time`=?,User=?,IP=? WHERE  Phone_No=? AND Driver_OTP=?");
            $stmt->bind_param("sssssssssssssssi",$Firstname,$Birthdate,$Email,$Owner_image,$Street_address1,$Country,$State,$City,$Pin,$Firebase_Token,$date,$hour,$mobile,$IP,$Phoneno,$OTP);
           $stmt->execute();
           printf("Error: %d.\n", $stmt->errno);
             if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
          }else{
            $stmt = $this->conn->prepare("INSERT INTO  driver_details(Driver_OTP,Owner_ID,Name,Date_Of_Birth,Phone_No,Email,Identification_Mark,Photo,Address,Country,State,City,Pin,App_Install_Date,App_Install_Time,Firebase_Token,`Date`,`Time`,User,IP) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param("iissssssssssssssssss",$OTP,$ID,$Firstname,$Birthdate,$Phoneno,$Email,$Identification,$Owner_image,$Street_address1,$Country,$State,$City,$Pin,$App_Install_Date,$App_Install_Time,$Firebase_Token,$date,$hour,$mobile,$IP);
            $stmt->execute();
            printf("Error: %d.\n", $stmt->errno);
              if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();

          }
        }
           
                return $result;
       
    }
       public function uploadOwnerDocument($Cam,$WHO,$mobile,$Driver_Phone,$Driver_doc,$proof){

        $result="";

        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i:sa");
        $date=date("Y-m-d");
        $stmt=$this->conn->prepare("SELECT Phone_No FROM owner_details WHERE Phone_No=?");
        $stmt->bind_param("s", $mobile);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
      
        if(strlen($proof)!=0){
        $stmt=$this->conn->prepare("SELECT ID FROM address_proof_documents WHERE Document_Name=? ");
        $stmt->bind_param("s", $proof);
        $stmt->execute();
        $user5 = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $ID=$user5["ID"];
        }
        
          if(strpos($Cam, 'Pancard')!== false ){
             $stmt = $this->conn->prepare("UPDATE owner_details SET   Pancard_Photo=? WHERE Phone_No = ? ");
        $stmt->bind_param("ss",$Driver_doc,$mobile);
        $result = $stmt->execute();
            printf("Error: %d.\n", $stmt->errno);
            $stmt->close();
                  }
                  else if(strpos($Cam, 'Addressproof')!== false ){
                      echo $ID;
             $stmt = $this->conn->prepare("UPDATE owner_details SET Addressproof_Document=?,Addressproof_Photo=? WHERE Phone_No = ? ");
        $stmt->bind_param("iss",$ID,$Driver_doc,$mobile);
        $result = $stmt->execute();

            printf("Error: %d.\n", $stmt->errno);
            $stmt->close();
                  }
                  if(strpos($Cam, 'Aadharcard')!== false ){
             $stmt = $this->conn->prepare("UPDATE owner_details SET Aadhar_Card_Photo=? WHERE Phone_No = ? ");
        $stmt->bind_param("ss",$Driver_doc,$mobile);
        $result = $stmt->execute();

            printf("Error: %d.\n", $stmt->errno);
            $stmt->close();
                  }
      
                  if(strpos($Cam, 'Cancelcheck')!== false ){
             $stmt = $this->conn->prepare("UPDATE owner_details SET Cancel_Cheque_Photo=? WHERE Phone_No = ? ");
        $stmt->bind_param("ss",$Driver_doc,$mobile);
        $result = $stmt->execute();
   
            printf("Error: %d.\n", $stmt->errno);
            $stmt->close();
                  }
   
            if ($result) {
  $stmt = $this->conn->prepare("SELECT * FROM owner_details WHERE Phone_No = ?");
            $stmt->bind_param("s", $mobile);
            $stmt->execute();
            $stmt->error_list;
             printf("Error: %d.\n", $stmt->errno);
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $user;
        } else {
          return NULL;
        }

       
    }

    public function uploadOwnerData($mobile,$Phoneno,$Owner_image,$Firstname,$Email,$Birthdate,$Street_address1,$City,$State,$Country,$Pin){
        $response = array();
        $result=false;
        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i:sa");
        $date=date("Y-m-d");
         $Unique_id = uniqid(rand(), true);
        
            // insert query

        $stmt=$this->conn->prepare("SELECT ID FROM owner_details WHERE Phone_No=? ");
        $stmt->bind_param("s", $mobile);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $ID=$user["ID"];
         
        if(count($user)!=0) {
          $stmt = $this->conn->prepare("UPDATE owner_details SET Name=?,Date_Of_Birth=?,`Email`=?,`Photo`=?,`Address`=?,`Country`=?,`State`=?,`City`=?,`Pin`=? WHERE  Phone_No=?");
            $stmt->bind_param("ssssssssss",$Firstname,$Birthdate,$Email,$Owner_image,$Street_address1,$Country,$State,$City,$Pin,$Phoneno);
           $stmt->execute();
           printf("Error: %d.\n", $stmt->errno);
             if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
          }
           
                return $result;
      
    }

public function add_later_ride($mobile,$time,$day,$return,$IP,$vehicle,$out,$from,$to,$to_lat,$to_long,$from_lat,$from_long,$u_ID,$pager,$distance)
   {

      $result=false;
        date_default_timezone_set(TIMEZONE);
        $h=date("H:i:sa");
        $d=date("Y-m-d");
        $next=date('Y-m-d', strtotime($day. ' + 1 days'));
       
    $myArray=array();
        if(strpos($day, ",")!==false){
        $myArray = explode(',', $day);
    
    }else{
         $myArray = $day;
        $laterDate=$day;
    
    }
 
      
        $stmt=$this->conn->prepare("SELECT ID FROM user_details WHERE Phone_No=? ");
        $stmt->bind_param("s", $mobile);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $ID=$user["ID"];

        $stmt = $this->conn->prepare("SELECT ID FROM vehicle_type_rate_master WHERE Vehicle_Type = ?");
            $stmt->bind_param("s", $vehicle);
            $stmt->execute();
            $user1 = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            $vID=$user1["ID"];

        if(count($user)!=0) {
        if(strpos($return, "true")!==false){ 
        
         if(strpos($pager, "true")!==false){   



                     $stmt=$this->conn->prepare("SELECT * FROM book_ride WHERE User_ID=? AND Unique_Ride_Code=?  ");
                     $stmt->bind_param("is",$ID,$u_ID);
                     $stmt->execute();
                     $user2 = $stmt->get_result()->fetch_assoc();
                     printf("Errorkela: %d.\n", $stmt->errno);
                        if($stmt->errno==0){
                $result=true;
            }
                     $stmt->close();
 
    
        if(count($user2)!=0){ 
             echo count($user2);
              $stmt = $this->conn->prepare("UPDATE book_ride SET `Is_Roudtrip`=1,Return_date=?,Return_time=?,`Date`=?,`Time`=? WHERE User_ID=? AND Unique_Ride_Code=?");
              $stmt->bind_param("ssssis",$day,$time,$d,$h,$ID,$u_ID);
              $result = $stmt->execute();
              printf("Errorno: %d.\n", $stmt->errno);
              if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
         }
       }else{


         $stmt=$this->conn->prepare("SELECT * FROM book_ride WHERE User_ID=? AND Unique_Ride_Code=? ");
        $stmt->bind_param("is",$ID,$u_ID);
        $stmt->execute();
        $user3 = $stmt->get_result()->fetch_assoc();
        $stmt->close();
 

        if(count($user3)!=0){ 
           echo "day";
            $stmt = $this->conn->prepare("UPDATE book_ride SET Start_Date=?,Start_time=?,Return_date=?,Return_time=?,`Date`=?,`Time`=? WHERE User_ID=? AND Unique_Ride_Code=?");
            $stmt->bind_param("ssssssis",$day,$time,$next,$time,$d,$h,$ID,$u_ID);
            $result = $stmt->execute();
            printf("Errorbaaal: %d.\n", $stmt->errno);
             if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
  
         }
       }

    }else{

        if(strpos($out, "true")!==false){ 
       
        $stmt=$this->conn->prepare("SELECT User_ID FROM book_ride WHERE User_ID=? AND Start_Date=?");
        $stmt->bind_param("is",$ID,$laterDate);
        $stmt->execute();
        $user4 = $stmt->get_result()->fetch_assoc();
        printf("Error: %d.\n", $stmt->errno);
        $stmt->close();
 

   if(count($user4)==0){ 
          $otp=rand(1000,9999);
          $unique_id = uniqid(rand(), true);

           $stmt = $this->conn->prepare("INSERT INTO book_ride(`OTP`,`Unique_Ride_Code`,`User_ID`,Vehicle_ID,`From_Address`,`To_Address`,`From_Latitude`,`From_Longitude`,`To_Latitude`, `To_Longitude`,`Booking_Date`,`Booking_Time`,`Start_Date`,`Start_time`,`Distance_Travel`,Return_date,Return_time,`is_Ride_Later`,`Is_Roudtrip`,`Date`,`Time`,`IP`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,1,1,?,?,?)");
            $stmt->bind_param("isiissssssssssisssss",$otp,$unique_id,$ID,$vID,$from,$to,$from_lat,$from_long,$to_lat,$to_long,$d,$h,$laterDate,$time,$distance,$next,$time,$d,$h,$IP);
            $stmt->execute();
            printf("NOFuck: %d.\n", $stmt->errno);
             if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();    
                       }
                       else{
        
                         $stmt = $this->conn->prepare("UPDATE book_ride SET `From_Address`=?, `To_Address`=?, `From_Latitude`=?, `From_Longitude`=?, `To_Latitude`=?, `To_Longitude`=?, `Booking_Date`=?, `Booking_Time`=?,  `Start_time`=?,`Distance_Travel`=?,`Date`=?, `Time`=?,`IP`=? WHERE User_ID=? AND Start_Date=? ");
            $stmt->bind_param("sssssssssisssis",$from,$to,$from_lat,$from_long,$to_lat,$to_long,$d,$h,
                $time,$distance,$d,$h,$IP,$ID,$laterDate);
            $stmt->execute();
            printf("Errorhhht: %d.\n", $stmt->errno);
             if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
        
                       } 

    }else{
   
      

        if(count($myArray)>1){
        
        foreach($myArray as $laterDate){
   
        $stmt=$this->conn->prepare("SELECT User_ID FROM book_ride WHERE User_ID=? AND Start_Date=?");
        $stmt->bind_param("is",$ID,$laterDate);
        $stmt->execute();
        $user5 = $stmt->get_result()->fetch_assoc();
        $stmt->close();
 

        if(count($user5)==0){ 
          $otp=rand(1000,9999);
          $unique_id = uniqid(rand(), true);
       
   $stmt = $this->conn->prepare("INSERT INTO book_ride(`OTP`,`Unique_Ride_Code`,`User_ID`,`Vehicle_ID`,`From_Address`,`To_Address`,`From_Latitude`,`From_Longitude`,`To_Latitude`,`To_Longitude`,`Booking_Date`,`Booking_Time`,`Start_Date`,`Start_time`,`Distance_Travel`,`Return_date`,`Return_time`,`is_Ride_Later`,`Date`,`Time`,`IP`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,1,?,?,?)");
            $stmt->bind_param("isiissssssssssisssss",$otp,$unique_id,$ID,$vID,$from,$to,$from_lat,$from_long,$to_lat,$to_long,$d,$h,$laterDate,$time,$distance,$next,$time,$d,$h,$IP);
            $stmt->execute();
            printf("Fuckme: %d.\n", $stmt->errno);
             if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
           

                       }else{
                        echo $laterDate;
                          $stmt = $this->conn->prepare("UPDATE book_ride SET `From_Address`=?, `To_Address`=?, `From_Latitude`=?, `From_Longitude`=?, `To_Latitude`=?, `To_Longitude`=?, `Booking_Date`=?, `Booking_Time`=?,  `Start_time`=?,`Distance_Travel`=?,`Date`=?, `Time`=?,`IP`=? WHERE User_ID=? AND Start_Date=?");
            $stmt->bind_param("sssssssisssisis",$from,$to,$from_lat,$from_long,$to_lat,$to_long,$d,$h,$time,$distance,$d,$h,$IP,$ID,$laterDate);
            $result = $stmt->execute();
            printf("Errorttt: %d.\n", $stmt->errno);
             if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
                       }
                       
   }

     
    }else{
       
        echo $laterDate;
        $stmt=$this->conn->prepare("SELECT * FROM book_ride WHERE User_ID=? AND Start_Date=? AND is_Ride_Later=1  ");
        $stmt->bind_param("is",$ID,$laterDate);
        $stmt->execute();
        $user6 = $stmt->get_result()->fetch_assoc();
        printf("Error: %d.\n", $stmt->errno);
        $stmt->close();
 

        if(count($user6)==0){ 
          $otp=rand(1000,9999);
          $unique_id = uniqid(rand(), true);

           $stmt = $this->conn->prepare("INSERT INTO book_ride(`OTP`,`Unique_Ride_Code`,`User_ID`,Vehicle_ID,`From_Address`,`To_Address`,`From_Latitude`,`From_Longitude`,`To_Latitude`, `To_Longitude`,`Booking_Date`,`Booking_Time`,`Start_Date`,`Start_time`,`Distance_Travel`,`is_Ride_Later`,`Date`,`Time`,`IP`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,1,?,?,?)");
            $stmt->bind_param("isiissssssssssisss",$otp,$unique_id,$ID,$vID,$from,$to,$from_lat,$from_long,$to_lat,$to_long,$d,$h,$laterDate,$time,$distance,$d,$h,$IP);
            $stmt->execute();
            printf("Fuck: %d.\n", $stmt->errno);
             if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
           

                       }
                       else{
                         $stmt = $this->conn->prepare("UPDATE book_ride SET `From_Address`=?, `To_Address`=?, `From_Latitude`=?, `From_Longitude`=?, `To_Latitude`=?, `To_Longitude`=?, `Booking_Date`=?, `Booking_Time`=?,  `Start_time`=?,`Distance_Travel`=?,`Date`=?, `Time`=?,`IP`=? WHERE User_ID=? AND Start_Date=?");
            $stmt->bind_param("sssssssssisssis",$from,$to,$from_lat,$from_long,$to_lat,$to_long,$d,$h,$time,$distance,$d,$h,$IP,$ID,$laterDate);
            $stmt->execute();
            printf("Errorggg: %d.\n", $stmt->errno);
             if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
        
                       } 
                
    }
}
}
}
 
   if ($result) {

              if(strpos($day, ",")!==false){
                     return true;
                  }else{
                                              
             echo $u_ID;
            if(strlen($u_ID)!=0){
                   
            $stmt = $this->conn->prepare("SELECT * FROM book_ride WHERE Unique_Ride_Code=? ");
            $stmt->bind_param("s", $u_ID);
            $stmt->execute();
            $user9 = $stmt->get_result()->fetch_assoc();
            printf("Errorjjj: %d.\n", $stmt->errno);
            $stmt->close();
            return $user9;
               }else{
                 
                                        
            $stmt = $this->conn->prepare("SELECT * FROM book_ride WHERE User_ID=? AND Start_Date=? ");
            $stmt->bind_param("is", $ID,$day);
            $stmt->execute();
            $user9 = $stmt->get_result()->fetch_assoc();
            printf("Errorsss: %d.\n", $stmt->errno);
            $stmt->close();
            return $user9;
        }
        }
        } else {
            return false;
        
    }

    }


    public function book_ride_delete($mobile,$time,$date){
        $response = array();
        $uuid = uniqid(rand(), true);
        date_default_timezone_set(TIMEZONE);
        $result=false;
        $stmt=$this->conn->prepare("SELECT ID FROM user_details WHERE Phone_No=? ");
        $stmt->bind_param("s", $mobile);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $ID=$user["ID"];
    
          if(count($user)!=0){
            $stmt=$this->conn->prepare("SELECT * FROM book_ride WHERE User_ID=? AND Start_Date=? AND Start_time=? ");
        $stmt->bind_param("iss", $ID,$date,$time);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
           printf("Error: %d.\n", $stmt->errno);
        $stmt->close();
    
           if(count($user)!=0){

        
            $stmt = $this->conn->prepare("DELETE FROM book_ride WHERE User_ID=? AND Start_Date=? AND Start_time=? ");
            $stmt->bind_param("iss", $ID,$date,$time);
            $stmt->execute();
            printf("Error: %d.\n", $stmt->errno);
            $stmt->close();
            $result=true;
      
        
    }else{
        $result=false;
    }
}
            // Check for successful insertion
            if ($result) {
            
               return true;
            } else {
                // Failed to create user
               return false;
            }
      
    }
        public function Add_emergency_contacts($mobile,$phone,$name,$IP){
        $response = array();
        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i");
        $date=date("Y-m-d");
        $result=false;
        $stmt=$this->conn->prepare("SELECT ID FROM user_details WHERE Phone_No=? ");
        $stmt->bind_param("s", $mobile);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $ID=$user["ID"];
    
          if(count($user)!=0){

        $stmt=$this->conn->prepare("SELECT Contact_Phone_No FROM users_emergency_contacts WHERE User_ID=? ");
        $stmt->bind_param("i", $ID);
        $stmt->execute();
        $user1 = $stmt->num_rows; 
        $stmt->close();
      echo $user1;

  if($user1<5){
           $number = preg_replace("/[^0-9]/", '', $phone);
        
            $stmt = $this->conn->prepare("INSERT INTO users_emergency_contacts(User_ID,Contact_Name,Contact_Phone_No,`Date`,`Time`,IP) VALUES(?,?,?,?,?,?)");
            $stmt->bind_param("isssss",$ID,$name,$number,$date,$hour,$IP);
            $stmt->execute();
            if($stmt->errno==0){
                $result=true;
            }
            printf("Err: %d.\n", $stmt->errno);
            $stmt->close();
}

}else{
   $result=false;  
}
            // Check for successful insertion
          
               return $result;
          
      
    }

        public function contact_delete($mobile,$name,$contact){
        $response = array();
        $uuid = uniqid(rand(), true);
        date_default_timezone_set(TIMEZONE);
        $result=false;
        $stmt=$this->conn->prepare("SELECT ID FROM user_details WHERE Phone_No=? ");
        $stmt->bind_param("s", $mobile);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $ID=$user["ID"];

        if(count($user)!=0){

        $stmt=$this->conn->prepare("SELECT User_ID FROM users_emergency_contacts WHERE User_ID=?  ");
        $stmt->bind_param("i", $ID);
        $stmt->execute();
        $user1 = $stmt->get_result()->fetch_assoc();
        $stmt->close();

          if(count($user1)!=0){
  echo $ID;
            $stmt = $this->conn->prepare("DELETE FROM users_emergency_contacts WHERE  Contact_Name=? AND Contact_Phone_No=? ");
            $stmt->bind_param("ss",$name,$contact);
            $stmt->execute();
            printf("Error: %d.\n", $stmt->errno);
             if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
        

      
       } else{
        $result=false;
    }
    }else{
        $result=false;
    }

            // Check for successful insertion
               echo $result;
               return $result;
            
      
    }
       public function User_profile_Update($name,$idm,$email,$address,$state,$city,$country,$pin,$lat,$long,$file_path){

        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i");
        $date=date("Y-m-d");
        $Phone_No="0";
        $stmt=$this->conn->prepare("SELECT Phone_No FROM user_details WHERE ID=?");
        $stmt->bind_param("i",$idm);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $Phone_No=$user["Phone_No"];
        $stmt->close();

        $result=false;
      

        if(count($user)!=0){
            $stmt=$this->conn->prepare("UPDATE user_details SET Name=?,Email=?,Photo=?,Address=?,Country=?,State=?,City=?,Pin=?,Latitude=?,Longitude=?,`Date`=?,`Time`=? WHERE Phone_No=?");
            $stmt->bind_param("sssssssssssss",$name,$email,$file_path,$address,$country,$state,$city,$pin,$lat,$long,$date,$hour,$Phone_No);
            $result=$stmt->execute();
             if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
             
        }
 
        // check for successful store
       
            return $result;
       
    }

     public function activateUser($otp,$mobile,$name,$lat,$long,$refer,$IP) {
        $hour=date("H:i");
        $date=date("Y-m-d");
        $result=false;
        $stmt = $this->conn->prepare("SELECT  * from sms_codes_user WHERE User_OTP = ? and Status = 0 and Phone_No=?");
        $stmt->bind_param("is", $otp,$mobile);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $Name=$user["User_Name"];
        $stmt->close();
        if(count($user)!=0){
       
            $stmt=$this->conn->prepare("UPDATE sms_codes_user SET Status=1 WHERE User_OTP = ? 
            and Phone_No=?");
            $stmt->bind_param("is",$otp,$mobile);
            $result=$stmt->execute();
            $stmt->close();

        $stmt = $this->conn->prepare("SELECT  * from user_details WHERE Phone_No = ? ");
        $stmt->bind_param("s",$mobile);
        $stmt->execute();
        $user1 = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        if(count($user1)!=0){

           $stmt=$this->conn->prepare("UPDATE user_details SET Name=?,Latitude=?,Longitude=?,Reference_Code=?,`Date`=?,`Time`=?,IP=? WHERE Phone_No = ? ");
            $stmt->bind_param("ssssssss",$name,$lat,$long,$refer,$date,$hour,$IP,$mobile);
            $result=$stmt->execute();
             printf("Error: %d.\n", $stmt->errno);
             if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
        }else{

          $stmt = $this->conn->prepare("INSERT INTO  user_details(Name,Phone_No,Latitude,Longitude,Reference_Code,`Date`,`Time`,IP) VALUES(?,?,?,?,?,?,?,?)");
            $stmt->bind_param("ssddssss",$name,$mobile,$lat,$long,$refer,$date,$hour,$IP);
            $result = $stmt->execute();
            printf("Error: %d.\n", $stmt->errno);
            if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
        }
        }

       return $result;
    }

        public function add_coupon($coupon,$mobile,$amt,$unique){

        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i");
        $date=date("Y-m-d");
        $result=false;

        $stmt = $this->conn->prepare("SELECT  * from user_details WHERE Phone_No = ?  ");
        $stmt->bind_param("s", $mobile);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $User_ID=$user["ID"];
        $stmt->close();
       if($User_ID!=0){
            $stmt = $this->conn->prepare("UPDATE user_details SET User_Referrence_Code=? WHERE  ID=?");
            $stmt->bind_param("si",$coupon,$User_ID);
            $result = $stmt->execute();
            $error=$stmt->errno;
            $stmt->close();
        if($error==0){
        $stmt = $this->conn->prepare("SELECT  Cost from book_ride WHERE Unique_Ride_Code = ?  ");
        $stmt->bind_param("s", $unique);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $Cost=$user["Cost"]-$amt;
        $stmt->close();

        if($Cost!=0){
           $stmt = $this->conn->prepare("UPDATE book_ride SET Cost=? WHERE  Unique_Ride_Code=?");
            $stmt->bind_param("ss",$Cost,$unique);
            $result = $stmt->execute();
             if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
        }
    }
  }
            return $result;
        
    }

      public function User_OTP($name,$mobile,$refer,$IP){

        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i");
        $date=date("Y-m-d");
        $result=false;
        $User_ID=0;

        $stmt = $this->conn->prepare("SELECT  * from user_details WHERE Phone_No = ?");
        $stmt->bind_param("s", $mobile);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $User_ID=$user["ID"];
        $stmt->close();
       if($User_ID==0){
            $stmt=$this->conn->prepare("INSERT INTO `user_details`( `Name`,`Phone_No`,`User_Referrence_Code`,`Date`, `Time`,`IP`) VALUES (?,?,?,?,?,?)");
            $stmt->bind_param("ssssss",$name,$mobile,$refer,$date,$hour,$IP);
            $result=$stmt->execute();
            if($stmt->errno==0){
                $result=true;
            }
        $stmt->close();
    }else{
         $stmt = $this->conn->prepare("UPDATE user_details SET Name=?,User_Referrence_Code=?,`Date`=?, `Time`=?,`IP`=? WHERE ID=?");
            $stmt->bind_param("sssssi",$name,$refer,$date,$hour,$IP,$User_ID);
            $result = $stmt->execute();
            printf("Error: %d.\n", $stmt->errno);
             if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
    }
            
            if($result){
        $stmt = $this->conn->prepare("SELECT  * from user_details WHERE Phone_No = ?");
        $stmt->bind_param("s", $mobile);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
           return $user;
            }else{
           return $result;
            }
         
        
    }
        public function createOTPOwner($IP,$name,$mobile,$otp) {
        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i:sa");
        $date=date("Y-m-d");

        $stmt = $this->conn->prepare("INSERT INTO sms_codes_owner(`Owner_Name`,`Phone_No`, `Owner_OTP`,`Status`,`Date`,`Time`,`IP`) VALUES(?,?,?,0,?,?,?)");
        $stmt->bind_param("ssisss",$name,$mobile,$otp,$date,$hour,$IP);
        $result = $stmt->execute();
        $stmt->close();
   
        return $result;
    }

    public function activateOwner($otp,$mobile,$file_path) {
        $stmt = $this->conn->prepare("SELECT  * from sms_codes_owner WHERE Owner_OTP = ? and Status = 0 and Phone_No=?");
        $stmt->bind_param("is", $otp,$mobile);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $Name=$user["Owner_Name"];
        $App_Install_Date=$user["Date"];
        $App_Install_Time=$user["Time"];
        $stmt->close();
        if(count($user)!=0){
       
            $stmt=$this->conn->prepare("UPDATE sms_codes_owner SET Status=1 WHERE Owner_OTP = ? 
            and Phone_No=?");
            $stmt->bind_param("is",$otp,$mobile);
            $result=$stmt->execute();
            $stmt->close();

          $stmt = $this->conn->prepare("INSERT INTO  owner_details(Owner_OTP,Name,Phone_No,Photo,App_Install_Date,App_Install_Time) VALUES(?,?,?,?,?,?)");
            $stmt->bind_param("isssss",$otp,$Name,$mobile,$file_path,$App_Install_Date,$App_Install_Time);
            $result = $stmt->execute();
            printf("Error: %d.\n", $stmt->errno);
            $stmt->close();

         if ($result) {
           
            return true;
        } else {
          return false;
        }
        
        }else{
    
        return false;
        }
    }


 public function activateDriver($otp,$mobile,$file_path) {
    date_default_timezone_set(TIMEZONE);
        $hour=date("H:i");
        $date=date("Y-m-d");
        $result=false;
        $stmt = $this->conn->prepare("SELECT  * from sms_codes_driver WHERE Driver_OTP = ? AND Phone_No=? AND Status = 0 ");
        $stmt->bind_param("is", $otp,$mobile);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $Name=$user["Driver_Name"];
       printf("otp: %d.\n", $otp);
         printf("mobile: %d.\n", $mobile);

        $stmt->close();
        if(count($user)!=0){
          echo "Hi";
       
            $stmt=$this->conn->prepare("UPDATE sms_codes_driver SET Status=1 WHERE Driver_OTP = ? 
            and Phone_No=?");
            $stmt->bind_param("is",$otp,$mobile);
            $stmt->execute();
            if($stmt->errno==0){
              $result=true;
            }
            $stmt->close();
        $stmt = $this->conn->prepare("SELECT  * from driver_details WHERE  Phone_No=?  ");
        $stmt->bind_param("s",$mobile);
        $stmt->execute();
        $user1 = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        if(count($user1)==0){
            $stmt = $this->conn->prepare("INSERT INTO  driver_details(Driver_OTP,Name,Phone_No,Photo,App_Install_Date,App_Install_Time) VALUES(?,?,?,?,?,?)");
            $stmt->bind_param("isssss",$otp,$Name,$mobile,$file_path,$date,$hour);
            $stmt->execute();
            printf("Error: %d.\n", $stmt->errno);
            $stmt->close();
}
         if ($result) {
           
            return true;
        } else {
          return false;
        }
        
        }else{
        return false;
        }
    }

     public function createOTPDriver($IP,$name,$mobile,$otp) {
     date_default_timezone_set(TIMEZONE);
        $hour=date("H:i:sa");
        $date=date("Y-m-d");

        $stmt = $this->conn->prepare("INSERT INTO sms_codes_driver(`Driver_Name`,`Phone_No`, `Driver_OTP`,`Status`,`Date`,`Time`,`IP`) VALUES(?,?,?,0,?,?,?)");
        $stmt->bind_param("ssisss",$name,$mobile,$otp,$date,$hour,$IP);
        $result = $stmt->execute();
        $stmt->close();
   
        return $result;
    }
  public function storeLat($User_Mobile,$Lattitude,$Longitude,$Tracking_type){
    $result=false;

         $stmt = $this->conn->prepare("INSERT INTO current_locations(Mobile, Lattitude, Longitude,Tracking_Type) VALUES(?,?,?,?)");
            $stmt->bind_param("ssss",$User_Mobile,$Lattitude,$Longitude,$Tracking_type);
            $stmt->execute();
            printf("Error: %d.\n", $stmt->errno);


            if($stmt->errno==0){
                $result=true;
            }


            $stmt->close();

           return $result;
        
    }

    public function storeLatUser($User_Mobile,$Lattitude,$Longitude,$Tracking_type){
    $result=false;
        $stmt=$this->conn->prepare("SELECT ID FROM user_details WHERE Phone_No=? ");
        $stmt->bind_param("s", $User_Mobile);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $ID=$user["ID"];
        echo $ID;
                  if(count($user)!=0){
         $stmt = $this->conn->prepare("INSERT INTO current_locations_user_on_ride(User_ID, Latitude, Longitude,Tracking_Type) VALUES(?,?,?,?)");
            $stmt->bind_param("isss",$ID,$Lattitude,$Longitude,$Tracking_type);
            $stmt->execute();
            printf("Error: %d.\n", $stmt->errno);


            if($stmt->errno==0){
                $result=true;
            }


            $stmt->close();
          }

           return $result;
        
    }

public function add_change_time($mobile,$otp,$date1,$time){
        $response = array();
        $uuid = uniqid(rand(), true);
        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i");
        $date=date("Y-m-d");
        $result=false;
        $stmt=$this->conn->prepare("SELECT ID FROM user_details WHERE Phone_No=? ");
        $stmt->bind_param("s", $mobile);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $ID=$user["ID"];
      

          if(count($user)!=0){
        $stmt=$this->conn->prepare("SELECT * FROM book_ride WHERE User_ID=? AND OTP=? AND Start_Date=?");
        $stmt->bind_param("iis", $ID,$otp,$date1);
        $stmt->execute();
        $user1 = $stmt->get_result()->fetch_assoc();
             printf("Error: %d.\n", $stmt->errno);
        $stmt->close();
         echo count($user1);
           if(count($user1)!=0){
            $stmt = $this->conn->prepare("UPDATE book_ride SET Start_time=? WHERE User_ID=? AND OTP=?");
            $stmt->bind_param("sii",$time,$ID,$otp);
            $result = $stmt->execute();
            printf("Error: %d.\n", $stmt->errno);
             if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
          
    
        
    }
}
          
               return $result;
           
    }

public function add_later_outstation($mobile,$otp,$vehicle,$cost,$return){
        $response = array();
        $uuid = uniqid(rand(), true);
        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i");
        $date=date("Y-m-d");
  $result=false;
        $stmt=$this->conn->prepare("SELECT ID FROM user_details WHERE Phone_No=? ");
        $stmt->bind_param("s", $mobile);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $ID=$user["ID"];

        $stmt = $this->conn->prepare("SELECT ID FROM vehicle_type_rate_master WHERE Vehicle_Type = ?");
            $stmt->bind_param("s", $vehicle);
            $stmt->execute();
            $user2 = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            $vID=$user2["ID"];
        
          if(count($user)!=0){
            $stmt=$this->conn->prepare("SELECT * FROM book_ride WHERE User_ID=? AND Unique_Ride_Code=?");
        $stmt->bind_param("ii", $ID,$otp);
        $stmt->execute();
        $user1 = $stmt->get_result()->fetch_assoc();
        $stmt->close();

           if(count($user1)!=0){
            if(strpos($return, "1")!=false){
            $stmt = $this->conn->prepare("UPDATE book_ride SET Vehicle_ID=?,Cost=? WHERE User_ID=? AND Unique_Ride_Code=?");
            $stmt->bind_param("isii",$vID,$cost,$ID,$otp);
            $result = $stmt->execute();
            printf("Error: %d.\n", $stmt->errno);
             if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
          }else{
              $stmt = $this->conn->prepare("UPDATE book_ride SET Vehicle_ID=?,Cost=?,`Is_Roudtrip`=0,`Return_date`=NULL, `Return_time`=NULL WHERE User_ID=? AND Unique_Ride_Code=?");
            $stmt->bind_param("isii",$vID,$cost,$ID,$otp);
            $result = $stmt->execute();
            printf("Error: %d.\n", $stmt->errno);
             if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
          }
    
        
    }
}
            // Check for successful insertion
            if ($result) {
    
               return true;
            } else {
                // Failed to create user
               return false;
            }
    }
 public function another_car($mobile,$unique_id,$vehicle){
    
        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i");
        $date=date("Y-m-d");
        $result=false;

        $stmt=$this->conn->prepare("SELECT ID FROM user_details WHERE Phone_No=? ");
        $stmt->bind_param("s", $mobile);
        $stmt->execute();
        $user1 = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $ID=$user1["ID"];
    

        if(count($user1)!=0){
        $stmt=$this->conn->prepare("SELECT * FROM book_ride WHERE User_ID=? AND Unique_Ride_Code=?");
        $stmt->bind_param("is",$ID,$unique_id);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
    
        
          if(count($user)!=0){
     
            $stmt = $this->conn->prepare("SELECT ID FROM vehicle_type_rate_master WHERE Vehicle_Type = ?");
            $stmt->bind_param("s", $vehicle);
            $stmt->execute();
            $user2 = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            $vID=$user2["ID"];

          if(count($user2)!=0){
            $stmt = $this->conn->prepare("UPDATE book_ride SET Driver_ID=NULL,Driver_Accepted_Date=NULL,Driver_Accepted_Time=NULL,Vehicle_ID=?,`Date`=?,`Time`=? WHERE Unique_Ride_Code=?");

            $stmt->bind_param("isss",$vID,$date,$hour,$unique_id);
            $stmt->execute();
            if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
    }
}
} 
              if($result){
                  $stmt=$this->conn->prepare("SELECT Unique_Ride_Code FROM book_ride WHERE User_ID=? AND Unique_Ride_Code=?");
        $stmt->bind_param("is",$ID,$unique_id);
        $stmt->execute();
        $user3 = $stmt->get_result()->fetch_assoc();
        $stmt->close();
      return $user3;

              }else{
                return false;
              }
    }

       public function support_booking($mobile){
        $response = array();
        $uuid = uniqid(rand(), true);
        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i");
        $date=date("Y-m-d");
        $result=false;

        $stmt=$this->conn->prepare("SELECT * FROM stop_ride WHERE User_mobile=? ORDER BY id_booking DESC");
        $stmt->bind_param("s", $mobile);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
    
        
          if(count($user)!=0){
          $result=true;
    }else{
        $result=false;
    }
            // Check for successful insertion
            if ($result) {
        
               return $user;
            } else {
                // Failed to create user
               return false;
            }
      
    }



     public function start_ride_image($mobile,$sobile,$OTP,$IP){
        $response = array();
        $uuid = md5(time());
        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i");
        $date=date("Y-m-d");
        $result=false;

        $uID=$dID=$Ride_ID=0;
  
        $stmt=$this->conn->prepare("SELECT ID FROM user_details WHERE ID=? ");
        $stmt->bind_param("s", $mobile);
        $stmt->execute();
        $user2 = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $dID=$user2["ID"];

        $stmt=$this->conn->prepare("SELECT ID FROM user_details WHERE Phone_No=? ");
        $stmt->bind_param("s", $sobile);
        $stmt->execute();
        $user2 = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $uID=$user2["ID"];

        $stmt=$this->conn->prepare("SELECT ID,Unique_Ride_Code FROM book_ride WHERE Driver_ID=? AND User_ID=? AND OTP=? ");
        $stmt->bind_param("iii", $dID,$uID,$OTP);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $Ride_ID=$user["ID"];

 if($Ride_ID!=0){
       

            $stmt = $this->conn->prepare("UPDATE book_ride SET Is_Running=1,Start_Date=?,Start_time=? WHERE ID=?");

            $stmt->bind_param("sss",$date,$hour,$Ride_ID);
            $stmt->execute();
   printf("Error: %d.\n", $stmt->errno);
   if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();

       
}
            // Check for successful insertion
          return $result;
       
    }



    public function stop_ride_image($mobile,$sMo,$OTP,$IP){
        $response = array();
        $uuid = md5(time());
        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i");
        $date=date("Y-m-d");
        $result=false;

        $uID=$dID=$Ride_ID=0;
  
        $stmt=$this->conn->prepare("SELECT ID FROM user_details WHERE ID=? ");
        $stmt->bind_param("s", $mobile);
        $stmt->execute();
        $user2 = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $dID=$user2["ID"];

        $stmt=$this->conn->prepare("SELECT ID FROM user_details WHERE Phone_No=? ");
        $stmt->bind_param("s", $sMo);
        $stmt->execute();
        $user2 = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $uID=$user2["ID"];

        $stmt=$this->conn->prepare("SELECT ID,Unique_Ride_Code FROM book_ride WHERE Driver_ID=? AND User_ID=? AND OTP=? ");
        $stmt->bind_param("iii", $dID,$uID,$OTP);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $Ride_ID=$user["ID"];

 if($Ride_ID!=0){
       

            $stmt = $this->conn->prepare("UPDATE book_ride SET Is_Running=0,Is_Paid=1,End_Date=?,End_time=? WHERE ID=?");
            $stmt->bind_param("sss",$date,$hour,$Ride_ID);
            $stmt->execute();
   printf("Error: %d.\n", $stmt->errno);
   if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();

              $stmt = $this->conn->prepare("UPDATE delievered SET DriverID=?,Delivered=2 WHERE OrderID=? AND Delivered!=2 ");
            $stmt->bind_param("ii",$dID,$OTP);
            $stmt->execute();
   printf("Error: %d.\n", $stmt->errno);
   if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();

       
}
            // Check for successful insertion
          return $result;
       
    }
  
     public function add_fcm_owner($mobile,$reg){
        $result=false;
        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i");
        $date=date("Y-m-d");
  $result="";
        $stmt=$this->conn->prepare("SELECT Phone_No FROM owner_details WHERE Phone_No=? ");
        $stmt->bind_param("s", $mobile);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $Mobile=$user["Phone_No"];
        
        if(count($user)!=0){
        $stmt=$this->conn->prepare("UPDATE owner_details SET Firebase_Token=? WHERE Phone_No=? ");
        $stmt->bind_param("ss",$reg,$mobile);
        $stmt->execute();
        if($stmt->errno==0){
                $result=true;
            }
        $stmt->close();

           
}
            // Check for successful insertion
           
               return $result;
         
      
    }
    public function add_fcm_driver($mobile,$reg){
        $result=false;
        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i");
        $date=date("Y-m-d");
  $result="";
        $stmt=$this->conn->prepare("SELECT Phone_No FROM driver_details WHERE Phone_No=? ");
        $stmt->bind_param("s", $mobile);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $Mobile=$user["Phone_No"];
        
          if(count($user)!=0){
            $stmt=$this->conn->prepare("UPDATE driver_details SET Firebase_Token=? WHERE Phone_No=? ");
        $stmt->bind_param("ss",$reg,$mobile);
        $stmt->execute();
        if($stmt->errno==0){
                $result=true;
            }
        $stmt->close();

           
}
            // Check for successful insertion
              return $result;
      
    }
    public function add_fcm_user($mobile,$reg){
        $result=false;
        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i");
        $date=date("Y-m-d");
        $result="";
        $stmt=$this->conn->prepare("SELECT Phone_No FROM user_details WHERE Phone_No=? ");
        $stmt->bind_param("s", $mobile);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $Mobile=$user["Phone_No"];
        
          if(count($user)!=0){
            $stmt=$this->conn->prepare("UPDATE user_details SET Firebase_Token=? WHERE Phone_No=? ");
        $stmt->bind_param("ss",$reg,$mobile);
        $stmt->execute();
        if($stmt->errno==0){
                $result=true;
            }
        $stmt->close();

           
}
            // Check for successful insertion
            return $result;
    }


    public function add_fav($mobile,$fav,$address){
        $response = array();
        $uuid = uniqid(rand(), true);
        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i");
        $date=date("Y-m-d");

        $stmt=$this->conn->prepare("SELECT Phone_No FROM user_details WHERE Phone_No=? ");
        $stmt->bind_param("s", $mobile);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $Mobile=$user["Phone_No"];
        
          if(count($user)!=0){
            if(strpos($fav, "HOME")!==false){
            $stmt = $this->conn->prepare("UPDATE user_details SET Favorite_Home_Address=? WHERE Phone_No=?");
            $stmt->bind_param("ss",$address,$Mobile);
            printf("Error: %d.\n", $stmt->errno);
            $result = $stmt->execute();
            }
            else  if(strpos($fav, "WORK")!==false){
            $stmt = $this->conn->prepare("UPDATE user_details SET Favourite_Work_Address=? WHERE Phone_No=?");
            $stmt->bind_param("ss",$address,$Mobile);
            printf("Error: %d.\n", $stmt->errno);
            $result = $stmt->execute();
            }
             else  if(strpos($fav, "OTHER")!==false){
            $stmt = $this->conn->prepare("UPDATE user_details SET Favourite_Other_Address=? WHERE Phone_No=?");
            $stmt->bind_param("ss",$address,$Mobile);
            printf("Error: %d.\n", $stmt->errno);
            $result = $stmt->execute();
            }

    }
            // Check for successful insertion
            if ($result) {
            $stmt = $this->conn->prepare("SELECT * FROM user_details WHERE Phone_No = ?");
            $stmt->bind_param("s", $Mobile);
            $stmt->execute();
            $stmt->error_list;
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
               return true;
            } else {
                // Failed to create user
               return false;
            }
      
    }
  public function stop_ride_finish($driver_mobile,$unique_id,$user_rating,$distance,$paid,$IP,$OTP){
      
        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i:sa");
        $date=date("Y-m-d");
        $result=false;
        $Ride_ID=0;

        
        $stmt=$this->conn->prepare("SELECT ID FROM driver_details WHERE Phone_No=? ");
        $stmt->bind_param("s", $driver_mobile);
        $stmt->execute();
        $user1 = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $Driver_ID=$user1["ID"];


        $stmt=$this->conn->prepare("SELECT ID FROM book_ride WHERE Unique_Ride_Code=? AND Driver_ID=?");
        $stmt->bind_param("si", $unique_id,$Driver_ID);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $Ride_ID=$user["ID"];
        
  
          if($Ride_ID!=0){
            $stmt = $this->conn->prepare("UPDATE book_ride SET Is_Running=0,End_Date=?,End_time=?,Distance_Travel=?,User_Rating_By_Driver=?,Is_Paid=1,`Date`=?,`Time`=?,User=?,IP=? WHERE ID=?");

            $stmt->bind_param("ssssssssi",$date,$hour,$distance,$$user_rating,$date,$hour,$driver_mobile,$IP,$Ride_ID);
            $stmt->execute();
            if($stmt->errno==0){
                $stmt=$this->conn->prepare("SELECT User_ID FROM book_ride WHERE Unique_Ride_Code=? ");
        $stmt->bind_param("s", $unique_id);
        $stmt->execute();
        $user3 = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $User_ID=$user3["User_ID"];
        printf("uid: %d.\n", $User_ID);

         if($User_ID!=0){
        $stmt=$this->conn->prepare("SELECT  User_Rating_By_Driver FROM book_ride WHERE User_ID=? ");
        $stmt->bind_param("i", $User_ID);
        $stmt->execute();
        $stmt->bind_result($tuID);
        while($stmt->fetch()){ 
            $ratsss[] =$tuID;
           $id =$id+1;  
        }

        $sum=array_sum($ratsss);
        $stmt->close();
        $rate=$sum/$id;

          printf("sum: %d.\n", $sum);
           printf("id: %d.\n", $id);
              
        $stmt = $this->conn->prepare("UPDATE user_details SET Rating=?  WHERE ID=?  ");
        $stmt->bind_param("ii",$rate,$User_ID);
        $stmt->execute();
        printf("Error: %d.\n", $stmt->errno);
        $error=$stmt->errno;
         $stmt->close();
         if($error==0){
            $stmt = $this->conn->prepare("SELECT * FROM book_ride WHERE  ID=?");
            $stmt->bind_param("i", $Ride_ID);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
 
            return $user;
        } else {
            return false;
        
            }
      
    }
            }
            printf("Error: %d.\n", $stmt->errno);
            $stmt->close();

            } 

            if($OTP!=0){
                $OrderID=0;
            $stmt = $this->conn->prepare("SELECT `ID`, `OrderID`, `DriverID`, `Date`, `Time` FROM `delievered` WHERE  OrderID=?");
            $stmt->bind_param("i", $OTP);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $OrderID=$user["OrderID"];
            $stmt->close(); 
            if($OrderID!=0){
               $stmt = $this->conn->prepare("UPDATE `delievered` SET `DriverID`=? WHERE  OrderID=?");
            $stmt->bind_param("ii",$Driver_ID,$OrderID);
            $stmt->execute(); 
            $stmt->close(); 
            }

            }  

    
    }
public function stop_ride_driver($driver_mobile,$user_mobile,$unique_id,$user_rating,$review){
        $response = array();
        $uuid = uniqid(rand(), true);
        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i");
        $date=date("Y-m-d");
        $result=false;
        $id=0;

        $stmt=$this->conn->prepare("SELECT ID FROM user_details WHERE Phone_No=? ");
        $stmt->bind_param("s", $user_mobile);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $User_ID=$user["ID"];

        $stmt=$this->conn->prepare("SELECT ID FROM driver_details WHERE Phone_No=? ");
        $stmt->bind_param("s", $driver_mobile);
        $stmt->execute();
        $user1 = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $Driver_ID=$user1["ID"];

        
        $stmt=$this->conn->prepare("SELECT ID FROM book_ride WHERE User_ID=? AND Driver_ID=? AND Unique_Ride_Code=? ");
        $stmt->bind_param("iis", $User_ID,$Driver_ID,$unique_id);
        $stmt->execute();
        $user2 = $stmt->get_result()->fetch_assoc();
        $Ride_ID=$user2["ID"];
        $stmt->close();
        
          if(count($user2)!=0){
            $stmt = $this->conn->prepare("UPDATE book_ride SET Driver_Rating_By_User=?,User_Review=? WHERE ID=?");
            $stmt->bind_param("ssi",$user_rating,$review,$Ride_ID);
            $stmt->execute();
            printf("Error: %d.\n", $stmt->errno);
            if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
        if($result){
            $result=false;
        $stmt=$this->conn->prepare("SELECT  Driver_Rating_By_User FROM book_ride WHERE Driver_ID=? ");
        $stmt->bind_param("i", $Driver_ID);
    
        $stmt->execute() or trigger_error($stmt->error, E_USER_ERROR);

        $stmt->bind_result($rates);

        while($stmt->fetch()){ 
            $rateds[] =$rates;
            $id=$id+1;
          
        }

       $sum=array_sum($rateds);
       echo $sum;

$stmt->close();
    
        printf("ID: %d.\n", $id);
        
        if($id!=0){
  
          $rate1=$sum/$id; 
       
        $stmt = $this->conn->prepare("UPDATE driver_details SET Rating=?  WHERE ID=?  ");
        $stmt->bind_param("di",$rate1,$Driver_ID);
        printf("Error: %d.\n", $stmt->errno);
         if($stmt->errno==0){
                $result=true;
            }
        $stmt->execute();
        $stmt->close();
    }
    }
    }
            // Check for successful insertion
            if ($result) {
               return true;
            } else {
                // Failed to create user
               return false;
            }
        

       
    }
 public function book_ride_update($driver_mobile,$user_mobile,$otp,$cost){
        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i:sa");
        $date=date("Y-m-d");
        $result=false;

        

        $stmt=$this->conn->prepare("SELECT ID FROM user_details WHERE ID=? ");
        $stmt->bind_param("s", $user_mobile);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $User_ID=$user["ID"];

 
       
        
  if(count($user)!=0){

        $stmt=$this->conn->prepare("SELECT ID FROM book_ride WHERE User_ID=? AND Unique_Ride_Code=?");
        $stmt->bind_param("is", $User_ID,$otp);
        $stmt->execute();
        $user1 = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $Unique_ride=$user1["ID"];

        echo $user_mobile;
    }
        
          if($Unique_ride!=0){

        $stmt=$this->conn->prepare("SELECT ID FROM driver_details WHERE Phone_No=? ");
        $stmt->bind_param("s", $driver_mobile);
        $stmt->execute();
        $user2 = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $Driver_ID=$user2["ID"];

        if(count($user2)!=0){

            $stmt = $this->conn->prepare("UPDATE book_ride SET Driver_ID=?,Driver_Accepted_Date=?,Driver_Accepted_Time=?,Cost=? WHERE ID=?");

            $stmt->bind_param("isssi",$Driver_ID,$date,$hour,$cost,$Unique_ride);
            $stmt->execute();
  printf("Error: %d.\n", $stmt->errno);
   if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
        }
    }
            // Check for successful insertion
            if ($result) {
            $stmt = $this->conn->prepare("SELECT * FROM book_ride WHERE ID = ?");
            $stmt->bind_param("i", $Unique_ride);
            $stmt->execute();
            $stmt->error_list;
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
               return $user;
            } else {
                // Failed to create user
               return false;
            }
        

       
    }
  
public function uploadVehicle1($driver,$session_no,$vehicle_no,$vehicle_company,$vehicle_type,$vehicle_model,$vehicle_image_1,$vehicle_image_2,$vehicle_rc,$vehicle_insurance){
        $response = array();
        $uuid = uniqid(rand(), true);
        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i");
        $date=date("Y-m-d");

        $stmt=$this->conn->prepare("SELECT Unique_id FROM owner_detail WHERE Owner_phone=?");
        $stmt->bind_param("s", $session_no);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $Unique_id=$user["Unique_id"];
        $Identification=$user["Identification"];
       
          
            $stmt = $this->conn->prepare("INSERT INTO vehicle_detail(Unique_id,Unique_driver,Vehicle_no,Vehicle_company,Vehicle_model,Vehicle_type,Vehicle_image_1,Vehicle_image_2,Vehicle_rc,Vehicle_insurance,Created_date,Created_time) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");

            $stmt->bind_param("ssssssssssss",$Unique_id,$driver,$vehicle_no,$vehicle_company,$vehicle_model,$vehicle_type,$vehicle_image_1,$vehicle_image_2,$vehicle_rc,$vehicle_insurance,$date,$hour);

            $result = $stmt->execute();
  printf("Error: %d.\n", $stmt->errno);
            $stmt->close();
    
            // Check for successful insertion
            if ($result) {
            $stmt = $this->conn->prepare("SELECT * FROM vehicle_detail WHERE Vehicle_no = ?");
            $stmt->bind_param("s", $vehicle_no);
            $stmt->execute();
            $stmt->error_list;
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
               return true;
            } else {
                // Failed to create user
               return false;
            }
        

       
    }
  
   public function createOwner($name,$mobile,$file_path,$otp) {
        $response = array();

        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i");
        $date=date("Y-m-d");
        $api_="";

            // Generating API key
        $stmt=$this->conn->prepare("SELECT api_key FROM owner_login");
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $api_=$user['api_key'];
        $stmt->close();

        if(!strpos($api, $api_key = $this->generateApiKey())){
            $api_key = $this->generateApiKey();
        }
          
            $stmt = $this->conn->prepare("SELECT Owner_name FROM owner_login WHERE Owner_mobile=?");
            $stmt->bind_param("s",$mobile);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            printf("Error: %d.\n", $stmt->errno);
            $stmt->close();
      
       		if(count($user)==0){
            $stmt = $this->conn->prepare("INSERT INTO  owner_login(Owner_name,Owner_mobile,Owner_image,api_key,status,Created_date,Created_time) VALUES(?,?,?,?,0,?,?)");

            $stmt->bind_param("ssssss",$name,$mobile,$file_path,$api_key,$date,$hour);

            $result = $stmt->execute();

            $new_user_id = $stmt->insert_id;
            printf("Error: %d.\n", $stmt->errno);
            $stmt->close();
        }else{
        	 $stmt=$this->conn->prepare("UPDATE owner_login SET Owner_name=?, Owner_image=?,Created_date=?,Created_time=? WHERE Owner_mobile=?");
            $stmt->bind_param("sssss", $name,$file_path,$date,$hour,$mobile);
            $result=$stmt->execute();
            $stmt->close();

            if($result){
            	 $stmt = $this->conn->prepare("SELECT pk_owner FROM owner_login WHERE Owner_mobile=?");
            $stmt->bind_param("s",$mobile);
            $stmt->execute();
            $user1 = $stmt->get_result()->fetch_assoc();
            printf("Error: %d.\n", $stmt->errno);
            $stmt->close();
             $new_user_id = $user1["pk_owner"];
            }
        }
    
            // Check for successful insertion
            if ($result) {
      
                $otp_result = $this->createOtp($new_user_id, $otp);

                // User successfully inserted
                return true;
            } else {
                // Failed to create user
                return false;
            }
        

    }

 public function validOwner($identity,$mobile) {
        $response = array();

        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i");
        $date=date("Y-m-d");
        $result=false;

    
            // insert query
            $stmt = $this->conn->prepare("SELECT Owner_OTP FROM sms_codes_owner WHERE Phone_No=? and Status=1");
            $stmt->bind_param("s",$mobile);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $OTP=$user["Owner_OTP"];
            printf("Error: %d.\n", $stmt->errno);
            $stmt->close();

            echo $OTP;
      
        if(count($user)!=0){
      
           $stmt = $this->conn->prepare("SELECT Phone_No FROM owner_details WHERE Owner_OTP=? ");
            $stmt->bind_param("i",$OTP);
            $stmt->execute();
             if($stmt->errno==0){
                $result=true;
            }
            printf("Error: %d.\n", $stmt->errno);
            $stmt->close();

}

           
                return $result;
            
   
    }
public function validDriver($identity,$mobile) {
        $response = array();

        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i");
        $date=date("Y-m-d");
        $result=false;

    
            // insert query
            $stmt = $this->conn->prepare("SELECT Driver_OTP FROM sms_codes_driver WHERE Phone_No=? and Status=1");
            $stmt->bind_param("s",$mobile);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $OTP=$user["Driver_OTP"];
            printf("Error: %d.\n", $stmt->errno);
            $stmt->close();
      
       	if(count($user)!=0){
      
           $stmt = $this->conn->prepare("SELECT Phone_No FROM driver_details WHERE Driver_OTP=? ");
            $stmt->bind_param("i",$OTP);
            $stmt->execute();
            $user1 = $stmt->get_result()->fetch_assoc();
            if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();

       		}else{
                $result=false;  
            }
           
           
                return $result;
            
   
    }
   public function createDriver($name,$mobile,$file_path,$otp) {
        $response = array();

        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i");
        $date=date("Y-m-d");
        

            // Generating API key
          $stmt=$this->conn->prepare("SELECT api_key FROM driver_login");
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $api_=$user['api_key'];
        $stmt->close();

        if(!strpos($api, $api_key = $this->generateApiKey())){
            $api_key = $this->generateApiKey();
        }
          
  $stmt = $this->conn->prepare("SELECT Driver_name FROM driver_login WHERE Driver_mobile=?");
            $stmt->bind_param("s",$mobile);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            printf("Error: %d.\n", $stmt->errno);
            $stmt->close();
      
       		if(count($user)==0){
            $stmt = $this->conn->prepare("INSERT INTO  driver_login(Driver_name,Driver_mobile,Driver_image,api_key,status,Created_date,Created_time) VALUES(?,?,?,?,0,?,?)");
            $stmt->bind_param("ssssss",$name,$mobile,$file_path,$api_key,$date,$hour);
            $result = $stmt->execute();
            $new_user_id = $stmt->insert_id;
            printf("Error: %d.\n", $stmt->errno);
            $stmt->close();
        }else{
        	 $stmt=$this->conn->prepare("UPDATE driver_login SET Driver_name=?, Driver_image=?,Created_date=?,Created_time=? WHERE Driver_mobile=?");
            $stmt->bind_param("sssss", $name, $file_path,$date,$hour,$mobile);
            $result=$stmt->execute();
            $stmt->close();
             if($result){
            	 $stmt = $this->conn->prepare("SELECT pk_driver FROM driver_login WHERE Driver_mobile=?");
            $stmt->bind_param("s",$mobile);
            $stmt->execute();
            $user1 = $stmt->get_result()->fetch_assoc();
            printf("Error: %d.\n", $stmt->errno);
            $stmt->close();
             $new_user_id = $user1["pk_driver"];
            }
        }
    
            // Check for successful insertion
            if ($result) {
      
                $otp_result = $this->createOtpDriver($new_user_id, $otp);

                // User successfully inserted
                return true;
            } else {
                // Failed to create user
                return false;
            }

    }

   

    public function createOtp($user_id, $otp) {
     date_default_timezone_set(TIMEZONE);
        $hour=date("H:i");
        $date=date("Y-m-d");
        $result="";

       $stmt=$this->conn->prepare("SELECT User_id FROM sms_codes_owner WHERE User_id=?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
      

        if(count($user)!=0){
        $stmt = $this->conn->prepare("UPDATE sms_codes_owner SET Code=?,Created_date=?,Created_time=? where User_id = ?");
        $stmt->bind_param("issi", $otp,$date,$hour,$user_id);
        $result = $stmt->execute();
        }else{

        $stmt = $this->conn->prepare("INSERT INTO sms_codes_owner(User_id, Code, Status,Created_date,Created_time) VALUES(?, ?, 0,?,?)");
        $stmt->bind_param("isss", $user_id, $otp,$date,$hour);
        $result = $stmt->execute();
        $stmt->close();
    }

        return $result;
    }
   
   
 public function delete_car($mobile,$driver,$vehicle_no){
        $result1=false;
        $result=false;
        $stmt = $this->conn->prepare("SELECT  * from owner_details WHERE Phone_No = ?");
        $stmt->bind_param("s", $mobile);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $OWNERID=$user["ID"];
        $stmt->close();
        if(count($user)!=0){
        $stmt = $this->conn->prepare("SELECT  * from driver_details WHERE Phone_No = ?");
        $stmt->bind_param("s", $driver);
        $stmt->execute();
        $user1 = $stmt->get_result()->fetch_assoc();
        $DRIVERID=$user1["ID"];
        $stmt->close();
         if(count($user1)!=0){
    
            $stmt=$this->conn->prepare("UPDATE vehicle_detail SET Driver_ID=NULL WHERE Vehicle_no=? AND Owner_ID=?");
            $stmt->bind_param("ss",$vehicle_no,$OWNERID);
            $stmt->execute();
            if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
       } else {
          $result= false;
        }

        } else {
          $result= false;
        }
    

    
            return $result;
        
  
    }

     
     public function update_vehicle($mobile,$driver,$vehicle){

        $result=false;
        $stmt = $this->conn->prepare("SELECT  * from owner_details WHERE Phone_No = ?");
        $stmt->bind_param("s", $mobile);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $OWNERID=$user["ID"];
        $stmt->close();
   
        if(count($user)!=0){
        $stmt = $this->conn->prepare("SELECT  * from driver_details WHERE Phone_No = ?");
        $stmt->bind_param("s", $driver);
        $stmt->execute();
        $user1 = $stmt->get_result()->fetch_assoc();
        $DRIVERID=$user1["ID"];
        $stmt->close();

         if(count($user1)!=0){
            $stmt=$this->conn->prepare("UPDATE vehicle_detail SET Driver_ID=? WHERE Vehicle_no=?");
            $stmt->bind_param("is",$DRIVERID,$vehicle);
            $stmt->execute();
            if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
      }
        }
        if($result){
            $stmt = $this->conn->prepare("SELECT * FROM vehicle_detail WHERE Vehicle_no = ?");
            $stmt->bind_param("s", $vehicle);
            $stmt->execute();
            $stmt->error_list;
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $user;
           }else{
         return $result;
     }
  
    }
    private function generateApiKey() {
        return rand(1000,9999);;
    }
   

    public function Add_Imei($mobile,$imei,$driver_lat,$driver_long){
        $response = array();
        $result="";
        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i");
        $date=date("Y-m-d");
        $stmt=$this->conn->prepare("SELECT Unique_id FROM driver_details WHERE  Driver_Phone=? ");
        $stmt->bind_param("s", $mobile);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $Unique_id=$user["Unique_id"];
        $IMEINO=$user["Imei_no"];
            // insert query

         if(count($user)!=0){
            if(strlen($IMEINO)==0){
            $stmt = $this->conn->prepare("UPDATE driver_details SET Imei_no=? ,Driver_lat=?,Driver_long=? WHERE Unique_id=?");

            $stmt->bind_param("ssss",$imei,$driver_lat,$driver_long,$Unique_id);

            $result = $stmt->execute();

            $stmt->close();
        }
     }else{
                echo "Please check session no";
                return false;
            }
            // Check for successful insertion
            if ($result) {

                return true;
            } else {
                // Failed to create user
                return false;
            }
     
    }

        public function storeComment($mobile, $text){

        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i");
        $date=date("Y-m-d");
        $stmt=$this->conn->prepare("SELECT Mobile FROM driver_comment WHERE mobile=?");
        $stmt->bind_param("s", $mobile);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $mobile_repeat=$user["mobile"];
        $result="";
      

        if(count($user)!=0){
            $stmt=$this->conn->prepare("UPDATE driver_comment SET Comment=?, Created_date=?,Created_time=? WHERE Mobile=?");
            $stmt->bind_param("ssss", $text, $day,$hour,$mobile_repeat);
            $result=$stmt->execute();
            $stmt->close();
            
        }else{

          $stmt = $this->conn->prepare("INSERT INTO driver_comment(Mobile,Comment,Created_date,Created_time) VALUES(?, ?, ?,?)");
        $stmt->bind_param("ssss", $mobile, $text,$date,$hour);
        $result = $stmt->execute();
        $stmt->close();
    }
 
        // check for successful store
        if ($result) {
    
         
            return true;
        } else {
            return false;
        }
    }

          public function storeDriverLatLng($mobile,$driver_lat,$driver_long){

        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i");
        $date=date("Y-m-d");
        $stmt=$this->conn->prepare("SELECT Unique_id FROM driver_details WHERE Driver_Phone=?");
        $stmt->bind_param("s", $mobile);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $Unique_id=$user["Unique_id"];
        $result="";
      

        if(count($user)!=0){
            $stmt=$this->conn->prepare("UPDATE driver_details SET Driver_lat=?, Driver_long=? WHERE Unique_id=?");
            $stmt->bind_param("sss", $driver_lat, $driver_long,$Unique_id);
            $result=$stmt->execute();
            $stmt->close();
            
        }
 
        // check for successful store
        if ($result) {
    
         
            return true;
        } else {
            return false;
        }
    }

       public function createUser($id,$name,$email,$mobile,$file_path,$lat,$long,$refer){

        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i");
        $date=date("Y-m-d");
        $stmt=$this->conn->prepare("SELECT Mobile FROM user_details WHERE mobile=?");
        $stmt->bind_param("s", $mobile);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        $result="";
      

        if(count($user)==0){
            $stmt=$this->conn->prepare("INSERT INTO user_details(Name,Email,Idfacebook,Image,Mobile,User_lat,User_long,Created_date,Created_time,Refer) VALUES(?,?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param("ssssssssss",$name,$email,$id,$file_path,$mobile,$lat,$long,$date,$hour,$refer);
            $result=$stmt->execute();
            $stmt->close();
            
        }else{
            $stmt=$this->conn->prepare("UPDATE user_details SET Name=?,Email=?,Idfacebook=?,Image=?,User_lat=?,User_long=?,Created_date=?, Created_time=? WHERE Mobile=?");
            $stmt->bind_param("sssssssss",$name,$email,$id,$file_path,$lat,$long,$date,$hour,$mobile);
            $result=$stmt->execute();
            $stmt->close();
             
        }
 
        // check for successful store
        if ($result) {
    
         
            return true;
        } else {
            return false;
        }
    }



      public function storeUserLatLng($mobile, $driver_lat,$driver_long){

        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i");
        $date=date("Y-m-d");
        $stmt=$this->conn->prepare("SELECT Mobile FROM user_details WHERE mobile=?");
        $stmt->bind_param("s", $mobile);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $Unique_id=$user["Unique_id"];
        $result="";
      

        if(count($user)!=0){
            $stmt=$this->conn->prepare("UPDATE user_details SET User_lat=?, User_long=? WHERE Mobile=?");
            $stmt->bind_param("sss", $driver_lat, $driver_long,$mobile);
            $result=$stmt->execute();
            $stmt->close();
            
        }
 
        // check for successful store
        if ($result) {
    
         
            return true;
        } else {
            return false;
        }
    }


     public function ride_delete_all($mobile,$unique_id,$reason){

        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i");
        $date=date("Y-m-d");

        $ID=$mobile;
        $result=false;
      

        
        $stmt=$this->conn->prepare("SELECT ID,OTP,Unique_Ride_Code FROM book_ride WHERE  User_ID=? AND Unique_Ride_Code =? AND Is_Running=0 ");
        $stmt->bind_param("is",$ID,$unique_id);
        $stmt->execute();
        $user2 = $stmt->get_result()->fetch_assoc();
        $ID3=$user2['ID'];
        $OTP=$user2['OTP'];
        $stmt->close();
        if(count($user2)!=0){
            echo $unique_id;
            $stmt=$this->conn->prepare("DELETE FROM book_ride  WHERE  User_ID=? AND `Unique_Ride_Code`=? ");
        $stmt->bind_param("is",$ID,$unique_id);
        $stmt->execute();
        if($stmt->errno==0){
                $result=true;
            }
        $stmt->close();

               $stmt=$this->conn->prepare("UPDATE  delievered SET Delivered=6,Reason=?  WHERE OrderID=? ");
        $stmt->bind_param("si",$reason,$OTP);
        $stmt->execute();
        if($stmt->errno==0){
                $result=true;
            }
        $stmt->close();
         $stmt=$this->conn->prepare("DELETE FROM update_user_order  WHERE OrderID=? ");
        $stmt->bind_param("i",$OTP);
        $stmt->execute();
        if($stmt->errno==0){
                $result=true;
            }
        $stmt->close();
    
                 $stmt=$this->conn->prepare("DELETE FROM store_order  WHERE OrderID=? ");
        $stmt->bind_param("i",$OTP);
        $stmt->execute();
        if($stmt->errno==0){
                $result=true;
            }
        $stmt->close();
       
           } 
     
       
            return $result;
        
    }
     public function ride_delete($mobile,$unique_id,$cID){

        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i");
        $date=date("Y-m-d");
        $stmt=$this->conn->prepare("SELECT ID FROM user_details WHERE  Phone_No=? ");
        $stmt->bind_param("s",$mobile);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $ID=$user['ID'];
        $stmt->close();
        $result=false;
      

        if(count($user)!=0){
        $stmt=$this->conn->prepare("SELECT Unique_Ride_Code FROM book_ride WHERE  User_ID=? AND Unique_Ride_Code =? AND Is_Running=0 ");
        $stmt->bind_param("is",$ID,$unique_id);
        $stmt->execute();
        $user2 = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        if(count($user2)!=0){
            echo $unique_id;
            $stmt=$this->conn->prepare("UPDATE book_ride SET  Is_Running=0,Ride_Cancelled_by=1 WHERE  User_ID=? AND `Unique_Ride_Code`=? ");
        $stmt->bind_param("is",$ID,$unique_id);
        $stmt->execute();
        if($stmt->errno==0){
                $result=true;
                if($cID!=0){
                    $ii=0;
                    $stmt=$this->conn->prepare("UPDATE `user_details` SET Charge=?  WHERE  Phone_No=? ");
        $stmt->bind_param("is",$ii,$mobile);
        $stmt->execute(); 
           $stmt->close();
                }
            }
        $stmt->close();
           } 
        }
 
        // check for successful store
       
            return $result;
        
    }

public function ride_delete_driver($mobile,$unique_id){

        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i");
        $date=date("Y-m-d");
        $stmt=$this->conn->prepare("SELECT ID FROM driver_details WHERE  Phone_No=? ");
        $stmt->bind_param("s",$mobile);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $ID=$user['ID'];
        $stmt->close();
        $result=false;
      

        if(count($user)!=0){
        $stmt=$this->conn->prepare("SELECT Unique_Ride_Code FROM book_ride WHERE  Driver_ID=? AND Unique_Ride_Code =? ");
        $stmt->bind_param("is",$ID,$unique_id);
        $stmt->execute();
        $user2 = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        if(count($user2)!=0){
            echo $unique_id;
            $stmt=$this->conn->prepare("UPDATE book_ride SET Ride_Cancelled_by=2 WHERE  Driver_ID=? AND `Unique_Ride_Code`=? ");
        $stmt->bind_param("is",$ID,$unique_id);
        $stmt->execute();
        if($stmt->errno==0){
                $result=true;
            }
        $stmt->close();
           } 
        }
 
        // check for successful store
       
            return $result;
        
    }


       public function book_ride($mobile,$address,$houseno,$from_lat,$from_long,$landmark,$zip,$checked,$IP,$distance,$total,$area){
       $unique_id = uniqid(rand(), true);
       $otp=rand(1000,9999);
       $result=false;
       date_default_timezone_set(TIMEZONE);
       $hour=date("H:i");
       $date=date("Y-m-d");
       $OrderID=0;
       $UserID=0;


      
        $UserID=$mobile;
      
       
      

        $stmt=$this->conn->prepare("SELECT ID FROM book_ride WHERE   `Unique_Ride_Code`=?  ");
        $stmt->bind_param("s",$unique_id);
        $stmt->execute();
        $user2 = $stmt->get_result()->fetch_assoc();
        $ID=$user2['ID'];
        $stmt->close();




        if($checked==1){
              $stmt=$this->conn->prepare("UPDATE `user_details` SET `HomeAddress`=?,`HomeHouseNo`=?,`HomeLandMark`=?,`HomeZip`=? WHERE `ID`=?");
        $stmt->bind_param("ssssi",$address,$houseno,$landmark,$zip,$mobile);
        $stmt->execute();
        if($stmt->errno==0){
                $result=true;
            }
        $stmt->close();
           }else if($checked==2){
              $stmt=$this->conn->prepare("UPDATE `user_details` SET `WorkAddress`=?,`WorkHouseNo`=?,`WorkLandMark`=?,`WorkZip`=? WHERE `ID`=?");
        $stmt->bind_param("ssssi",$address,$houseno,$landmark,$zip,$mobile);
        $stmt->execute();
        if($stmt->errno==0){
                $result=true;
            }
        $stmt->close();
           }
        


    if($ID==0){ 

            printf("Tita: %d.\n", $total);

        $stmt = $this->conn->prepare("INSERT INTO book_ride(`OTP`,`Unique_Ride_Code`, `User_ID`,`From_Address`,`From_area`,`From_Latitude`, `From_Longitude`, `Booking_Date`,`Booking_Time`,Distance_Travel,Cost,`Date`, `Time`, `User`, `IP`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("isissddssddssss",$otp,$unique_id,$UserID,$address,$area,$from_lat,$from_long,$date,$hour,$distance,$total,$date,$hour,$mobile,$IP);
                $stmt->execute();
                  printf("1st: %d.\n", $stmt->errno);
                  
        if($stmt->errno==0){
               $last_id=$stmt->insert_id;
                $stmt=$this->conn->prepare("SELECT OrderID FROM delievered ORDER BY ID DESC LIMIT 1");
        $stmt->execute();
        $user2 = $stmt->get_result()->fetch_assoc();
        $OrderID=$user2['OrderID'];
        $stmt->close();
          printf("lastid: %d.\n", $OrderID);
                      if($OrderID!=0){
                          $stmt=$this->conn->prepare("UPDATE book_ride SET OTP=? WHERE ID=?");
        $stmt->bind_param("ii",$OrderID,$last_id);
        $stmt->execute();
        if($stmt->errno==0){
                $result=true;
            }
        $stmt->close();
                      }
            }
   
        $stmt->close();
    
    }


        if ($result) {

            $stmt = $this->conn->prepare("SELECT * FROM book_ride WHERE  User_ID=? AND `Unique_Ride_Code`=?");
            $stmt->bind_param("is", $UserID,$unique_id);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
 
            return $user;
        } else {
            return false;
        
    }

    }


}
?>