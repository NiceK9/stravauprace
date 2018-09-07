/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package upracetools;

import com.fasterxml.jackson.databind.ObjectMapper;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import upracetools.data.Activity;
import upracetools.data.UserProfileRespone;

/**
 *
 * @author nice
 */
public class StravaManager {
    
    public static String getUserTokenBy(String user_id, String open_id, int open_type) throws Exception, IOException {
        String url = String.format("https://uprace.vn/api/user/profile?user_id=%s&open_type=%s&open_id=%s", user_id, open_type, open_id) ;
        String result = NetworkUltility.sendGet(url, "");
        
        //print result
        System.out.println(result);
        
        ObjectMapper mapper = new ObjectMapper();
        
        //JSON from String to Object
        UserProfileRespone userProfileRespone = mapper.readValue(result, UserProfileRespone.class);
        
        
        return userProfileRespone.getProfile().getUserConnect().getAccessToken();
    }  
    
    public static List<Integer> getListActivityOfUser(String token, long start_time, long end_time) throws Exception, IOException {
        String url = String.format("https://www.strava.com/api/v3/athlete/activities?after=%s&page=0", start_time + "") ;
        String result = NetworkUltility.sendGet(url, token);
        
        //print result
        System.out.println(result);
        
        ObjectMapper mapper = new ObjectMapper();
        
        List<Integer> lstActivityId = new ArrayList<Integer>();
        
        //JSON from String to Object
        List<Activity> lstActivity = mapper.readValue(result, mapper.getTypeFactory().constructCollectionType(List.class, Activity.class));
        
        for(Activity activity : lstActivity)
        {
            int id = activity.getId();
            
            System.out.println("id: " + id);
            lstActivityId.add(id);
        }
        
        return lstActivityId;
    } 
}
