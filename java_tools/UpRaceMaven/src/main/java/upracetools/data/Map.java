
package upracetools.data;

import java.util.HashMap;

public class Map {

    private String id;
    private Object summary_polyline;
    private Integer resource_state;
    private java.util.Map<String, Object> additionalProperties = new HashMap<String, Object>();

    public String getId() {
        return id;
    }

    public void setId(String id) {
        this.id = id;
    }

    public Object getSummary_polyline() {
        return summary_polyline;
    }

    public void setSummary_polyline(Object summary_polyline) {
        this.summary_polyline = summary_polyline;
    }

    public Integer getResource_state() {
        return resource_state;
    }

    public void setResource_state(Integer resource_state) {
        this.resource_state = resource_state;
    }

    public java.util.Map<String, Object> getAdditionalProperties() {
        return this.additionalProperties;
    }

    public void setAdditionalProperty(String name, Object value) {
        this.additionalProperties.put(name, value);
    }

}
