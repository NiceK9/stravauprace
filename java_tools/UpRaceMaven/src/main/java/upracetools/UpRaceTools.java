/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package upracetools;

import com.fasterxml.jackson.databind.ObjectMapper;
import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;
import java.security.Timestamp;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;
import java.util.List;
import upracetools.NetworkUltility;
import upracetools.data.UserProfileRespone;

/**
 *
 * @author nice
 */
public class UpRaceTools {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        // TODO code application logic here
        
        new UpRaceTools();
    }

    public UpRaceTools() {
        try{
            long start_time = DateTimeUtils.getStartOfDay("20180901");
            long end_time = DateTimeUtils.getEndOfDay("20180906");

            System.out.println();
            List<Integer> activity_ids = StravaManager.getListActivityOfUser(StravaManager.getUserTokenBy("41", "", OpenSocial.STRAVA), start_time, end_time);
            
            
        }catch(Exception e)
        {
            e.printStackTrace();
        }
    }    

}
