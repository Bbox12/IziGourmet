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

 public function SiteActivateShop($id,$User,$IP){

    
        
        date_default_timezone_set('Africa/Johannesburg');
        $hour=date("H:i:s");
        $date=date("Y-m-d");
        $result=false;
        $ID=0;

            $stmt = $this->conn->prepare("SELECT ID FROM `tez_Canteen` WHERE ID=?");
            $stmt->bind_param("i",$id);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $ID=$user['ID'];
            $stmt->close();
   
               printf("ID: %d.\n", $ID);
           
    if( $ID!=0){
          $stmt = $this->conn->prepare("UPDATE tez_Canteen  SET  isActive=1 WHERE ID=?");
          $stmt->bind_param("i",$ID);
          $stmt->execute();
          $error= $stmt->errno;
          $last_id=$stmt->insert_id;
          printf("bbb: %d.\n", $error);
          $stmt->close();

            if($error==0){
     $result=true;
               
        }
    }

         
                return $result;
        
           
    }

     public function SiteDeleteShop($id,$User,$IP){

    
        
        date_default_timezone_set('Africa/Johannesburg');
        $hour=date("H:i:s");
        $date=date("Y-m-d");
        $result=false;
        $ID=0;

            $stmt = $this->conn->prepare("SELECT ID FROM `tez_Canteen` WHERE ID=?");
            $stmt->bind_param("i",$id);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $ID=$user['ID'];
            $stmt->close();
   
               printf("ID: %d.\n", $ID);
           
    if( $ID!=0){
          $stmt = $this->conn->prepare("UPDATE tez_Canteen  SET  isActive=0,`Date`=?,`Time`=? WHERE ID=?");
          $stmt->bind_param("ssi",$date,$hour,$ID);
          $stmt->execute();
          $error= $stmt->errno;
          $last_id=$stmt->insert_id;
          printf("bbb: %d.\n", $error);
          $stmt->close();

            if($error==0){
     $result=true;
               
        }
        
    }

         
                return $result;
        
           
    }

    public function addLocation($IDp,$Name,$address1,$phone,$Latitude,$Longitude,$distance,$User,$IP){
              date_default_timezone_set(TIMEZONE);
        $hour=date("H:i");
        $date=date("Y-m-d");
        $result=false;
    
    
        $country="South Africa";
        $ID=0;

        if($IDp==0){


        $stmt = $this->conn->prepare("SELECT  ID from tez_Canteen WHERE Phone_No = ? ");
        $stmt->bind_param("s",$phone);
        $stmt->execute();
        $user1 = $stmt->get_result()->fetch_assoc();
        $ID=$user1['ID'];
        $stmt->close();

        if($ID!=0){

           $stmt=$this->conn->prepare("UPDATE tez_Canteen SET Name=?,Address=?,`Latitude`=?,`Longitude`=?,Distance=?,`Date`=?,`Time`=? WHERE ID = ? ");
            $stmt->bind_param("ssdddssi",$Name,$address1,$Latitude,$Longitude,$distance,$date,$hour,$ID);
            $result=$stmt->execute();
             printf("update: %d.\n", $stmt->errno);
             if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
        }else{

          $stmt = $this->conn->prepare("INSERT INTO `tez_Canteen`(`Name`, Phone_No,`Address`, `Latitude`, `Longitude`, `Distance`, `Date`, `Time`) VALUES (?,?,?,?,?,?,?,?)");
            $stmt->bind_param("sssdddss",$Name,$phone,$address1,$Latitude,$Longitude,$distance,$date,$hour);
            $result = $stmt->execute();
            printf("Error: %d.\n", $stmt->errno);
            if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
        }
      }else{
          $stmt=$this->conn->prepare("UPDATE tez_Canteen SET Name=?,Phone_No=?,Address=?,`Latitude`=?,`Longitude`=?,Distance=?,`Date`=?,`Time`=? WHERE ID = ? ");
            $stmt->bind_param("sssdddssi",$Name,$phone,$address1,$Latitude,$Longitude,$distance,$date,$hour,$IDp);
            $result=$stmt->execute();
             printf("update: %d.\n", $stmt->errno);
             if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
      }
      

     return $result;
    }




     public function DeleterProductFromOrder($id,$pd) {
              date_default_timezone_set(TIMEZONE);
        $hour=date("H:i");
        $date=date("Y-m-d");
        $result=false;
        $IDL=0;
        $cID=0;
        $bID=0;

        $stmt = $this->conn->prepare("SELECT  ID,UserID from store_order WHERE ID = ?  ");
        $stmt->bind_param("i",$pd);
        $stmt->execute();
        $user1 = $stmt->get_result()->fetch_assoc();
        $IDL=$user1['ID'];
        $UserID=$user1['UserID'];
        $stmt->close();
      
         printf("order: %d.\n", $IDL);
        if($IDL!=0){
     
            $stmt=$this->conn->prepare("DELETE FROM store_order  WHERE ID = ? ");
            $stmt->bind_param("i",$IDL);
            $result=$stmt->execute();
             printf("update: %d.\n", $stmt->errno);
             if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
          
        $stmt = $this->conn->prepare("SELECT  ID from store_order WHERE OrderID = ?  AND UserID=? ");
        $stmt->bind_param("ii",$id,$UserID);
        $stmt->execute();
        $user1 = $stmt->get_result()->fetch_assoc();
        $cID=$user1['ID'];
        $stmt->close();

        if($cID==0){
        $stmt = $this->conn->prepare("SELECT ID,IDDelivery from book_ride WHERE User_ID = ? AND OTP =? AND Is_Paid =0 AND Ride_Cancelled_by=0 ");
        $stmt->bind_param("ii",$UserID,$id);
        $stmt->execute();
        $user1 = $stmt->get_result()->fetch_assoc();
        $bID=$user1['ID'];
        $stmt->close();
            if($bID!=0){
             $stmt=$this->conn->prepare("UPDATE book_ride SET Ride_Cancelled_by=2 WHERE ID=? ");
            
            $stmt->bind_param("i",$bID);
            $result=$stmt->execute();
             printf("update: %d.\n", $stmt->errno);
             if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
            $reason="Item on the cart not avaialble";
            $stmt=$this->conn->prepare("UPDATE  delievered SET Delivered=6, Reason=? WHERE OrderID=? ORDER BY ID DESC LIMIT 1 ");
          
            $stmt->bind_param("si",$reason,$id);
            $result=$stmt->execute();
             printf("update: %d.\n", $stmt->errno);
             if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
                    $stmt=$this->conn->prepare("DELETE FROM update_user_order WHERE UserID=? AND OrderID=? ");
          
            $stmt->bind_param("ii",$UserID,$id);
            $result=$stmt->execute();
             printf("update: %d.\n", $stmt->errno);
             if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
          }
        }
   
        }


        if($result){
        $stmt = $this->conn->prepare("SELECT User_ID, Unique_Ride_Code  from book_ride WHERE  User_ID=? AND OTP =? AND Is_Paid =0   ");
        $stmt->bind_param("ii",$UserID,$id);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if(count($user)!=0){
                 return $user;
               }else{
                return true;
               }
 
        }else{
             return FALSE;
        }
          
    
  
    }

     public function updateOrder($Order,$ID,$CDNo,$User,$IP) {
              date_default_timezone_set(TIMEZONE);
        $hour=date("H:i");
        $date=date("Y-m-d");
        $result=false;
        $IDL=0;
          $cID=0;
        $bID=0;

        $stmt = $this->conn->prepare("SELECT  ID,UserID from store_order WHERE ID = ? ");
        $stmt->bind_param("i",$ID);
        $stmt->execute();
        $user1 = $stmt->get_result()->fetch_assoc();
        $IDL=$user1['ID'];
        $UserID=$user1['UserID'];
        $stmt->close();
      
        if($IDL!=0){
           if($CDNo>0){
            $stmt=$this->conn->prepare("UPDATE store_order SET NoofItems=? WHERE ID = ? ");
            $stmt->bind_param("ii",$CDNo,$ID);
            $result=$stmt->execute();
             printf("update: %d.\n", $stmt->errno);
             if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
          }else{
            $stmt=$this->conn->prepare("DELETE FROM store_order  WHERE ID = ? ");
            $stmt->bind_param("i",$ID);
            $result=$stmt->execute();
             printf("update: %d.\n", $stmt->errno);
             if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();

       $stmt = $this->conn->prepare("SELECT  ID from store_order WHERE OrderID = ?  AND UserID=? ");
        $stmt->bind_param("ii",$id,$UserID);
        $stmt->execute();
        $user1 = $stmt->get_result()->fetch_assoc();
        $cID=$user1['ID'];
        $stmt->close();

        if($cID==0){
        $stmt = $this->conn->prepare("SELECT ID,IDDelivery  from book_ride WHERE User_ID = ? AND OTP =? AND Is_Paid =0 AND Ride_Cancelled_by=0 ");
        $stmt->bind_param("ii",$UserID,$id);
        $stmt->execute();
        $user1 = $stmt->get_result()->fetch_assoc();
        $bID=$user1['ID'];
            $IDDelivery=$user1['IDDelivery'];
        $stmt->close();
            if($bID!=0){
             $stmt=$this->conn->prepare("UPDATE book_ride SET Ride_Cancelled_by=2 WHERE ID=? ");
            
            $stmt->bind_param("i",$bID);
            $result=$stmt->execute();
             printf("update: %d.\n", $stmt->errno);
             if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
            $reason="Item on the cart not avaialble";
           $stmt=$this->conn->prepare("UPDATE  delievered SET Delivered=6, Reason=? WHERE OrderID=? ORDER BY ID DESC LIMIT 1 ");
          
            $stmt->bind_param("si",$reason,$id);
            $result=$stmt->execute();
             printf("update: %d.\n", $stmt->errno);
             if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
                    $stmt=$this->conn->prepare("DELETE FROM update_user_order WHERE UserID=? AND OrderID=? ");
          
            $stmt->bind_param("ii",$UserID,$id);
            $result=$stmt->execute();
             printf("update: %d.\n", $stmt->errno);
             if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
          }
        }
          }
   
        }


        if($result){
        $stmt = $this->conn->prepare("SELECT User_ID, Unique_Ride_Code  from book_ride WHERE User_ID = ? AND OTP =? AND Is_Paid =0  ");
        $stmt->bind_param("ii",$UserID,$Order);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
             if(count($user)!=0){
                 return $user;
               }else{
                return true;
               }
        }else{
             return FALSE;
        }
          
    
  
    }




 public function deleteDriver($id){

    
        
        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i:s");
        $date=date("Y-m-d");
        $result=false;
        
    $stmt = $this->conn->prepare("DELETE FROM user_details WHERE ID=? AND role=2");
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $error= $stmt->errno;
    printf("bbb: %d.\n", $error);
    $stmt->close();

            if($error==0){
     $result=true;
               
      
        }
        
             return $result;    
    }



 public function deletePhoto($id){

    
        
        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i:s");
        $date=date("Y-m-d");
        $result=false;
        
    $stmt = $this->conn->prepare("DELETE FROM canteen_AD WHERE ID=?");
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $error= $stmt->errno;
    printf("bbb: %d.\n", $error);
    $stmt->close();

            if($error==0){
     $result=true;
               
      
        }
        
             return $result;    
    }


 public function showPhoto($id){

    
        
        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i:s");
        $date=date("Y-m-d");
        $result=false;
        
    $stmt = $this->conn->prepare("UPDATE canteen_AD SET isActive=1  WHERE ID=?");
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $error= $stmt->errno;
    printf("bbb: %d.\n", $error);
    $stmt->close();

            if($error==0){
     $result=true;
               
      
        }
        
             return $result;    
    }



 public function NotshowPhoto($id){

    
        
        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i:s");
        $date=date("Y-m-d");
        $result=false;
        
   $stmt = $this->conn->prepare("UPDATE canteen_AD SET isActive=0  WHERE ID=?");
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $error= $stmt->errno;
    printf("bbb: %d.\n", $error);
    $stmt->close();

            if($error==0){
     $result=true;
               
      
        }
        
             return $result;    
    }




    public function postMessage($phone,$message,$mobile,$email){
              date_default_timezone_set(TIMEZONE);
        $hour=date("H:i");
        $date=date("Y-m-d");
        $result=false;
    
  
  

           $stmt=$this->conn->prepare("INSERT INTO `contactus`(`IDUser`, `Email`, `Messages`, `Date`, `Time`)  VALUES(?,?,?,?,?)");
            $stmt->bind_param("issss",$phone,$email,$message,$date,$hour);
            $result=$stmt->execute();
     
             if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
       

     return $result;
    }

    public function postStockies($about,$email,$Latitide,$Longitude,$Name,$phone,$address,$state,$City,$Pin,$User,$IP) {
              date_default_timezone_set(TIMEZONE);
        $hour=date("H:i");
        $date=date("Y-m-d");
        $result=false;
    
    
        $country="South Africa";
        $ID=0;

        $stmt = $this->conn->prepare("SELECT  ID from tez_Canteen WHERE Phone_No = ? ");
        $stmt->bind_param("s",$phone);
        $stmt->execute();
        $user1 = $stmt->get_result()->fetch_assoc();
        $ID=$user1['ID'];
        $stmt->close();
                  printf("ID: %d.\n", $ID);
                   printf("ID: %s.\n", $phone);
        if($ID!=0){

           $stmt=$this->conn->prepare("UPDATE user_details SET Name=?,Email=?,Photo=?,Phone_No=?,Address=?,`State`=?,`City`=?,Pin=?,`Date`=?,`Time`=?,`User`=?,IP=? WHERE ID = ? ");
            $stmt->bind_param("ssssssssssssi",$Name,$Photo,$email,$phone,$address,$state,$City,$Pin,$date,$hour,$User,$IP,$ID);
            $result=$stmt->execute();
             printf("update: %d.\n", $stmt->errno);
             if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
        }else{

          $stmt = $this->conn->prepare("INSERT INTO `tez_Canteen`( `Name`, `Phone_No`, `Email`,`Aboutus`,`Address`, `State`, `City`, `Pin_No`, `Latitude`, `Longitude`, `Date`, `Time`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param("ssssssssssss",$Name,$phone,$email,$about,$address,$state,$City,$Pin,$Latitide,$Longitude,$date,$hour);
            $result = $stmt->execute();
            printf("Error: %d.\n", $stmt->errno);
            if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
        }
      

     return $result;
    }


    
    
         public function postDeriver($Photo,$Name,$phone,$address,$state,$City,$Pin,$User,$IP) {
                  date_default_timezone_set(TIMEZONE);
        $hour=date("H:i");
        $date=date("Y-m-d");
        $result=false;
    
    
        $country="South Africa";
        $ID=0;

        $stmt = $this->conn->prepare("SELECT  ID from user_details WHERE Phone_No = ? ");
        $stmt->bind_param("s",$phone);
        $stmt->execute();
        $user1 = $stmt->get_result()->fetch_assoc();
        $ID=$user1['ID'];
        $stmt->close();
                  printf("ID: %d.\n", $ID);
                   printf("ID: %s.\n", $phone);
        if($ID!=0){

           $stmt=$this->conn->prepare("UPDATE user_details SET Name=?,Photo=?,Phone_No=?,Address=?,`State`=?,`City`=?,Pin=?,`Date`=?,`Time`=?,`User`=?,IP=? WHERE ID = ? ");
            $stmt->bind_param("sssssssssssi",$Name,$Photo,$phone,$address,$state,$City,$Pin,$date,$hour,$User,$IP,$ID);
            $result=$stmt->execute();
             printf("update: %d.\n", $stmt->errno);
             if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
        }else{

          $stmt = $this->conn->prepare("INSERT INTO `user_details`( `Name`,`Photo`, `Phone_No`, `role`, `Address`, `Country`, `State`, `City`, `Pin`, `Date`, `Time`, `User`, `IP`) VALUES(?,?,?,2,?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param("ssssssssssss",$Name,$Photo,$phone,$address,$country,$state,$City,$Pin,$date,$hour,$User,$IP);
            $result = $stmt->execute();
            printf("Error: %d.\n", $stmt->errno);
            if($stmt->errno==0){
                $result=true;
            }
            $stmt->close();
        }
      

       if($result){
        $stmt = $this->conn->prepare("SELECT  ID from user_details WHERE Phone_No = ?  AND role=2");
        $stmt->bind_param("s",$phone);
        $stmt->execute();
        $user1 = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $user1;
       }else{
        return false;
       }
    }



 public function addSettings($Facebook,$Instagram,$Youtube,$WhatsApp,$discount,$monimumorders,$minimumweight,$minimumdistance,$maximumdistance,$freedeldistance,$price,$starttime,$endtime,$cancellation,$User,$IP){

    
        
        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i:s");
        $date=date("Y-m-d");
        $result=false;
        
    $stmt = $this->conn->prepare("INSERT INTO `setting_defaults`(`Discounts`, `MinimumOrderPrice`, `MinimumOrderWeight`, `MinimumDistance`, `MaximumDistance`, `StartTime`, `EndTime`, `FreeDistance`, `PricePerKM`, `CancellationCharge`,`FacebookPage`, `InstagramPage`, `YoutubePlaylis`, `WhatsApp`, `Date`, `Time`, `User`,`IP`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("diiiissiidssssssss",$discount,$monimumorders,$minimumweight,$minimumdistance,$maximumdistance,$starttime,$endtime,$freedeldistance,$price,$cancellation,$Facebook,$Instagram,$Youtube,$WhatsApp,$date,$hour,$User,$IP);
    $stmt->execute();
    $error= $stmt->errno;
    printf("bbb: %d.\n", $error);
    $stmt->close();

            if($error==0){
     $result=true;
               
      
        }
        
             return $result;    
    }


      public function addimages($special,$Description,$Photo,$User,$IP){

    
        date_default_timezone_set('Africa/Johannesburg');
        $hour=date("H:i:s");
        $date=date("Y-m-d");
        $result=false;
        $ID=0;
    

    $stmt = $this->conn->prepare("INSERT INTO `canteen_AD`( `Title`,`Description`, `Photo`, `User`, `Date`, `Time`) VALUES (?,?,?,?,?,?)");
    $stmt->bind_param("ssssss",$special,$Description,$Photo,$User,$date,$hour);    
    $stmt->execute();
    $error= $stmt->errno;
    printf("bbb: %d.\n", $error);
    $stmt->close();

            if($error==0){
                      $result=true;
                         } 
                return $result;
               
                  }




         public function OrderReject($id,$reason,$User,$IP){

        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i");
        $date=date("Y-m-d");
        $stmt=$this->conn->prepare("SELECT ID FROM delievered WHERE  OrderID=?  ");
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $ID=$user['ID'];
        $stmt->close();
        $result=false;
      
           $stmt = $this->conn->prepare("SELECT Unique_Ride_Code FROM `book_ride` WHERE OTP=?");
            $stmt->bind_param("i",$id);
            $stmt->execute();

            $user = $stmt->get_result()->fetch_assoc();
            $unique_id=$user['Unique_Ride_Code'];
          //  $_SESSION["unique"]=$unique_id;
            $stmt->close();

        if($ID!=0){
            echo $id;
            $stmt=$this->conn->prepare("UPDATE book_ride SET  Ride_Cancelled_by=1 WHERE  Unique_Ride_Code=? ");
        $stmt->bind_param("s",$unique_id);
        $stmt->execute();
        $stmt->close();

        $stmt=$this->conn->prepare("UPDATE delievered  SET Delivered=7, Reason=? WHERE OrderID=? ");
        $stmt->bind_param("si",$reason,$id);
        $stmt->execute();
        if($stmt->errno==0){
                $result=true;
            }
        $stmt->close();
     
            
           } 
        
 
                  if($result){
  $stmt = $this->conn->prepare("SELECT Unique_Ride_Code FROM `book_ride` WHERE Unique_Ride_Code=?");
            $stmt->bind_param("s",$unique_id);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            return $user;
               
        }
    else{
         return FALSE;    
    }
        
    }



     public function onThewayOrder($orderID,$message,$User,$IP){

    
        
        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i:s");
        $date=date("Y-m-d");
        $result=false;
        $ID=0;
         printf("ID: %d.\n", $orderID);
  
            $stmt = $this->conn->prepare("SELECT ID FROM `delievered` WHERE OrderID=? ORDER BY ID DESC LIMIT 1");
            $stmt->bind_param("i",$orderID);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $ID=$user['ID'];
            $stmt->close();
   
               printf("ID: %d.\n", $ID);
           
    if( $ID!=0){
          $stmt = $this->conn->prepare("UPDATE delievered  SET  Delivered=4 ,onthewaymessage=?, `onthewaydate`=?, `onthewaytime`=? WHERE ID=?");
          $stmt->bind_param("sssi",$message,$date,$hour,$ID);
          $stmt->execute();
          $error= $stmt->errno;
          $last_id=$stmt->insert_id;
          printf("bbb: %d.\n", $error);
          $stmt->close();

        
            if($error==0){
  $stmt = $this->conn->prepare("SELECT Unique_Ride_Code FROM `book_ride` WHERE OTP=?");
            $stmt->bind_param("i",$orderID);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            return $user;
               
        }else{
         return FALSE;    
    }
    }else{
         return FALSE;    
    }
        
           
    }


 public function verifyPayment($id){

    
        
        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i:s");
        $date=date("Y-m-d");
        $result=false;
    
            $stmt = $this->conn->prepare("SELECT ID FROM `book_ride` WHERE ID=? AND Is_Paid=0");
            $stmt->bind_param("i",$id);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $ID=$user['ID'];
            $stmt->close();
   
               printf("ID: %d.\n", $ID);
           
    if( $ID!=0){
          $stmt = $this->conn->prepare("UPDATE book_ride SET  PaymentVerified=1  WHERE ID=?");
          $stmt->bind_param("i",$ID);
          $stmt->execute();
          $error= $stmt->errno;
          $last_id=$stmt->insert_id;
          printf("bbb: %d.\n", $error);
          $stmt->close();

          

            if($error==0){
                   return true;    
     
               
        }
    }else{
         return FALSE;    
    }
        
           
    }

 public function deliveredOrder($idl,$User,$IP){

    
        
        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i:s");
        $date=date("Y-m-d");
        $result=false;
    
            $stmt = $this->conn->prepare("SELECT ID FROM `delievered` WHERE OrderID=? AND Delivered!=5 ");
            $stmt->bind_param("i",$idl);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $ID=$user['ID'];
            $stmt->close();
   
               printf("ID: %d.\n", $ID);
           
    if( $ID!=0){
          $stmt = $this->conn->prepare("UPDATE delievered  SET  Delivered=5 WHERE ID=?");
          $stmt->bind_param("i",$ID);
          $stmt->execute();
          $error= $stmt->errno;
          $last_id=$stmt->insert_id;
          printf("bbb: %d.\n", $error);
          $stmt->close();

          $stmt = $this->conn->prepare("UPDATE book_ride SET  End_Date=?, End_Time=?, Is_Paid=1  WHERE OTP=?");
          $stmt->bind_param("ssi",$date,$hour,$idl);
          $stmt->execute();
          $error= $stmt->errno;
          $last_id=$stmt->insert_id;
          printf("bbb: %d.\n", $error);
          $stmt->close();

            if($error==0){
  $stmt = $this->conn->prepare("SELECT Unique_Ride_Code FROM `book_ride` WHERE OTP=?");
            $stmt->bind_param("i",$idl);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            return $user;
               
        }
    }else{
         return FALSE;    
    }
        
           
    }



     public function NewacceptedOrder($id,$message,$role){

    
        
        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i:s");
        $date=date("Y-m-d");
        $result=false;
        $dID=$cID=0;


        

            $stmt = $this->conn->prepare("SELECT ID FROM `delievered` WHERE OrderID=? ORDER BY ID DESC LIMIT 1");
            $stmt->bind_param("i",$id);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $dID=$user['ID'];
            $stmt->close();
   
           
    if( $dID!=0){

          if($role==1){
                 $stmt = $this->conn->prepare("UPDATE delievered  SET  Delivered=1, `Acceptmessage`=?, `Acceptdate`=?, `Accepttime`=? WHERE ID=?");
                $stmt->bind_param("sssi",$message,$date,$hour,$dID);
          $stmt->execute();
          $error= $stmt->errno;
          printf("bbb: %d.\n", $error);
          $stmt->close();

            if($error==0){
          $stmt = $this->conn->prepare("UPDATE book_ride  SET  IDDelivery=? WHERE OTP=? ORDER BY ID DESC LIMIT 1");
          $stmt->bind_param("ii",$dID,$id);
          $stmt->execute();
          $error= $stmt->errno;
          printf("bbb: %d.\n", $error);
          $stmt->close();
        if($error==0){
            $stmt = $this->conn->prepare("SELECT Unique_Ride_Code FROM `book_ride` WHERE OTP=? ORDER BY ID DESC LIMIT 1");
            $stmt->bind_param("i",$id);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $user;
             }else{
                return FALSE;   
        }
               
        }else{
                return FALSE;   
        }
      }else{
            $stmt = $this->conn->prepare("UPDATE delievered  SET  Delivered=2, `Confirmmessage`=?, `Confirmdate`=?, `Confirmtime`=? WHERE ID=?");
                $stmt->bind_param("sssi",$message,$date,$hour,$dID);
          $stmt->execute();
          $error= $stmt->errno;
          printf("bbb: %d.\n", $error);
          $stmt->close();

        if($error==0){
            $stmt = $this->conn->prepare("SELECT Unique_Ride_Code FROM `book_ride` WHERE OTP=? AND IDDelivery=?  ORDER BY ID DESC LIMIT 1");
            $stmt->bind_param("ii",$id,$dID);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $user;
             }else{
                return FALSE;   
        }
               
        
      }
       
     
    }else{
         return FALSE;    
    }
               
    }
      


 public function acceptedOrderApp($idL,$Name,$Vehicle,$ETR,$datas,$times,$User,$IP,$damt){

    
        
        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i:s");
        $date=date("Y-m-d");
        $result=false;
        $ID=$dID=0;


         $stmt = $this->conn->prepare("SELECT ID,Name FROM `user_details` WHERE Name=?");
            $stmt->bind_param("i",$Name);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $dID=$user['ID'];
            $stmt->close();

            $stmt = $this->conn->prepare("SELECT ID FROM `delievered` WHERE OrderID=?");
            $stmt->bind_param("i",$idL);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $ID=$user['ID'];
            $stmt->close();
   
              printf("ID: %s.\n", $idL);
           
    if( $ID!=0){
          if($damt==0){
               $stmt = $this->conn->prepare("UPDATE book_ride  SET  ETR=?,Driver_ID=?,Vehicle_ID=? WHERE OTP=?");
          $stmt->bind_param("sisi",$ETR,$dID,$Vehicle,$idL);
               $stmt->execute();
          $error= $stmt->errno;
          printf("bbb: %d.\n", $error);
          $stmt->close();
        }else{

            $stmt = $this->conn->prepare("SELECT Cost FROM `book_ride` WHERE OTP=?");
            $stmt->bind_param("i",$idL);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $Cost=$user['Cost'];
            $stmt->close();

          $stmt = $this->conn->prepare("UPDATE book_ride  SET  Cost=?,pCost=?,ETR=?,Driver_ID=?,Vehicle_ID=? WHERE OTP=?");
          $stmt->bind_param("ddsisi",$damt,$Cost,$ETR,$dID,$Vehicle,$idL);
          $stmt->execute();
          $error= $stmt->errno;
          printf("bbb: %d.\n", $error);
          $stmt->close();
        }
       
     
     


          $stmt = $this->conn->prepare("UPDATE delievered  SET DriverID=?,  Delivered=3 , `Driveradddate`=?, `Driveraddtime`=? WHERE ID=?");
                $stmt->bind_param("issi",$dID,$date,$hour,$ID);
          $stmt->execute();
          $error= $stmt->errno;
          printf("bbb: %d.\n", $error);
          $stmt->close();


$sql="SELECT `FoodID`, `NoofItems` FROM `store_order` WHERE `OrderID`=$idL";
    


if ($result = $this->conn->query($sql)) {
  while ($row = $result -> fetch_row()) {
    printf ("%s (%s)\n", $row[0], $row[1]);
     $stmt = $this->conn->prepare("SELECT Unit FROM `foods` WHERE ID=?");
            $stmt->bind_param("i",$row[0]);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $Unit=$user['Unit'];
            $stmt->close();
            $total=$Unit-$row[1];
    printf("total: %d.\n", $total);
 if($total>=0){
   $stmt = $this->conn->prepare("UPDATE foods  SET Unit=? WHERE ID=?");
                $stmt->bind_param("ii",$total,$row[0]);
          $stmt->execute();
          $error= $stmt->errno;
      
          $stmt->close();
 }
  }
  $result -> free_result();
}

            if($error==0){
            $stmt = $this->conn->prepare("SELECT Unique_Ride_Code FROM `book_ride` WHERE OTP=? AND Driver_ID=?");
            $stmt->bind_param("ii",$idL,$dID);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $user;
               
        }
    }else{
         return FALSE;    
    }
               
    }


 public function acceptedOrder($idL,$Name,$Vehicle,$ETR,$datas,$times,$User,$IP,$damt){

    
        
        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i:s");
        $date=date("Y-m-d");
        $result=false;
        $ID=$dID=0;


         $stmt = $this->conn->prepare("SELECT ID,Name FROM `user_details` WHERE ID=?");
            $stmt->bind_param("i",$Name);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $dID=$user['ID'];
            $stmt->close();

            $stmt = $this->conn->prepare("SELECT ID FROM `delievered` WHERE OrderID=?");
            $stmt->bind_param("i",$idL);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $ID=$user['ID'];
            $stmt->close();
   
              printf("ID: %s.\n", $idL);
           
    if( $ID!=0){
          if($damt==0){
               $stmt = $this->conn->prepare("UPDATE book_ride  SET  ETR=?,Driver_ID=?,Vehicle_ID=? WHERE OTP=?");
          $stmt->bind_param("sisi",$ETR,$dID,$Vehicle,$idL);
               $stmt->execute();
          $error= $stmt->errno;
          printf("bbb: %d.\n", $error);
          $stmt->close();
        }else{

            $stmt = $this->conn->prepare("SELECT Cost FROM `book_ride` WHERE OTP=?");
            $stmt->bind_param("i",$idL);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $Cost=$user['Cost'];
            $stmt->close();

          $stmt = $this->conn->prepare("UPDATE book_ride  SET  Cost=?,pCost=?,ETR=?,Driver_ID=?,Vehicle_ID=? WHERE OTP=?");
          $stmt->bind_param("ddsisi",$damt,$Cost,$ETR,$dID,$Vehicle,$idL);
          $stmt->execute();
          $error= $stmt->errno;
          printf("bbb: %d.\n", $error);
          $stmt->close();
        }
       
     
     


          $stmt = $this->conn->prepare("UPDATE delievered  SET DriverID=?,  Delivered=3 , `Driveradddate`=?, `Driveraddtime`=? WHERE ID=?");
                $stmt->bind_param("issi",$dID,$date,$hour,$ID);
          $stmt->execute();
          $error= $stmt->errno;
          printf("bbb: %d.\n", $error);
          $stmt->close();


$sql="SELECT `FoodID`, `NoofItems` FROM `store_order` WHERE `OrderID`=$idL";
    


if ($result = $this->conn->query($sql)) {
  while ($row = $result -> fetch_row()) {
    printf ("%s (%s)\n", $row[0], $row[1]);
     $stmt = $this->conn->prepare("SELECT Unit FROM `foods` WHERE ID=?");
            $stmt->bind_param("i",$row[0]);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $Unit=$user['Unit'];
            $stmt->close();
            $total=$Unit-$row[1];
    printf("total: %d.\n", $total);
 if($total>=0){
   $stmt = $this->conn->prepare("UPDATE foods  SET Unit=? WHERE ID=?");
                $stmt->bind_param("ii",$total,$row[0]);
          $stmt->execute();
          $error= $stmt->errno;
      
          $stmt->close();
 }
  }
  $result -> free_result();
}

            if($error==0){
            $stmt = $this->conn->prepare("SELECT Unique_Ride_Code FROM `book_ride` WHERE OTP=? AND Driver_ID=?");
            $stmt->bind_param("ii",$idL,$dID);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $user;
               
        }
    }else{
         return FALSE;    
    }
               
    }


     public function DeleteSecondaryService($id,$User,$IP){

    
        
        date_default_timezone_set('Africa/Johannesburg');
        $hour=date("H:i:s");
        $date=date("Y-m-d");
        $result=false;
        $ID=0;

            $stmt = $this->conn->prepare("SELECT ID FROM `submenu` WHERE ID=?");
            $stmt->bind_param("i",$id);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $ID=$user['ID'];
            $stmt->close();
   
               printf("ID: %d.\n", $ID);
           
    if( $ID!=0){
          $stmt = $this->conn->prepare("UPDATE submenu  SET  isActive=0 WHERE ID=?");
          $stmt->bind_param("i",$ID);
          $stmt->execute();
          $error= $stmt->errno;
          $last_id=$stmt->insert_id;
          printf("bbb: %d.\n", $error);
          $stmt->close();

            if($error==0){
     $result=true;
               
        }

         $stmt = $this->conn->prepare("UPDATE foods  SET  Available=0 WHERE IDSubsubmenu=?");
          $stmt->bind_param("i",$ID);
          $stmt->execute();
          $error= $stmt->errno;
          printf("bbb: %d.\n", $error);
          $stmt->close();

            if($error==0){
     $result=true;
               
        }
    }

         
                return $result;
        
           
    }



             public function addSubscription($Title,$Details,$Valid,$Price,$User,$IP,$id){

    
        
        date_default_timezone_set('Africa/Johannesburg');
        $hour=date("H:i:s");
        $date=date("Y-m-d");
        $result=false;
        $ID=0;

        
    
    if($id==0){
         $stmt = $this->conn->prepare("INSERT INTO `subscribe`( `Name`, `Details`, `Validity`, `Price`, `User`, `Date`, `Time`) VALUES (?,?,?,?,?,?,?)");
    $stmt->bind_param("sssdsss",$Title,$Details,$Valid,$Price,$User,$date,$hour);
       
    $stmt->execute();
    $error= $stmt->errno;
    printf("bbb: %d.\n", $error);
    $stmt->close();

            if($error==0){
     $result=true;
               
      
        } 
      }else {
$stmt = $this->conn->prepare("UPDATE `subscribe` SET `Name`=?, `Details`=?, `Validity`=?, `Price`=?, `User`=?, `Date`=?, `Time`=? WHERE ID=?");
    $stmt->bind_param("sssdsssi",$Title,$Details,$Valid,$Price,$User,$date,$hour,$id);
       
    $stmt->execute();
    $error= $stmt->errno;
    printf("bbb: %d.\n", $error);
    $stmt->close();

            if($error==0){
     $result=true;
               
      
        } 
      }


                //return $result;
        
           
    }


    public function sentCategory($msg,$Photo,$User,$IP){

    
        
        date_default_timezone_set('Africa/Johannesburg');
        $hour=date("H:i:s");
        $date=date("Y-m-d");
        $result=false;
        $ID=0;

        

   


    $stmt = $this->conn->prepare("INSERT INTO `salon_category`( `Category`, `Photo`) VALUES (?,?)");
    $stmt->bind_param("ss",$msg,$Photo);
    $stmt->execute();
    $error= $stmt->errno;
    printf("bbb: %d.\n", $error);
    $stmt->close();

            if($error==0){
     $result=true;
               
      
        }
                return $result;
        
           
    }




       public function upadateUser($name,$email,$mobile,$password,$gender,$bday,$image,$last){
    

        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i:s");
        $date=date("Y-m-d");
        $pwd=sha1($password);
        $uID=0;
        
            $stmt = $this->conn->prepare("SELECT ID FROM admin_login_data WHERE PhoneNo=?");
            $stmt->bind_param("s",$mobile);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $uID=$user['ID'];
            printf("Error: %d.\n", $stmt->errno);
            $stmt->close();

              if($uID!=0){ 
                 $stmt = $this->conn->prepare("UPDATE `admin_login_data` SET `FirstName`=?,`LastName`=?,`Email`=?,`Photo`=?,`Bday`=?,`Gender`=? WHERE PhoneNo=?");
            $stmt->bind_param("sssssss",$name,$last,$email,$image,$bday,$gender,$mobile);
            $stmt->execute();
              if( $stmt->errno==0){
                $result=true;
            }
            $stmt->close();
        
            if(strlen($password)!=0){
               $stmt = $this->conn->prepare("UPDATE  admin_login_data SET Password=? WHERE PhoneNo=? ");
            $stmt->bind_param("ss",$pwd,$mobile);
            $stmt->execute();  
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

  public function sentPushMessage($msg,$Photo,$User,$IP){

    
        
        date_default_timezone_set('Africa/Johannesburg');
        $hour=date("H:i:s");
        $date=date("Y-m-d");
        $result=false;
        $ID=0;

        

   


    $stmt = $this->conn->prepare("INSERT INTO `push_message`(`Message`,`Photo`, `Date`, `Time`, `User`, `IP`) VALUES(?,?,?,?,?,?)");
    $stmt->bind_param("ssssss",$msg,$Photo,$date,$hour,$User,$IP);
    $stmt->execute();
    $error= $stmt->errno;
    printf("bbb: %d.\n", $error);
    $stmt->close();

            if($error==0){
     $result=true;
               
      
        }
                return $result;
        
           
    }





        public function editWorkingSiteSeconday($IDL,$Photo,$Name,$special,$Description,$User,$IP){

    
        
        date_default_timezone_set('Africa/Johannesburg');
        $hour=date("H:i:s");
        $date=date("Y-m-d");
        $result=false;
        $ID=0;

        

      $stmt = $this->conn->prepare("SELECT ID FROM submenu WHERE ID=? ");
            $stmt->bind_param("i",$IDL);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $ID=$user['ID'];
            printf("Error: %d.\n", $stmt->errno);
            $stmt->close();

        
        if( $ID!=0){

    if(strlen($Photo)!=0){
    $stmt = $this->conn->prepare("UPDATE `submenu` SET `Category`=?,`Photo`=?,`Specification`=?,`Description`=?,`Date`=?,`Time`=?  WHERE ID=?");
    $stmt->bind_param("ssssssi",$Name,$Photo,$special,$Description,$date,$hour,$ID);
  }else{
        $stmt = $this->conn->prepare("UPDATE `submenu` SET `Category`=?,`Specification`=?,`Description`=?,`Date`=?,`Time`=?  WHERE ID=?");
    $stmt->bind_param("sssssi",$Name,$special,$Description,$date,$hour,$ID);
  }
    $stmt->execute();
    $error= $stmt->errno;
    printf("bbb: %d.\n", $error);
    $stmt->close();

            if($error==0){
     $result=true;
               
      }
        }
                return $result;
        
           
    }


        public function editWorkingSiteThird($IDL,$PName,$Name,$User,$IP){

    
        
        date_default_timezone_set('Africa/Johannesburg');
        $hour=date("H:i:s");
        $date=date("Y-m-d");
        $result=false;
        $ID=0;

        

      $stmt = $this->conn->prepare("SELECT ID FROM subsubmenu WHERE ID=? ");
            $stmt->bind_param("i",$IDL);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $ID=$user['ID'];
            printf("Error: %d.\n", $stmt->errno);
            $stmt->close();

        
        if( $ID!=0){


    $stmt = $this->conn->prepare("UPDATE  `subsubmenu` SET `IDSubmenu`=?, `Category`=? WHERE ID=?");
    $stmt->bind_param("isi",$PName,$Name,$ID);
    $stmt->execute();
    $error= $stmt->errno;
    printf("bbb: %d.\n", $error);
    $stmt->close();

            if($error==0){
     $result=true;
               
      }
        }
                return $result;
        
           
    }


        public function addWorkingSiteThird($role,$Name,$User,$IP){

    
        
        date_default_timezone_set('Africa/Johannesburg');
        $hour=date("H:i:s");
        $date=date("Y-m-d");
        $result=false;
        $ID=0;

        

   


    $stmt = $this->conn->prepare("INSERT INTO `subsubmenu`( `IDSubmenu`, `Category`, `Date`, `Time`) VALUES(?,?,?,?)");
    $stmt->bind_param("isss",$role,$Name,$date,$hour);
    $stmt->execute();
    $error= $stmt->errno;
    printf("bbb: %d.\n", $error);
    $stmt->close();

            if($error==0){
     $result=true;
               
      
        }
                return $result;
        
           
    }


        public function addNewWorkingSiteSeconday($Photo,$Name,$User,$IP){

    
        
        date_default_timezone_set('Africa/Johannesburg');
        $hour=date("H:i:s");
        $date=date("Y-m-d");
        $result=false;
        $ID=0;

        
  
   


    $stmt = $this->conn->prepare("INSERT INTO `subsubmenu`( `Name`, `Photo`,  `Date`, `Time`) VALUES(?,?,?,?)");
    $stmt->bind_param("ssss",$Name,$Photo,$date,$hour);
    $stmt->execute();
    $error= $stmt->errno;
    printf("bbb: %d.\n", $error);
    $stmt->close();

            if($error==0){
     $result=true;
               
      
        }
                return $result;
        
           
    }
       


        

    public function addWorkingSiteSeconday($target_,$Name,$special,$Description,$User,$IP){

    
        
        date_default_timezone_set('Africa/Johannesburg');
        $hour=date("H:i:s");
        $date=date("Y-m-d");
        $result=false;
        $ID=0;

        
  
   


    $stmt = $this->conn->prepare("INSERT INTO `submenu`( `Category`, `Photo`, `Specification`, `Description`,`Date`, `Time`) VALUES(?,?,?,?,?,?)");
    $stmt->bind_param("ssssss",$Name,$target_,$special,$Description,$date,$hour);
    $stmt->execute();
    $error= $stmt->errno;
    printf("bbb: %d.\n", $error);
    $stmt->close();

            if($error==0){
     $result=true;
               
      
        }
                return $result;
        
           
    }


      public function out_of_stock($IDL,$cb){

    
        
        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i:s");
        $date=date("Y-m-d");
        $result=false;
        $ID=0;


     
      $stmt = $this->conn->prepare("SELECT ID FROM foods WHERE ID=?");
            $stmt->bind_param("i",$IDL);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $ID=$user['ID'];
            printf("Error: %d.\n", $stmt->errno);
            $stmt->close();

    if($ID!=0){

    $stmt = $this->conn->prepare("UPDATE foods SET isOutOfStock=?  WHERE ID=?");
    $stmt->bind_param("ii",$cb,$ID);
    $stmt->execute();
    $error= $stmt->errno;
    printf("bbb: %d.\n", $error);
    $stmt->close();

            if($error==0){
     $result=true;
               
      
        }
      }
                return $result;
        
           
    }


    public function del_products_complete($IDL){

    
        
        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i:s");
        $date=date("Y-m-d");
        $result=false;
        $ID=0;


     
      $stmt = $this->conn->prepare("SELECT ID FROM foods WHERE ID=?");
            $stmt->bind_param("i",$IDL);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $ID=$user['ID'];
            printf("Error: %d.\n", $stmt->errno);
            $stmt->close();

    if($ID!=0){

    $stmt = $this->conn->prepare("DELETE FROM `foods` WHERE ID=?");
    $stmt->bind_param("i",$ID);
    $stmt->execute();
    $error= $stmt->errno;
    printf("bbb: %d.\n", $error);
    $stmt->close();

            if($error==0){
     $result=true;
               
      
        }
      }
                return $result;
        
           
    }



    public function activate_products_complete($IDL){

    
        
        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i:s");
        $date=date("Y-m-d");
        $result=false;
        $ID=0;


     
      $stmt = $this->conn->prepare("SELECT ID FROM foods WHERE ID=?");
            $stmt->bind_param("i",$IDL);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $ID=$user['ID'];
            printf("Error: %d.\n", $stmt->errno);
            $stmt->close();

    if($ID!=0){

    $stmt = $this->conn->prepare("UPDATE `foods`SET Available=1 WHERE ID=?");
    $stmt->bind_param("i",$ID);
    $stmt->execute();
    $error= $stmt->errno;
    printf("bbb: %d.\n", $error);
    $stmt->close();

            if($error==0){
     $result=true;
               
      
        }
      }
                return $result;
        
           
    }

    public function delWorkingSiteFinal($IDL){

    
        
        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i:s");
        $date=date("Y-m-d");
        $result=false;
        $ID=0;


     
      $stmt = $this->conn->prepare("SELECT ID FROM foods WHERE ID=?");
            $stmt->bind_param("i",$IDL);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $ID=$user['ID'];
            printf("Error: %d.\n", $stmt->errno);
            $stmt->close();

    if($ID!=0){

    $stmt = $this->conn->prepare("UPDATE `foods`SET Available=0 WHERE ID=?");
    $stmt->bind_param("i",$ID);
    $stmt->execute();
    $error= $stmt->errno;
    printf("bbb: %d.\n", $error);
    $stmt->close();

            if($error==0){
     $result=true;
               
      
        }
      }
                return $result;
        
           
    }


    public function addWorkingSiteFinal($vehicle1,$IDsubmenu,$IDSubsubmenu,$Brand,$Name,$Weight,$Unit,$Description,$MRP,$Price,$Discount,$Photo,$Photo1,$Photo2,$Photo3,$User,$IP){

    
        
        date_default_timezone_set('Africa/Johannesburg');
        $hour=date("H:i:s");
        $date=date("Y-m-d");
        $result=false;
        $ID=0;


        if(strlen($Photo)==0){
            $Photo="logo.png";
        }

        
     
      $stmt = $this->conn->prepare("SELECT ID FROM foods WHERE `IDMenu`=? AND `IDSubsubmenu`=? AND`Name`=? AND `IDSubmenu`=?");
            $stmt->bind_param("iisi",$IDSubsubmenu,$Brand,$Name,$IDsubmenu);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $ID=$user['ID'];
            printf("Error: %d.\n", $stmt->errno);
            $stmt->close();

    if($ID==0){

    $stmt = $this->conn->prepare("INSERT INTO `foods`(`IDMenu`,`IDSubmenu`, `IDSubsubmenu`, `Name`, `Weight`, `Unit`, `Description`, `MRP`, `JalpanPrice`, `Discount`, `Photo`, `Photo1`,`Photo2`, `Photo3`,`Recomended`, `User`, `Date`, `Time`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("iiisdisdddssssisss",$IDSubsubmenu,$IDsubmenu,$Brand,$Name,$Weight,$Unit,$Description,$MRP,$JalpanPrice,$Discount,$Photo,$Photo1,$Photo2,$Photo3,$deal,$User,$date,$hour);
    $stmt->execute();
    $error= $stmt->errno;
    printf("bbb: %d.\n", $error);
    $stmt->close();

            if($error==0){
     $result=true;
               
      
        }
      }
                return $result;
        
           
    }


        public function editWorkingSiteFinal($vehicle1,$IDsubmenu,$Photo,$ID,$IDShop,$IDSubsubmenu,$Name,$Weight,$Unit,$Description,$MRP,$JalpanPrice,$Discount,$User,$IP,$Photo1,$Photo2,$Photo3){

    
        
        date_default_timezone_set('Africa/Johannesburg');
        $hour=date("H:i:s");
        $date=date("Y-m-d");
        $result=false;
        $ID=0;


       
        
 $stmt = $this->conn->prepare("SELECT ID FROM `foods` WHERE ID=?");
            $stmt->bind_param("i",$IDL);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $ID=$user['ID'];
            $stmt->close();
   
               printf("Photo: %d.\n", strlen($Photo));
           
    if( $ID!=0){


      if(strlen($Photo)!=0){
         $stmt = $this->conn->prepare("UPDATE `foods` SET `IDMenu`=?,`IDSubmenu`=?, `IDSubsubmenu`=?, `Name`=?, `Weight`=?, `Unit`=?, `Description`=?, `MRP`=?, `JalpanPrice`=?, `Discount`=?,`Photo`=?,`Recomended`=? WHERE ID=?");
    $stmt->bind_param("iiisdisdddsii",$IDShop,$IDsubmenu,$IDSubsubmenu,$Name,$Weight,$Unit,$Description,$MRP,$JalpanPrice,$Discount,$Photo,$deal,$ID);
  }else{
     $stmt = $this->conn->prepare("UPDATE `foods` SET `IDMenu`=?,`IDSubmenu`=?, `IDSubsubmenu`=?, `Name`=?, `Weight`=?, `Unit`=?, `Description`=?, `MRP`=?, `JalpanPrice`=?, `Discount`=?,`Recomended`=? WHERE ID=?");
    $stmt->bind_param("iiisdisdddii",$IDShop,$IDsubmenu,$IDSubsubmenu,$Name,$Weight,$Unit,$Description,$MRP,$JalpanPrice,$Discount,$deal,$ID);
  }

    if(strlen($Photo1)!=0){
         $stmt = $this->conn->prepare("UPDATE `foods` SET `Photo1`=? WHERE ID=?");
    $stmt->bind_param("si",$Photo1,$ID);
                   }
                   if(strlen($Photo2)!=0){
         $stmt = $this->conn->prepare("UPDATE `foods` SET `Photo2`=? WHERE ID=?");
    $stmt->bind_param("si",$Photo2,$ID);
                   }
                   if(strlen($Photo3)!=0){
         $stmt = $this->conn->prepare("UPDATE `foods` SET `Photo3`=? WHERE ID=?");
    $stmt->bind_param("si",$Photo3,$ID);
                   }

   
    $stmt->execute();
    $error= $stmt->errno;
    printf("bbb: %d.\n", $error);
    $stmt->close();

            if($error==0){
     $result=true;
               
      
        }
    }
                return $result;
        
           
    }



 public function SiteActivateLinkFinal($id,$User,$IP){

    
        
        date_default_timezone_set('Africa/Johannesburg');
        $hour=date("H:i:s");
        $date=date("Y-m-d");
        $result=false;
        $ID=0;

            $stmt = $this->conn->prepare("SELECT ID FROM `final_services` WHERE ID=?");
            $stmt->bind_param("i",$id);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $ID=$user['ID'];
            $stmt->close();
   
               printf("ID: %d.\n", $ID);
           
    if( $ID!=0){
          $stmt = $this->conn->prepare("UPDATE final_services  SET  isActive=1 WHERE ID=?");
          $stmt->bind_param("i",$ID);
          $stmt->execute();
          $error= $stmt->errno;
          $last_id=$stmt->insert_id;
          printf("bbb: %d.\n", $error);
          $stmt->close();

            if($error==0){
     $result=true;
               
        }
    }

         
                return $result;
        
           
    }


 public function SiteActivateLinkSecondary($id,$User,$IP){

    
        
        date_default_timezone_set('Africa/Johannesburg');
        $hour=date("H:i:s");
        $date=date("Y-m-d");
        $result=false;
        $ID=0;

            $stmt = $this->conn->prepare("SELECT ID FROM `submenu` WHERE ID=?");
            $stmt->bind_param("i",$id);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $ID=$user['ID'];
            $stmt->close();
   
               printf("ID: %d.\n", $ID);
           
    if( $ID!=0){
          $stmt = $this->conn->prepare("UPDATE submenu  SET  isActive=1 WHERE ID=?");
          $stmt->bind_param("i",$ID);
          $stmt->execute();
          $error= $stmt->errno;
          $last_id=$stmt->insert_id;
          printf("bbb: %d.\n", $error);
          $stmt->close();

            if($error==0){
     $result=true;
               
        }
         $stmt = $this->conn->prepare("UPDATE foods  SET  Available=1 WHERE IDSubsubmenu=?");
          $stmt->bind_param("i",$ID);
          $stmt->execute();
          $error= $stmt->errno;
          printf("bbb: %d.\n", $error);
          $stmt->close();

            if($error==0){
     $result=true;
               
        }
    }

         
                return $result;
        
           
    }




 public function SiteActivateLinkThird($id,$User,$IP){

    
        
        date_default_timezone_set('Africa/Johannesburg');
        $hour=date("H:i:s");
        $date=date("Y-m-d");
        $result=false;
        $ID=0;

            $stmt = $this->conn->prepare("SELECT ID FROM `subsubmenu` WHERE ID=?");
            $stmt->bind_param("i",$id);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $ID=$user['ID'];
            $stmt->close();
   
               printf("ID: %d.\n", $ID);
           
    if( $ID!=0){
          $stmt = $this->conn->prepare("UPDATE subsubmenu  SET  isActive=1 WHERE ID=?");
          $stmt->bind_param("i",$ID);
          $stmt->execute();
          $error= $stmt->errno;
          $last_id=$stmt->insert_id;
          printf("bbb: %d.\n", $error);
          $stmt->close();

            if($error==0){
     $result=true;
               
        }
    }

         
                return $result;
        
           
    }



     public function DeleteThirdService($id,$User,$IP){

    
        
        date_default_timezone_set('Africa/Johannesburg');
        $hour=date("H:i:s");
        $date=date("Y-m-d");
        $result=false;
        $ID=0;

            $stmt = $this->conn->prepare("SELECT ID FROM `subsubmenu` WHERE ID=?");
            $stmt->bind_param("i",$id);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $ID=$user['ID'];
            $stmt->close();
   
               printf("ID: %d.\n", $ID);
           
    if( $ID!=0){
          $stmt = $this->conn->prepare("UPDATE subsubmenu  SET  isActive=0 WHERE ID=?");
          $stmt->bind_param("i",$ID);
          $stmt->execute();
          $error= $stmt->errno;
          $last_id=$stmt->insert_id;
          printf("bbb: %d.\n", $error);
          $stmt->close();

            if($error==0){
     $result=true;
               
        }
    }

         
                return $result;
        
           
    }


     public function DeleteFinalService($id,$User,$IP){

    
        
        date_default_timezone_set('Africa/Johannesburg');
        $hour=date("H:i:s");
        $date=date("Y-m-d");
        $result=false;
        $ID=0;

            $stmt = $this->conn->prepare("SELECT ID FROM `final_services` WHERE ID=?");
            $stmt->bind_param("i",$id);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $ID=$user['ID'];
            $stmt->close();
   
               printf("ID: %d.\n", $ID);
           
    if( $ID!=0){
          $stmt = $this->conn->prepare("UPDATE final_services  SET  isActive=0 WHERE ID=?");
          $stmt->bind_param("i",$ID);
          $stmt->execute();
          $error= $stmt->errno;
          $last_id=$stmt->insert_id;
          printf("bbb: %d.\n", $error);
          $stmt->close();

            if($error==0){
     $result=true;
               
        }
    }

         
                return $result;
        
           
    }



     public function EditWorkingSite($IDL,$Name,$special,$Description,$target_,$color,$User,$IP){

    
        
        date_default_timezone_set('Africa/Johannesburg');
        $hour=date("H:i:s");
        $date=date("Y-m-d");
        $result=false;
        $ID=0;

        
  
   $stmt = $this->conn->prepare("SELECT ID FROM `menu_type` WHERE ID=?");
            $stmt->bind_param("i",$IDL);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $ID=$user['ID'];
            $stmt->close();
   
               printf("ID: %d.\n", $ID);
           
    if( $ID!=0){

    if(strlen($target_)!=0){
    $stmt = $this->conn->prepare("UPDATE `menu_type` SET `Name`=?,`Photo`=?,`Specification`=?,`Description`=?,`Colors`=?,`User`=?,`Date`=?,`Time`=? WHERE  ID=?");
    $stmt->bind_param("ssssssssi",$Name,$target_,$special,$Description,$color,$User,$date,$hour,$ID);
  }else{
        $stmt = $this->conn->prepare("UPDATE `menu_type` SET `Name`=?,`Specification`=?,`Description`=?,`Colors`=?,`User`=?,`Date`=?,`Time`=? WHERE  ID=?");
    $stmt->bind_param("sssssssi",$Name,$special,$Description,$color,$User,$date,$hour,$ID);
  }
    $stmt->execute();
    $error= $stmt->errno;
    printf("bbb: %d.\n", $error);
    $stmt->close();

            if($error==0){
     $result=true;
               
      
        }
    }
                return $result;
        
           
    }


     public function EditFreze($IDL,$Name,$Photo,$User,$IP){

    
        
        date_default_timezone_set('Africa/Johannesburg');
        $hour=date("H:i:s");
        $date=date("Y-m-d");
        $result=false;
        $ID=0;

        
  
   $stmt = $this->conn->prepare("SELECT ID FROM `subsubmenu` WHERE ID=?");
            $stmt->bind_param("i",$IDL);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $ID=$user['ID'];
            $stmt->close();
   
           
           
    if( $ID!=0){

    if(strlen($Photo)!=0){
    $stmt = $this->conn->prepare("UPDATE `subsubmenu` SET `Name`=?,`Photo`=?,`Date`=?,`Time`=? WHERE  ID=?");
    $stmt->bind_param("ssssi",$Name,$Photo,$date,$hour,$ID);
  }else{
        $stmt = $this->conn->prepare("UPDATE `subsubmenu` SET `Name`=?,`Date`=?,`Time`=? WHERE  ID=?");
    $stmt->bind_param("sssi",$Name,$date,$hour,$ID);
  }
    $stmt->execute();
    $error= $stmt->errno;
    $stmt->close();

            if($error==0){
     $result=true;
               
      
        }
    }
                return $result;
        
           
    }


     public function addWorkingSite($Photo,$Name,$Description,$special,$color,$User,$IP){

    
        
        date_default_timezone_set('Asia/Kolkata');
        $hour=date("H:i:s");
        $date=date("Y-m-d");
        $result=false;
        $ID=0;

        

   


    $stmt = $this->conn->prepare("INSERT INTO `menu_type`(`Name`,`Photo`,`Description`,`Specification`,`Colors`, `User`, `Date`, `Time`) VALUES(?,?,?,?,?,?,?,?)");
    $stmt->bind_param("ssssssss",$Name,$Photo,$Description,$special,$color,$User,$date,$hour);
    $stmt->execute();
    $error= $stmt->errno;
    printf("bbb: %d.\n", $error);
    $stmt->close();

            if($error==0){
     $result=true;
               
      
        }
                return $result;
        
           
    }


 public function SiteActivateLink($id,$User,$IP){

    
        
        date_default_timezone_set('Africa/Johannesburg');
        $hour=date("H:i:s");
        $date=date("Y-m-d");
        $result=false;
        $ID=0;

            $stmt = $this->conn->prepare("SELECT ID FROM `menu_type` WHERE ID=?");
            $stmt->bind_param("i",$id);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $ID=$user['ID'];
            $stmt->close();
   
               printf("ID: %d.\n", $ID);
           
    if( $ID!=0){
          $stmt = $this->conn->prepare("UPDATE menu_type  SET  isActive=1,`Date`=?,`User`=?,`Time`=? WHERE ID=?");
          $stmt->bind_param("sssi",$date,$hour,$User,$ID);
          $stmt->execute();
          $error= $stmt->errno;
          $last_id=$stmt->insert_id;
          printf("bbb: %d.\n", $error);
          $stmt->close();

            if($error==0){
     $result=true;
               
        }

          $stmt = $this->conn->prepare("UPDATE foods  SET  Available=1 WHERE IDMenu=?");
          $stmt->bind_param("i",$ID);
          $stmt->execute();
          $error= $stmt->errno;
          printf("bbb: %d.\n", $error);
          $stmt->close();

            if($error==0){
     $result=true;
               
        }
    }

         
                return $result;
        
           
    }



     public function SiteDeleteLink($id,$User,$IP){

    
        
        date_default_timezone_set('Africa/Johannesburg');
        $hour=date("H:i:s");
        $date=date("Y-m-d");
        $result=false;
        $ID=0;

            $stmt = $this->conn->prepare("SELECT ID FROM `menu_type` WHERE ID=?");
            $stmt->bind_param("i",$id);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $ID=$user['ID'];
            $stmt->close();
   
               printf("ID: %d.\n", $ID);
           
    if( $ID!=0){
          $stmt = $this->conn->prepare("UPDATE menu_type  SET  isActive=0,`Date`=?,`User`=?,`Time`=? WHERE ID=?");
          $stmt->bind_param("sssi",$date,$hour,$User,$ID);
          $stmt->execute();
          $error= $stmt->errno;
          $last_id=$stmt->insert_id;
          printf("bbb: %d.\n", $error);
          $stmt->close();

            if($error==0){
     $result=true;
               
        }
         $stmt = $this->conn->prepare("UPDATE foods  SET  Available=0 WHERE IDMenu=?");
          $stmt->bind_param("i",$ID);
          $stmt->execute();
          $error= $stmt->errno;
          printf("bbb: %d.\n", $error);
          $stmt->close();

            if($error==0){
     $result=true;
               
        }
    }

         
                return $result;
        
           
    }



  







         public function DeleteLink($id,$User,$IP){

    
        
        date_default_timezone_set('Africa/Johannesburg');
        $hour=date("H:i:s");
        $date=date("Y-m-d");
        $result=false;
        $ID=0;

            $stmt = $this->conn->prepare("SELECT ID FROM `policies` WHERE ID=?");
            $stmt->bind_param("i",$id);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $ID=$user['ID'];
            $stmt->close();
   
               printf("ID: %d.\n", $ID);
           
    if( $ID!=0){
          $stmt = $this->conn->prepare("UPDATE policies  SET  isActive=0,`D_Date`=?,`D_Time`=?,`D_User`=?,`D_IP`=? WHERE ID=?");
          $stmt->bind_param("ssssi",$date,$hour,$User,$IP,$ID);
          $stmt->execute();
          $error= $stmt->errno;
          $last_id=$stmt->insert_id;
          printf("bbb: %d.\n", $error);
          $stmt->close();

            if($error==0){
     $result=true;
               
        }
    }

         
                return $result;
        
           
    }



         public function UpdatePolicy($id,$Details,$Links,$User,$IP,$Photo){

    
        
        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i:s");
        $date=date("Y-m-d");
        $result=false;
        $ID=0;

        
    

  $stmt = $this->conn->prepare("SELECT ID FROM `policies` WHERE ID=?");
            $stmt->bind_param("i",$id);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $ID=$user['ID'];
            $stmt->close();
   
               printf("ID: %s.\n", $Photo);
           
    if( $ID!=0){
   
    $stmt = $this->conn->prepare("UPDATE `policies` SET `Details`=?,`Links`=?,`uploadToServer`=?,`Date`=?,`User`=?,`Time`=?,`IP`=? WHERE  ID=?");
    $stmt->bind_param("sssssssi",$Details,$Links,$Photo,$date,$hour,$User,$IP,$ID);
       
    $stmt->execute();
    $error= $stmt->errno;
    printf("bbb: %d.\n", $error);
    $stmt->close();

            if($error==0){
     $result=true;
               
      }
        }
                return $result;
        
           
    }

         public function addPolicy($Title,$Details,$Links,$User,$IP,$Photo){

    
        
        date_default_timezone_set('Africa/Johannesburg');
        $hour=date("H:i:s");
        $date=date("Y-m-d");
        $result=false;
        $ID=0;

        
    


    $stmt = $this->conn->prepare("INSERT INTO `policies`(`Title`, `Details`, `Links`, `uploadToServer`, `isActive`, `Date`, `Time`, `User`, `IP`) VALUES (?,?,?,?,1,?,?,?,?)");
    $stmt->bind_param("ssssssss",$Title,$Details,$Links,$Photo,$date,$hour,$User,$IP);
       
    $stmt->execute();
    $error= $stmt->errno;
    printf("bbb: %d.\n", $error);
    $stmt->close();

            if($error==0){
     $result=true;
               
      
        }
                return $result;
        
           
    }

 

      
     public function DeleteStaff($id,$User,$IP){

    
        
        date_default_timezone_set('Africa/Johannesburg');
        $hour=date("H:i:s");
        $date=date("Y-m-d");
        $result=false;
        $ID=0;

            $stmt = $this->conn->prepare("SELECT ID FROM `admin_login_data` WHERE ID=?");
            $stmt->bind_param("i",$id);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $ID=$user['ID'];
            $stmt->close();
   
               printf("ID: %d.\n", $ID);
           
    if( $ID!=0){
          $stmt = $this->conn->prepare("UPDATE admin_login_data  SET  isStaff=0,isOffice=0,isAdmin=0,isDeleted=1,`D_Date`=?,`D_Time`=?,`D_User`=?,`D_IP`=? WHERE ID=?");
          $stmt->bind_param("ssssi",$date,$hour,$User,$IP,$ID);
          $stmt->execute();
          $error= $stmt->errno;
          $last_id=$stmt->insert_id;
          printf("bbb: %d.\n", $error);
          $stmt->close();

            if($error==0){
     $result=true;
               
        }
    }

         
                return $result;
        
           
    }




         public function UpdateVerifyStaff($id,$value,$User){

    
        
        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i:s");
        $date=date("Y-m-d");
        $result=false;
        $ID=0;

            $stmt = $this->conn->prepare("SELECT ID FROM `admin_login_data` WHERE StaffID=?");
            $stmt->bind_param("s",$User);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $ID=$user['ID'];
            $stmt->close();


   
 echo $value; echo $ID; echo $id;
           
    if( $ID!=0){


    $stmt = $this->conn->prepare("UPDATE `admin_login_data` SET isVerified=? WHERE  ID=?");
    $stmt->bind_param("ii",$value,$id);
    $stmt->execute();
    $error= $stmt->errno;
    printf("bbb: %d.\n", $error);
    $stmt->close();

            if($error==0){
     $result=true;
               
      
        }
    }

         
                return $result;
        
           
    }


         public function UpdateVerifyadmin($id,$value,$User){

    
        
        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i:s");
        $date=date("Y-m-d");
        $result=false;
        $ID=0;

            $stmt = $this->conn->prepare("SELECT ID FROM `admin_login_data` WHERE StaffID=?");
            $stmt->bind_param("s",$User);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $ID=$user['ID'];
            $stmt->close();


   
 echo $value; echo $ID; echo $id;
           
    if( $ID!=0){


    $stmt = $this->conn->prepare("UPDATE `salon_registration` SET isVerified=?,VerifiedBy=?,VerifiedDate=? WHERE  ID=?");
    $stmt->bind_param("iisi",$value,$ID,$date,$id);
    $stmt->execute();
    $error= $stmt->errno;
    printf("bbb: %d.\n", $error);
    $stmt->close();

            if($error==0){
     $result=true;
               
      
        }
    }

         
                return $result;
        
           
    }

     public function UpdateStaff($id,$firstName,$lastName,$email,$PhoneNo,$User,$IP,$Photo,$role){

    
        
        date_default_timezone_set('Africa/Johannesburg');
        $hour=date("H:i:s");
        $date=date("Y-m-d");
        $result=false;
        $ID=0;

            $stmt = $this->conn->prepare("SELECT ID FROM `admin_login_data` WHERE ID=?");
            $stmt->bind_param("i",$id);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $ID=$user['ID'];
            $stmt->close();
   

           
    if( $ID!=0){


    $stmt = $this->conn->prepare("UPDATE `admin_login_data` SET `FirstName`=?,`LastName`=?,`Role`=?,`Email`=?,`Photo`=?,`PhoneNo`=?,`Date`=?,`User`=?,`Time`=?,`IP`=? WHERE  ID=?");
    $stmt->bind_param("ssissssssss",$firstName,$lastName,$role,$email,$Photo,$PhoneNo,$date,$hour,$User,$IP,$ID);
       
    $stmt->execute();
    $error= $stmt->errno;
    printf("bbb: %d.\n", $error);
    $stmt->close();

            if($error==0){
     $result=true;
               
      
        }
    }

         
                return $result;
        
           
    }


         public function addStaff($firstName,$lastName,$email,$PhoneNo,$User,$IP,$Photo,$role){

    
        
        date_default_timezone_set('Africa/Johannesburg');
        $hour=date("H:i:s");
        $date=date("Y-m-d");
        $result=false;
        $ID=0;

            $stmt = $this->conn->prepare("SELECT isAdmin,ID FROM `admin_login_data` WHERE PhoneNo=?");
            $stmt->bind_param("s",$PhoneNo);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $ID=$user['ID'];
            $stmt->close();

            $stmt = $this->conn->prepare("SELECT isAdmin FROM `admin_login_data` WHERE User=?");
            $stmt->bind_param("s",$User);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $aID=$user['isAdmin'];
            $stmt->close();


            $mobile=substr($PhoneNo, 7);
            $StaffID=$firstName.$mobile;

            $password='123456';

   

           
    if( $ID==0){
   if($aID==1){
     if($role==1){
      $stmt = $this->conn->prepare("INSERT INTO `admin_login_data`(`FirstName`, `LastName`,`Role`,  `StaffID`, `Email`,`Photo`, `PhoneNo`, `Password`, `isAdmin`, `isStaff`, `isOffice`, `isVerified`, `Date`, `Time`,`User`, `IP`) VALUES (?,?,?,?,?,?,?,?,1,0,0,1,?,?,?,?)");
    $stmt->bind_param("ssisssssssss",$firstName,$lastName,$role,$StaffID,$email,$Photo,$PhoneNo,$password,$date,$hour,$User,$IP);
       
   }else if($role==2){
      $stmt = $this->conn->prepare("INSERT INTO `admin_login_data`(`FirstName`, `LastName`,`Role`,  `StaffID`, `Email`,`Photo`, `PhoneNo`, `Password`, `isAdmin`, `isStaff`, `isOffice`, `isVerified`, `Date`, `Time`,`User`, `IP`) VALUES (?,?,?,?,?,?,?,?,0,0,1,1,?,?,?,?)");
    $stmt->bind_param("ssisssssssss",$firstName,$lastName,$role,$StaffID,$email,$Photo,$PhoneNo,$password,$date,$hour,$User,$IP);
       
   }else if($role==3){
      $stmt = $this->conn->prepare("INSERT INTO `admin_login_data`(`FirstName`, `LastName`,`Role`,`StaffID`, `Email`,`Photo`, `PhoneNo`, `Password`, `isAdmin`, `isStaff`, `isOffice`, `isVerified`, `Date`, `Time`,`User`, `IP`) VALUES (?,?,?,?,?,?,?,?,0,1,0,1,?,?,?,?)");
    $stmt->bind_param("ssisssssssss",$firstName,$lastName,$role,$StaffID,$email,$Photo,$PhoneNo,$password,$date,$hour,$User,$IP);
       
   }  
   }else{
   if($role==1){
      $stmt = $this->conn->prepare("INSERT INTO `admin_login_data`(`FirstName`, `LastName`,`Role`,  `StaffID`, `Email`,`Photo`, `PhoneNo`, `Password`, `isAdmin`, `isStaff`, `isOffice`, `isVerified`, `Date`, `Time`,`User`, `IP`) VALUES (?,?,?,?,?,?,?,?,1,0,0,1,?,?,?,?)");
    $stmt->bind_param("ssisssssssss",$firstName,$lastName,$role,$StaffID,$email,$Photo,$PhoneNo,$password,$date,$hour,$User,$IP);
       
   }else if($role==2){
      $stmt = $this->conn->prepare("INSERT INTO `admin_login_data`(`FirstName`, `LastName`,`Role`,`StaffID`, `Email`,`Photo`, `PhoneNo`, `Password`, `isAdmin`, `isStaff`, `isOffice`, `isVerified`, `Date`, `Time`,`User`, `IP`) VALUES (?,?,?,?,?,?,?,?,0,0,1,0,?,?,?,?)");
    $stmt->bind_param("ssisssssssss",$firstName,$lastName,$role,$StaffID,$email,$Photo,$PhoneNo,$password,$date,$hour,$User,$IP);
       
   }else if($role==3){
      $stmt = $this->conn->prepare("INSERT INTO `admin_login_data`(`FirstName`, `LastName`,`Role`,  `StaffID`, `Email`,`Photo`, `PhoneNo`, `Password`, `isAdmin`, `isStaff`, `isOffice`, `isVerified`, `Date`, `Time`,`User`, `IP`) VALUES (?,?,?,?,?,?,?,?,0,1,0,0,?,?,?,?)");
    $stmt->bind_param("ssisssssssss",$firstName,$lastName,$role,$StaffID,$email,$Photo,$PhoneNo,$password,$date,$hour,$User,$IP);
       
   }
 }
       
    $stmt->execute();
    $error= $stmt->errno;
    printf("bbb: %d.\n", $error);
    $stmt->close();

            if($error==0){
     $result=true;
               
      
        }
    }

         
                return $result;
        
           
    }


 
  
   public function createAdmin($user_name,$email,$_password,$IP){
    

        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i:s");
        $date=date("Y-m-d");
        $pwd=sha1($_password);
        $result=false;
       
            $stmt = $this->conn->prepare("SELECT ID FROM admin_login_data WHERE `Email`=? ");
            $stmt->bind_param("s",$email);
            $stmt->execute();
            $user1 = $stmt->get_result()->fetch_assoc();
            $wID=$user1["ID"];
            printf("Error: %d.\n", $stmt->errno);
            $stmt->close();

            $stmt = $this->conn->prepare("SELECT ID FROM admin_verified WHERE `Email`=? ");
            $stmt->bind_param("s",$email);
            $stmt->execute();
            $user1 = $stmt->get_result()->fetch_assoc();
            $vID=$user1["ID"];
            printf("Error: %d.\n", $stmt->errno);
            $stmt->close();


     if($wID==0 && $vID!=0){
           
            $stmt = $this->conn->prepare("INSERT INTO `admin_login_data`(`Name`, `Email`, `Password`,`Date`,`Time`, `IP`)  VALUES(?,?,?,?,?,?)");
            $stmt->bind_param("ssssss",$user_name,$email,$pwd,$date,$hour,$IP);
            $stmt->execute();

            if( $stmt->errno==0){
                $result=true;
            }
            printf("Errorl: %d.\n", $stmt->errno);
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


   



public function loginAdmin($email,$password) {
       
        date_default_timezone_set(TIMEZONE);
        $hour=date("H:i:s");
        $date=date("Y-m-d");
       
        $fID=0;
            $Mail=strtoupper($email);
            $stmt = $this->conn->prepare("SELECT ID,Password FROM  admin_login_data WHERE StaffID=? ");
            $stmt->bind_param("s",$Mail);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $fID=$user['ID'];
            $pwd=strtoupper($user['Password']);
            $stmt->close();
           printf("pwd1: %s.\n", $pwd);
               
                             
            $sID=strtoupper(($password));
       printf("pwd2: %s.\n", $sID);
           printf("result: %d.\n", strcmp($pwd,$sID));
            if($fID!=0){
            if(strcmp($pwd,$sID)!=0){
               
               return 1;
            }else{
    
                 return 3;
            }
     
        }else{
          return 2;  
        }
    }
   
  

}
?>