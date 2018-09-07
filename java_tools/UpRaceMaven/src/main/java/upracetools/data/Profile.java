
package upracetools.data;

import java.util.HashMap;
import java.util.List;
import java.util.Map;

public class Profile {

    private User user;
    private List<UserEvent> userEvents = null;
    private UserConnect userConnect;
    private Map<String, Object> additionalProperties = new HashMap<String, Object>();

    public User getUser() {
        return user;
    }

    public void setUser(User user) {
        this.user = user;
    }

    public List<UserEvent> getUserEvents() {
        return userEvents;
    }

    public void setUserEvents(List<UserEvent> userEvents) {
        this.userEvents = userEvents;
    }

    public UserConnect getUserConnect() {
        return userConnect;
    }

    public void setUserConnect(UserConnect userConnect) {
        this.userConnect = userConnect;
    }

    public Map<String, Object> getAdditionalProperties() {
        return this.additionalProperties;
    }

    public void setAdditionalProperty(String name, Object value) {
        this.additionalProperties.put(name, value);
    }

}
