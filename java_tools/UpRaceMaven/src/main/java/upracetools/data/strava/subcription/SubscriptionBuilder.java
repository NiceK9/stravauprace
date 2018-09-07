/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package upracetools.data.strava.subcription;

/**
 *
 * @author nice
 */
public class SubscriptionBuilder {
    static SubscriptionRequest build(int event_time_utc, int owner_id, int activity_id)
    {
        SubscriptionRequest sub = new SubscriptionRequest();
        sub.setAspectType("update");
        sub.setObjectType("activity");
        sub.setSubscriptionId((int)(Math.random() * Integer.MAX_VALUE));
        sub.setOwnerId(owner_id);
        sub.setObjectId(activity_id);
        sub.setEventTime(event_time_utc);
        
        return sub;
    }
}
