package upracetools.data.strava.subcription;

import java.util.HashMap;
import java.util.Map;

public class SubscriptionRequest {

    private String aspect_type;
    private Integer event_time;
    private Integer object_id;
    private String object_type;
    private String owner_id;
    private String subscription_id;
    private Map<String, Object> additionalProperties = new HashMap<String, Object>();

    public String getAspect_type() {
        return aspect_type;
    }

    public void setAspect_type(String aspect_type) {
        this.aspect_type = aspect_type;
    }

    public Integer getEvent_time() {
        return event_time;
    }

    public void setEvent_time(Integer event_time) {
        this.event_time = event_time;
    }

    public Integer getObject_id() {
        return object_id;
    }

    public void setObject_id(Integer object_id) {
        this.object_id = object_id;
    }

    public String getObject_type() {
        return object_type;
    }

    public void setObject_type(String object_type) {
        this.object_type = object_type;
    }

    public String getOwner_id() {
        return owner_id;
    }

    public void setOwner_id(String owner_id) {
        this.owner_id = owner_id;
    }

    public String getSubscription_id() {
        return subscription_id;
    }

    public void setSubscription_id(String subscription_id) {
        this.subscription_id = subscription_id;
    }

    public Map<String, Object> getAdditionalProperties() {
        return this.additionalProperties;
    }

    public void setAdditionalProperty(String name, Object value) {
        this.additionalProperties.put(name, value);
    }

}
