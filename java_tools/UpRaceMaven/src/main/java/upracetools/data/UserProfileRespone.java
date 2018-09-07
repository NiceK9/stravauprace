
package upracetools.data;

import java.util.HashMap;
import java.util.Map;

public class UserProfileRespone {

    private Profile profile;
    private Error error;
    private Map<String, Object> additionalProperties = new HashMap<String, Object>();

    public Profile getProfile() {
        return profile;
    }

    public void setProfile(Profile profile) {
        this.profile = profile;
    }

    public Error getError() {
        return error;
    }

    public void setError(Error error) {
        this.error = error;
    }

    public Map<String, Object> getAdditionalProperties() {
        return this.additionalProperties;
    }

    public void setAdditionalProperty(String name, Object value) {
        this.additionalProperties.put(name, value);
    }

}
