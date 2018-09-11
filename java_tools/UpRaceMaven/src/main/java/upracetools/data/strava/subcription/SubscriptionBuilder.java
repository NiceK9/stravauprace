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
    public static SubscriptionRequest build(long event_time_utc, int owner_id, int activity_id)
    {
        SubscriptionRequest sub = new SubscriptionRequest();
        sub.setAspect_type("create");
        sub.setObject_type("activity");
        sub.setSubscription_id((int)(Math.random() * Integer.MAX_VALUE) + "");
        sub.setOwner_id(owner_id + "");
        sub.setObject_id(activity_id);
        sub.setEvent_time((int)event_time_utc);
        
        return sub;
    }
}
