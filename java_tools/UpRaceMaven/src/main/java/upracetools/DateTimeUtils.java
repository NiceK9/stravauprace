/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package upracetools;

import java.text.ParseException;
import java.text.SimpleDateFormat;

/**
 *
 * @author nice
 */
public class DateTimeUtils {
    static public long getStartOfDayUTC(String fromDay) throws ParseException
    {        
        SimpleDateFormat dateFormat = new SimpleDateFormat( "yyyyMMdd" );
        dateFormat.parse(fromDay);
        return dateFormat.getCalendar().getTimeInMillis()/1000;
    }
    static public long getEndOfDayUTC(String endDay) throws ParseException
    {        
        SimpleDateFormat dateFormat = new SimpleDateFormat( "yyyyMMddhhmmss" );
        dateFormat.parse(endDay + "235959");
        return dateFormat.getCalendar().getTimeInMillis()/1000;
    }
}
