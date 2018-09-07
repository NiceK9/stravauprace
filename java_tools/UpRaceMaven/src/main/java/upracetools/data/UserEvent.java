
package upracetools.data;

import java.util.HashMap;
import java.util.Map;

public class UserEvent {

    private Integer userId;
    private Integer teamId;
    private Integer eventId;
    private Integer rank;
    private Boolean isSentEmail;
    private Boolean isBanned;
    private Boolean isActive;
    private Integer countJoin;
    private String dateAdd;
    private String dateUpdate;
    private String dateLeave;
    private String dateJoin;
    private Map<String, Object> additionalProperties = new HashMap<String, Object>();

    public Integer getUserId() {
        return userId;
    }

    public void setUserId(Integer userId) {
        this.userId = userId;
    }

    public Integer getTeamId() {
        return teamId;
    }

    public void setTeamId(Integer teamId) {
        this.teamId = teamId;
    }

    public Integer getEventId() {
        return eventId;
    }

    public void setEventId(Integer eventId) {
        this.eventId = eventId;
    }

    public Integer getRank() {
        return rank;
    }

    public void setRank(Integer rank) {
        this.rank = rank;
    }

    public Boolean getIsSentEmail() {
        return isSentEmail;
    }

    public void setIsSentEmail(Boolean isSentEmail) {
        this.isSentEmail = isSentEmail;
    }

    public Boolean getIsBanned() {
        return isBanned;
    }

    public void setIsBanned(Boolean isBanned) {
        this.isBanned = isBanned;
    }

    public Boolean getIsActive() {
        return isActive;
    }

    public void setIsActive(Boolean isActive) {
        this.isActive = isActive;
    }

    public Integer getCountJoin() {
        return countJoin;
    }

    public void setCountJoin(Integer countJoin) {
        this.countJoin = countJoin;
    }

    public String getDateAdd() {
        return dateAdd;
    }

    public void setDateAdd(String dateAdd) {
        this.dateAdd = dateAdd;
    }

    public String getDateUpdate() {
        return dateUpdate;
    }

    public void setDateUpdate(String dateUpdate) {
        this.dateUpdate = dateUpdate;
    }

    public String getDateLeave() {
        return dateLeave;
    }

    public void setDateLeave(String dateLeave) {
        this.dateLeave = dateLeave;
    }

    public String getDateJoin() {
        return dateJoin;
    }

    public void setDateJoin(String dateJoin) {
        this.dateJoin = dateJoin;
    }

    public Map<String, Object> getAdditionalProperties() {
        return this.additionalProperties;
    }

    public void setAdditionalProperty(String name, Object value) {
        this.additionalProperties.put(name, value);
    }

}
