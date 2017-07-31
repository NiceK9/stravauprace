var express = require('express');

var format = require('format-number');
var strava = require('strava-v3');
var moment = require('moment');

var uprace = require('../logic/uprace');

var router = express.Router();
var teams = uprace.teams;

/* GET home page. */
router.get('/', function(req, res, next) {

    uprace.waitCount = uprace.teams.length;

    for(var i=0;i<teams.length;i++){

        //console.log("- fetching info of team #" + teams[i].id);
        strava.clubs.get({ id: teams[i].id }, function(err, club, limits){

            if(!err)
            {
                //console.log("- fetching info of team #" + this.team.id + " SUCCESS");
                uprace.updateTeam(this.team, club);
            }
            else
            {
                console.log("- fetching info of team #" + this.team.id + " FAILED");
                console.log(err);
            }
        }.bind({ team : teams[i] }));

        //console.log("- fetching members for team #" + teams[i].id);
        var params = { id: teams[i].id, per_page: 200 };
        strava.clubs.listMembers(params, function(err, members, limits) {
            
            if(!err)
            {
                //console.log("- fetching members for team #" + this.team.id + " SUCCESS");
                //console.log("- team name = " + this.team.name);
                //console.log("- total members = " + members.length);

                //console.log("---- fetching activities for team #" + this.team.id);

                uprace.updateMembers(this.team, members);

                /*
                var params = { id: this.team.id, before: uprace.config.endDate, per_page: 200 };
                strava.clubs.listActivities(params, function(err, activities, limits){
                
                    if (!err)
                    {
                        //console.log("---- fetching activities for team #" + this.team.id + " SUCCESS");
                        //console.log("---- total activities : " + activities.length);

                        uprace.updateActivities(this.team, activities);
                        uprace.rankingTeam(this.team);

                        // check if this is the last callback

                        uprace.waitCount--;
                        if (uprace.waitCount <= 0)
                        {
                            uprace.rankingEvent(teams);
                            res.render('index', { title: 'VNG Level Up 12+1 - UPRACE', data: teams });
                        }
                    }
                    else
                    {
                        console.log("---- fetching activities for team #" + this.team.id + " FAILED");
                        console.log(err);

                        res.render('index', { title: 'VNG Level Up 12+1 - UPRACE', data: [] });
                    }
                }.bind({ team: this.team }));
                */

                uprace.getTeamActivities(this.team, function(error, data, limits){

                    if (!err)
                    {
                        console.log("---- fetching activities for team #" + this.team.id + " SUCCESS");
                        console.log("---- total activities = " + data.length);

                        uprace.updateActivities(this.team, data);
                        uprace.rankingTeam(this.team);

                        uprace.waitCount--;
                        if (uprace.waitCount <= 0)
                        {
                            uprace.rankingEvent(teams);
                            res.render('index', { title: 'VNG Level Up 12+1 - UPRACE', data: teams });
                        }
                    }
                    else
                    {
                        console.log("---- fetching activities for team #" + this.team.id + " FAILED");
                        console.log(err);

                        res.render('index', { title: 'VNG Level Up 12+1 - UPRACE', data: [] });
                    }
                }.bind({ team: this.team }));
            }
            else
            {
                console.log("- fetching members for team #" + this.team.id + " FAILED");
                console.log(err);

                res.render('index', { title: 'VNG Level Up 12+1 - UPRACE', data: [] });
            }
        }.bind({ team : teams[i] }));
    }
});

/* GET about. */
router.get('/about', function(req, res, next) {
    res.render('about', { title: 'VNG Level Up 12+1 - UPRACE' });
});

/* GET contact. */
router.get('/contact', function(req, res, next) {
    res.render('contact', { title: 'VNG Level Up 12+1 - UPRACE' });
});

module.exports = router;
