
package upracetools.data.strava.subcription;

import java.util.HashMap;
import java.util.Map;

public class SubscriptionRequest {

    private String aspectType;
    private Integer eventTime;
    private Integer objectId;
    private String objectType;
    private Integer ownerId;
    private Integer subscriptionId;
    private Updates updates;
    private Map<String, Object> additionalProperties = new HashMap<String, Object>();

    public String getAspectType() {
        return aspectType;
    }

    public void setAspectType(String aspectType) {
        this.aspectType = aspectType;
    }

    public Integer getEventTime() {
        return eventTime;
    }

    public void setEventTime(Integer eventTime) {
        this.eventTime = eventTime;
    }

    public Integer getObjectId() {
        return objectId;
    }

    public void setObjectId(Integer objectId) {
        this.objectId = objectId;
    }

    public String getObjectType() {
        return objectType;
    }

    public void setObjectType(String objectType) {
        this.objectType = objectType;
    }

    public Integer getOwnerId() {
        return ownerId;
    }

    public void setOwnerId(Integer ownerId) {
        this.ownerId = ownerId;
    }

    public Integer getSubscriptionId() {
        return subscriptionId;
    }

    public void setSubscriptionId(Integer subscriptionId) {
        this.subscriptionId = subscriptionId;
    }

    public Updates getUpdates() {
        return updates;
    }

    public void setUpdates(Updates updates) {
        this.updates = updates;
    }

    public Map<String, Object> getAdditionalProperties() {
        return this.additionalProperties;
    }

    public void setAdditionalProperty(String name, Object value) {
        this.additionalProperties.put(name, value);
    }

}
