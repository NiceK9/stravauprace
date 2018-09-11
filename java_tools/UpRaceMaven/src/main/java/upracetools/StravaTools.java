/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package upracetools;

import java.util.List;
import upracetools.data.Activity;
import upracetools.data.Profile;

/**
 *
 * @author nice
 */


public class StravaTools 
{
    public StravaTools(String userid) {
        try{
            long start_time = DateTimeUtils.getStartOfDayUTC("201809010");
            long end_time = DateTimeUtils.getEndOfDayUTC("20180911");
            Profile profile = StravaManager.getUserTokenBy(userid, "", OpenSocial.STRAVA);
            ;
            
//            StravaManager.getActivityOfUser(profile.getUserConnect().getAccessToken(), "1828750797");
            List<Activity> lstActivity = StravaManager.getListActivityOfUser(profile.getUserConnect().getAccessToken(), start_time, end_time);
            
//            for(Activity act : lstActivity)
//            {
//                Calendar cal = Calendar.getInstance();                
//                SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd'T'HH:mm:ss'Z'");
//                sdf.setCalendar(cal);
//                cal.setTime(sdf.parse(act.getStart_date()));
//                long mil = cal.getTimeInMillis()/1000 + 7*3600;
//                SubscriptionRequest request = SubscriptionBuilder.build(mil, Integer.parseInt(profile.getUserConnect().getOpenId()), act.getId());
//                
//                
//		ObjectMapper mapper = new ObjectMapper();
//
//                // Convert object to JSON string
//                String jsonInString = mapper.writeValueAsString(request);
//                
//                String result = NetworkUltility.sendPost(Configs.getServerUpRace() + "/api/strava_callback", jsonInString);
//                System.out.println(result);
//            }
        }catch(Exception e)
        {
            e.printStackTrace();
        }
    }  
}
