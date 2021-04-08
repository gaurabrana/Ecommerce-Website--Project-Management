<?php
date_default_timezone_set("Asia/Kathmandu");
$included_date = date('Y-m-d H:i:s', strtotime('+24 hour',strtotime($order_date)));
echo $included_date;
$weekday = date('l',strtotime($included_date));
$hour = date('H:i:s',strtotime($included_date));
if(strtotime($weekday)==strtotime("Saturday") OR strtotime($weekday)==strtotime("Sunday") OR strtotime($weekday)==strtotime("Monday") OR strtotime($weekday)==strtotime("Tuesday")){                                  
      echo'<form action="ordersuccess.php?slot='.$orderid.'" method="POST">
      <select name="day">';
      if(strtotime($weekday)==strtotime("Saturday")){        
        $sql = "Select * from collectionslot where slotid>9";    
      }
      else{
        $sql = "Select * from collectionslot where slotid<10";        
      }      
      $res = oci_parse($conn, $sql);
      oci_execute($res);
      while($data=oci_fetch_assoc($res)){            
          if($data['NUMBER_OF_ORDERS']<20){
            if($data['SLOTID']>9){
                echo'<option value='.$data['SLOTID'].'>'.$data['DAY'].' '.$data['COLLECTIONTIME'].' ('.$data['WEEK_COUNT'].')</option>';          
              }   
              else{
                echo'<option value='.$data['SLOTID'].'>'.$data['DAY'].' '.$data['COLLECTIONTIME'].'</option>';          
              }
          }                           
      }
      echo'</select>              
              <input type="submit" value="Select Slot" name="slotchoose">
              </form>';                               
}
 if(strtotime("Wednesday")==strtotime($weekday)){        
    if(strtotime($hour) < strtotime("10:00:00")){              
      echo'<form action="ordersuccess.php?slot='.$orderid.'" method="POST">
      <select name="day">';
      $sql = "Select * from collectionslot where slotid<10";
      $res = oci_parse($conn, $sql);
      oci_execute($res);
      while($data=oci_fetch_assoc($res)){       
        if($data['NUMBER_OF_ORDERS']<20){   
        echo'<option value='.$data['SLOTID'].'>'.$data['DAY'].' '.$data['COLLECTIONTIME'].'</option>';          
        }
      }
      echo'</select>              
              <input type="submit" value="Select Slot" name="slotchoose">
              </form>';                               
    }
    else if(strtotime($hour) >= strtotime("10:00:00") AND strtotime($hour) < strtotime("13:00:00")){                  
        echo'<form action="ordersuccess.php?slot='.$orderid.'" method="POST">
        <select name="day">';
      $sql = "Select * from collectionslot where slotid!=1 and slotid<10";
      $res = oci_parse($conn, $sql);
      oci_execute($res);
      while($data=oci_fetch_assoc($res)){     
        if($data['NUMBER_OF_ORDERS']<20){     
            echo'<option value='.$data['SLOTID'].'>'.$data['DAY'].' '.$data['COLLECTIONTIME'].'</option>';      
        }    
      }
      echo'</select>              
      <input type="submit" value="Select Slot" name="slotchoose">
      </form>';                 
      
    }
    else if(strtotime($hour) >= strtotime("13:00:00") AND strtotime($hour) <= strtotime("16:00:00")){
        echo'<form action="ordersuccess.php?slot='.$orderid.'" method="POST">
        <select name="day">';
        $sql = "Select * from collectionslot where slotid>2 and slotid<10";
        $res = oci_parse($conn, $sql);
        oci_execute($res);
        while($data=oci_fetch_assoc($res)){          
            if($data['NUMBER_OF_ORDERS']<20){
              echo'<option value='.$data['SLOTID'].'>'.$data['DAY'].' '.$data['COLLECTIONTIME'].'</option>';          
            }
        }      
        echo'</select>              
        <input type="submit" value="Select Slot" name="slotchoose">
        </form>';                 
        
    }
    else{
        echo'<form action="ordersuccess.php?slot='.$orderid.'" method="POST">
              <select name="day">';                             
              $sql = "Select * from collectionslot where slotid>3 and slotid<13";
              $res = oci_parse($conn, $sql);
              oci_execute($res);
              while($data=oci_fetch_assoc($res)){  
                if($data['NUMBER_OF_ORDERS']<20){        
                  if($data['SLOTID']>9){
                    echo'<option value='.$data['SLOTID'].'>'.$data['DAY'].' '.$data['COLLECTIONTIME'].' ('.$data['WEEK_COUNT'].')</option>';  
                  }
                  else{
                    echo'<option value='.$data['SLOTID'].'>'.$data['DAY'].' '.$data['COLLECTIONTIME'].'</option>';          
                  }                    
              } 
            }
              echo'</select>              
              <input type="submit" value="Select Slot" name="slotchoose">
              </form>'; 
              
    }
}
//thursday
if(strtotime("Thursday")==strtotime($weekday)){
    if(strtotime($hour) < strtotime("10:00:00")){
        echo'<form action="ordersuccess.php?slot='.$orderid.'" method="POST">
              <select name="day">';                             
              $sql = "Select * from collectionslot where slotid>3 and slotid<13";
              $res = oci_parse($conn, $sql);
              oci_execute($res);
              while($data=oci_fetch_assoc($res)){   
                if($data['NUMBER_OF_ORDERS']<20){       
                    if($data['SLOTID']>9){
                        echo'<option value='.$data['SLOTID'].'>'.$data['DAY'].' '.$data['COLLECTIONTIME'].' ('.$data['WEEK_COUNT'].')</option>';  
                      }
                      else{
                        echo'<option value='.$data['SLOTID'].'>'.$data['DAY'].' '.$data['COLLECTIONTIME'].'</option>';          
                      }                    
                }
              } 
              echo'</select>              
              <input type="submit" value="Select Slot" name="slotchoose">
              </form>'; 
              
    }
    else if(strtotime($hour) >= strtotime("10:00:00") AND strtotime($hour) < strtotime("13:00:00")){
        echo'<form action="ordersuccess.php?slot='.$orderid.'" method="POST">
              <select name="day">';                             
              $sql = "Select * from collectionslot where slotid>4 and slotid<13";
              $res = oci_parse($conn, $sql);
              oci_execute($res);
              while($data=oci_fetch_assoc($res)){          
                if($data['NUMBER_OF_ORDERS']<20){       
                    if($data['SLOTID']>9){
                        echo'<option value='.$data['SLOTID'].'>'.$data['DAY'].' '.$data['COLLECTIONTIME'].' ('.$data['WEEK_COUNT'].')</option>';  
                      }
                      else{
                        echo'<option value='.$data['SLOTID'].'>'.$data['DAY'].' '.$data['COLLECTIONTIME'].'</option>';          
                      }                    
                }
              } 
              echo'</select>              
              <input type="submit" value="Select Slot" name="slotchoose">
              </form>'; 
              
    }
    else if(strtotime($hour) >= strtotime("13:00:00") AND strtotime($hour) < strtotime("16:00:00")){
        echo'<form action="ordersuccess.php?slot='.$orderid.'" method="POST">
              <select name="day">';                             
              $sql = "Select * from collectionslot where slotid>5 and slotid<13";
              $res = oci_parse($conn, $sql);
              oci_execute($res);
              while($data=oci_fetch_assoc($res)){          
                if($data['NUMBER_OF_ORDERS']<20){       
                    if($data['SLOTID']>9){
                        echo'<option value='.$data['SLOTID'].'>'.$data['DAY'].' '.$data['COLLECTIONTIME'].' ('.$data['WEEK_COUNT'].')</option>';  
                      }
                      else{
                        echo'<option value='.$data['SLOTID'].'>'.$data['DAY'].' '.$data['COLLECTIONTIME'].'</option>';          
                      }                    
                }     
              } 
              echo'</select>              
              <input type="submit" value="Select Slot" name="slotchoose">
              </form>'; 
              
    }
    else{
        echo'<form action="ordersuccess.php?slot='.$orderid.'" method="POST">
              <select name="day">';                             
              $sql = "Select * from collectionslot where slotid>6 and slotid<16";
              $res = oci_parse($conn, $sql);
              oci_execute($res);
              while($data=oci_fetch_assoc($res)){          
                if($data['NUMBER_OF_ORDERS']<20){       
                    if($data['SLOTID']>9){
                        echo'<option value='.$data['SLOTID'].'>'.$data['DAY'].' '.$data['COLLECTIONTIME'].' ('.$data['WEEK_COUNT'].')</option>';  
                      }
                      else{
                        echo'<option value='.$data['SLOTID'].'>'.$data['DAY'].' '.$data['COLLECTIONTIME'].'</option>';          
                      }                    
                }                                              
              } 
              echo'</select>              
              <input type="submit" value="Select Slot" name="slotchoose">
              </form>'; 
              
    }

}
//friday
if(strtotime("Friday")==strtotime($weekday)){
    if(strtotime($hour) < strtotime("10:00:00")){
        echo'<form action="ordersuccess.php?slot='.$orderid.'" method="POST">
              <select name="day">';                             
              $sql = "Select * from collectionslot where slotid>6 and slotid<16";
              $res = oci_parse($conn, $sql);
              oci_execute($res);
              while($data=oci_fetch_assoc($res)){          
                if($data['NUMBER_OF_ORDERS']<20){       
                    if($data['SLOTID']>9){
                        echo'<option value='.$data['SLOTID'].'>'.$data['DAY'].' '.$data['COLLECTIONTIME'].' ('.$data['WEEK_COUNT'].')</option>';  
                      }
                      else{
                        echo'<option value='.$data['SLOTID'].'>'.$data['DAY'].' '.$data['COLLECTIONTIME'].'</option>';          
                      }                    
                }  
              } 
              echo'</select>              
              <input type="submit" value="Select Slot" name="slotchoose">
              </form>'; 
              
    }
    else if(strtotime($hour) >= strtotime("10:00:00") AND strtotime($hour) < strtotime("13:00:00")){
        echo'<form action="ordersuccess.php?slot='.$orderid.'" method="POST">
        <select name="day">';                             
        $sql = "Select * from collectionslot where slotid>7 and slotid<16";
        $res = oci_parse($conn, $sql);
        oci_execute($res);
        while($data=oci_fetch_assoc($res)){          
          if($data['NUMBER_OF_ORDERS']<20){       
              if($data['SLOTID']>9){
                  echo'<option value='.$data['SLOTID'].'>'.$data['DAY'].' '.$data['COLLECTIONTIME'].' ('.$data['WEEK_COUNT'].')</option>';  
                }
                else{
                  echo'<option value='.$data['SLOTID'].'>'.$data['DAY'].' '.$data['COLLECTIONTIME'].'</option>';          
                }                    
          }  
        } 
        echo'</select>              
        <input type="submit" value="Select Slot" name="slotchoose">
        </form>'; 
        
    }
    else if(strtotime($hour) >= strtotime("13:00:00") AND strtotime($hour) < strtotime("16:00:00")){
        echo'<form action="ordersuccess.php?slot='.$orderid.'" method="POST">
              <select name="day">';                             
              $sql = "Select * from collectionslot where slotid>8 and slotid<16";
              $res = oci_parse($conn, $sql);
              oci_execute($res);
              while($data=oci_fetch_assoc($res)){          
                if($data['NUMBER_OF_ORDERS']<20){       
                    if($data['SLOTID']>9){
                        echo'<option value='.$data['SLOTID'].'>'.$data['DAY'].' '.$data['COLLECTIONTIME'].' ('.$data['WEEK_COUNT'].')</option>';  
                      }
                      else{
                        echo'<option value='.$data['SLOTID'].'>'.$data['DAY'].' '.$data['COLLECTIONTIME'].'</option>';          
                      }                    
                }  
              } 
              echo'</select>              
              <input type="submit" value="Select Slot" name="slotchoose">
              </form>'; 
              
    }
    else{
        echo'<form action="ordersuccess.php?slot='.$orderid.'" method="POST">
              <select name="day">';                             
              $sql = "Select * from collectionslot where slotid>9";
              $res = oci_parse($conn, $sql);
              oci_execute($res);
              while($data=oci_fetch_assoc($res)){          
                if($data['NUMBER_OF_ORDERS']<20){       
                    if($data['SLOTID']>9){
                        echo'<option value='.$data['SLOTID'].'>'.$data['DAY'].' '.$data['COLLECTIONTIME'].' ('.$data['WEEK_COUNT'].')</option>';  
                      }
                      else{
                        echo'<option value='.$data['SLOTID'].'>'.$data['DAY'].' '.$data['COLLECTIONTIME'].'</option>';          
                      }                    
                }  
              } 
              echo'</select>              
              <input type="submit" value="Select Slot" name="slotchoose">
              </form>'; 
              
    }
}
?>