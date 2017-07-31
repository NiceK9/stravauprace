var moment = require('moment');
var format = require('format-number');
var duration = require('moment-duration-format');

var strava = require('strava-v3');
var async = require('async');

var config = {
    startDate: moment.parseZone('2017-08-10T00:00:00+07:00'),
    endDate: moment.parseZone('2017-08-21T23:59:59+07:00'),
    minDistance: 0,
    maxDistance: 999999,
    minPace: 9 * 60 + 59,
    maxPace: 5 * 60,
    topEventRank: 3,
    topTeamRank: 3
}

var teams = [
    { id: 298988 },
    { id: 298756 }
]

/*
var teams = [
    { id: 298988 },
    { id: 298756 },
    { id: 230974 },
    { id: 300878 }
]
*/

var uprace = {
    config: config,
    teams: teams
};

uprace.getTeamActivities = function (team, onFetched){

    if (team === undefined)
        return;

    var data = [];
    var page = [];

    var pageIndex = 1;
    var pageLength = 200;

    async.doUntil(function(callback){

        var params = { id: team.id, per_page: pageLength, page: pageIndex };
        strava.clubs.listActivities(params, function (error, payload, limits){

            if (error){
                callback(error, limits);
            }
            else
            {
                page = payload;
                pageIndex++;

                for(var i=0;i<page.length;i++)
                    data.push(page[i]);

                callback();
            }
        });
    }, function(){
        return page.length == 0;
    }, function(error, limits){
        onFetched(error, data, limits);
    });
};

uprace.updateTeam = function (team, data){

    if (team === undefined || data === undefined)
        return;
    
    team.name = data.name;
    team.profile = data.profile;
    team.description = data.description;
    team.memberCount = data.member_count;

    team.uri = data.url;
    team.url = "https://www.strava.com/clubs/" + data.url;
}

uprace.updateMembers = function (team, data){

    if (team === undefined || data === undefined)
        return;

    team.members = data;
    for(var i=0;i<data.length;i++)
    {
        team.members[i].rank = i+1;

        team.members[i].totalTime = 0;
        team.members[i].totalDistance = 0;

        team.members[i].fullName = team.members[i].firstname + " " + team.members[i].lastname;
        team.members[i].gender = (team.members[i].sex === 'F') ? "Nữ" : "Nam";
    }
}

uprace.updateActivities = function(team, data){

    if (team === undefined || team.members === undefined || data === undefined)
        return;

    team.totalTime = 0;    
    team.totalDistance = 0;

    for(var i=0;i<team.members.length;i++)
    {
        var time = 0;
        var distance = 0;

        var paceMaximum = 0;

        for(var j=0;j<data.length;j++)
        {
            // filter by id
            if (data[j].athlete.id !== team.members[i].id)
                continue;

            // filter by type
            if (data[j].type !== "Run")
                continue;

            // filter by time
            if (false)
                continue;

            // filter by min distance
            if (data[j].distance < config.minDistance || data[j].distance > config.maxDistance)
                continue;

            var paceAvgSecond = Math.floor(1000 / data[j].average_speed);
            var paceMaxSecond = Math.floor(1000 / data[j].max_speed);

            // filter by pace
            if (paceAvgSecond > config.paceMin || paceAvgSecond < config.paceMax)
                continue;

            if (paceMaxSecond > paceMaximum)
                paceMaximum = paceMaxSecond;

            // update for member

            distance += data[j].distance;
            time += data[j].moving_time;

            // Count workout

            if (team.members[i].workoutCount === undefined)
                team.members[i].workoutCount = 0;

            team.members[i].workoutCount++;
        }

        // sum up for member

        team.members[i].totalDistance = Math.round(distance, 1);
        team.members[i].totalDistanceText = format()(team.members[i].totalDistance, { noSeparator: false });

        team.members[i].totalTime = time;
        team.members[i].totalTimeText = moment.duration(time, "seconds").format("d [ngày] hh:mm:ss");

        var paceAverageSecond = 1000 * team.members[i].totalTime / team.members[i].totalDistance;
        var paceAverage = {
            min: Math.floor(paceAverageSecond / 60),
            sec: paceAverageSecond - Math.floor(paceAverageSecond / 60) * 60
        };

        var paceMax = {
            min: Math.floor(paceMaximum / 60),
            sec: paceMaximum - Math.floor(paceMaximum / 60) * 60
        };

        team.members[i].paceAverage = paceAverage;
        team.members[i].paceMax = paceMax;

        team.members[i].paceAverage.text = moment.duration(paceAverage.min * 60 + paceAverage.sec, "seconds").format("mm:ss");
        team.members[i].paceMax.text = moment.duration(paceMax.min * 60 + paceMax.sec, "seconds").format("mm:ss");

        // update for team

        team.totalTime += team.members[i].totalTime;
        team.totalDistance += team.members[i].totalDistance;
    }

    // sum up for team

    team.totalTimeText = moment.duration(team.totalTime, "seconds").format("dd [ngày] hh:mm:ss");
    team.totalDistanceText = format()(team.totalDistance, { noSeparator: false }) + " km";
}

uprace.rankingTeam = function(team){

    if (team === undefined || team.members === undefined)
        return;

    team.members.sort(function(lhs, rhs){

        if (lhs.totalDistance == rhs.totalDistance)
            return lhs.totalTime > rhs.totalTime;

        return (lhs.totalDistance < rhs.totalDistance)
    });

    for(var i=0;i<team.members.length;i++){

        team.members[i].rank = i+1;
        if (team.members[i].rank <= config.topTeamRank)
            team.members[i].isTop = true;
    }
};

uprace.rankingEvent = function(teams){

    if (teams === undefined)
        return;

    teams.sort(function(lhs, rhs){

        if (lhs.totalDistance == rhs.totalDistance)
            return lhs.totalTime > rhs.totalTime;

        return (lhs.totalDistance < rhs.totalDistance)
    });

    for(var i=0;i<teams.length;i++){

        teams[i].rank = i+1;
        if (teams[i].rank <= config.topEventRank)
            teams[i].isTop = true;
    }
};

module.exports = uprace;