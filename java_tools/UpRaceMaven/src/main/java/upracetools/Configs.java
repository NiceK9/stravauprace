/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package upracetools;

/**
 *
 * @author nice
 */
public class Configs {
    public static final boolean isLive = false;
    
    public static String getServerUpRace()
    {
        if(isLive)
            return "http://uprace.vn";
        else
            return "http://dev.uprace.vn";
    }
}
