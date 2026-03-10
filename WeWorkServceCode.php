<?php



class Index 
{


   
        
    
    /* GET_AGENT_SIGNATURE_FUNCTION*/
    public function get_agent_signature()
    {   
        
      
        if (isset($_SESSION['agent_ticket'])) {
        
        return $_SESSION['agent_ticket'];
            
            } else {
         
                
        $get_access_token_url="https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=YOUR_WORKWECHA_APPLICATION’S_APPID"&corpsecret="YOUR_CORPSECRET";
        $response = file_get_contents($get_access_token_url);
        $access_token_data = json_decode($response, true);

       if($access_token_data["access_token"]){  //if got access_token successfully
       
        $access_token=$access_token_data["access_token"];
        $_SESSION['access_token'] = $access_token;    //save this "access_token" in this file
       
        //post to get agent_ticket back
        $get_agent_ticket_url="https://qyapi.weixin.qq.com/cgi-bin/ticket/get?access_token=".$access_token."&type=agent_config";//获取应用jsapi_ticket
        $response1 = file_get_contents($get_agent_ticket_url);
        
        $agent_ticket_data= json_decode($response1, true);

        if($agent_ticket_data["ticket"]){//if I got agent_ticket successfully
           
        $agent_ticket=$agent_ticket_data["ticket"];
   
         //save this "agent_ticket" in this file
        $_SESSION['agent_ticket'] = $agent_ticket;       

            return $agent_ticket; 
         }   
                
                
            
             
            }
        
     
        
        
    }
    
    }
    
    




  /* GET_WORK_WECHAT_USER_INFO_FUNCTION*/
       public function ww_get_user_info()
    { 
        
        
    
        
    
    $code=$this->request->post("code");

    $get_access_token_url="https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=wwc76de3cd7c5ce1be&corpsecret=lBJQwGsr5QAYqkdmmW4DFHB4drUiSh844AO4E0pRVjw";//get access_token again
        $response = file_get_contents($get_access_token_url);
        $access_token_data = json_decode($response, true);
        $access_token = $access_token_data["access_token"];
    
    $url="https://qyapi.weixin.qq.com/cgi-bin/auth/getuserinfo?access_token=".$access_token."&code=".$code;
    $res = file_get_contents($url);
    $user_id_data = json_decode($res, true);
    
  
    
    if($user_id_data["userid"]){//if got ww_userid successfully
    
    $jsonData1=json_encode($user_id_data,true);
    $user_id=$user_id_data["userid"];
    $url2="https://qyapi.weixin.qq.com/cgi-bin/user/get?access_token=".$access_token."&userid=".$user_id;  
    $res2 = file_get_contents($url2);
    $user_data = json_decode($res2, true);
    
 
        if($user_data["name"]){//if got ww_username successfully
     
        $ww_name=$user_data["name"];
        $department=json_encode(($user_data["department"]),true);
        $department1= str_replace(["[", "]"],"", $str);
        
        
        $return_data=array(
            
            "ww_user_id"=>$user_id,
            "ww_position"=>$department1,
            "ww_user_name"=>$ww_name,
          
            
            );
          
        
        return json($return_data);
   
        
        }
 
    }
      
    
    
    
    
    }
    
    
    
    
    
    
}
