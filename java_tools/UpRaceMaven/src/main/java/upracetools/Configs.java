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
    public static final boolean isLive = true;
    
    public static String getServerUpRace()
    {
        if(isLive)
            return "https://uprace.vn";
        else
            return "https://dev.uprace.vn";
    }
}
