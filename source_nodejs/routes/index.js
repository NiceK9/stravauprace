var express = require('express');

var fs = require('fs');
var util = require('util');
var async = require('async');

var moment = require('moment');
var format = require('format-number');

var strava = require('strava-v3');

var router = express.Router();

/* GET home page. */
router.get('/', function(req, res, next) {

    fs.readFile("data/total_ranking.json", function(err, data){
        
        if (err){
            res.render('index', { title: 'VNG Level Up 12+1 - UPRACE', data: [] });
        }
        else{

            var persons = JSON.parse(data);

            for(var i=0;i<persons.length;i++)
            {
                if (persons[i].isspy)
                    continue;

                persons[i].rank = i+1;
                persons[i].isTop = i+1 <= 3;

                persons[i].gender = (persons[i].sex === 'F') ? "Nữ" : "Nam";
                persons[i].totalDistanceText = format()(persons[i].distance.toFixed(2), { noSeparator: false });

                persons[i].url = util.format("https://www.strava.com/athletes/%d", persons[i].id);
            }

            res.render('index', { title: 'VNG Level Up 12+1 - UPRACE', data: persons });
        }
    });
});

/* GET home page. */
router.get('/a', function(req, res, next) {

    var data = {
        dates: [],
        teams: []
    };

    for(var i=0;i<12;i++)
        data.dates.push(i);

    async.each(data.dates,
        function(item, callback){

            fs.readFile(util.format("data/a_day_%d.json", item + 1), function(err, content){

                if (err){
                    callback();
                }
                else{
                    var teams = JSON.parse(content);
                    for(var i=0;i<teams.length;i++)
                    {
                        var team = null;
                        for(var j=0;j<data.teams.length;j++)
                        {
                            if (data.teams[j].id === teams[i].id){
                                team = data.teams[j];
                                break;
                            }
                        }
                        
                        if (team == null || team === undefined){

                            team = {
                                id: teams[i].id,
                                name: teams[i].name
                            };

                            team.totals = [];
                            team.members = [];

                            team.picture = "";
                            team.profile = util.format("https://www.strava.com/clubs/%d", team.id);

                            for(var j=0;j<data.dates.length;j++){
                                team.totals.push({ number: 0, text: "--" });
                            }

                            for(var j=0;j<teams[i].athletes.length;j++){

                                if (teams[i].athletes[j].isspy)
                                    continue;

                                var totals = [];
                                for(var k=0;k<data.dates.length;k++)
                                    totals.push({ number: 0, text: "--" });

                                var member = {
                                    id: teams[i].athletes[j].id,
                                    name: teams[i].athletes[j].name,
                                    gender: ((teams[i].athletes[j].sex == "F") ? "Nữ" : "Nam"),
                                    picture: teams[i].athletes[j].profile_medium,
                                    profile: util.format("https://www.strava.com/athletes/%d", teams[i].athletes[j].id),
                                    distances: totals
                                };
                                
                                team.members.push(member);
                            }

                            data.teams.push(team);
                        }

                        if (team){

                            team.totals[item] = {
                                number: teams[i].totalDistance / 1000,
                                text: format()((teams[i].totalDistance / 1000).toFixed(2), { noSeparator: false })
                            };
                            
                            for(var j=0;j<team.members.length;j++){
                                for(var k=0;k<teams[i].athletes.length;k++){

                                    if (team.members[j].id == teams[i].athletes[k].id){
                                        team.members[j].distances[item] = {
                                            number: teams[i].athletes[k].distance,
                                            text: format()(teams[i].athletes[k].distance.toFixed(2), { noSeparator: false })
                                        }
                                    }
                                }
                            }
                        }
                    }

                    callback();
                }
            });
        },
        function(err){

            data.teams.forEach(function(item){

                for(var i=0;i<item.members.length;i++){

                    var total = 0;
                    for(var j=0;j<item.members[i].distances.length;j++)
                        total += item.members[i].distances[j].number;

                    item.members[i].rank = i+1;
                    item.members[i].totalDistance = {
                        number: total,
                        text: format()(total.toFixed(2), { noSeparator: false })
                    }
                }

                var total = 0;
                for(var i=0;i<item.totals.length;i++)
                    total += item.totals[i].number;

                item.totalDistance = {
                    number: total,
                    text: format()(total.toFixed(2), { noSeparator: false })
                };
            });

            data.teams.sort(function(a, b){
                return a.totalDistance < b.totalDistance;
            })

            for(var i=0;i<data.teams.length;i++){
                data.teams[i].rank = i+1;
                data.teams[i].isTop = i+1 <= 3;
            }

            res.render('index-team-a', { title: 'VNG Level Up 12+1 - UPRACE', data: data });
        }
    );
});

/* GET home page. */
router.get('/b', function(req, res, next) {

    var data = {
        dates: [],
        teams: []
    };

    for(var i=0;i<12;i++)
        data.dates.push(i);

    async.each(data.dates,
        function(item, callback){

            fs.readFile(util.format("data/b_day_%d.json", item + 1), function(err, content){

                if (err){
                    callback();
                }
                else{
                    var teams = JSON.parse(content);
                    for(var i=0;i<teams.length;i++)
                    {
                        var team = null;
                        for(var j=0;j<data.teams.length;j++)
                        {
                            if (data.teams[j].id === teams[i].id){
                                team = data.teams[j];
                                break;
                            }
                        }
                        
                        if (team == null || team === undefined){

                            team = {
                                id: teams[i].id,
                                name: teams[i].name
                            };

                            team.totals = [];
                            team.members = [];

                            team.picture = "";
                            team.profile = util.format("https://www.strava.com/clubs/%d", team.id);

                            for(var j=0;j<data.dates.length;j++){
                                team.totals.push({ number: 0, text: "--" });
                            }

                            for(var j=0;j<teams[i].athletes.length;j++){

                                if (teams[i].athletes[j].isspy)
                                    continue;

                                var totals = [];
                                for(var k=0;k<data.dates.length;k++)
                                    totals.push({ number: 0, text: "--" });

                                var member = {
                                    id: teams[i].athletes[j].id,
                                    name: teams[i].athletes[j].name,
                                    gender: ((teams[i].athletes[j].sex == "F") ? "Nữ" : "Nam"),
                                    picture: teams[i].athletes[j].profile_medium,
                                    profile: util.format("https://www.strava.com/athletes/%d", teams[i].athletes[j].id),
                                    distances: totals
                                };

                                team.members.push(member);
                            }

                            data.teams.push(team);
                        }

                        if (team){

                            team.totals[item] = {
                                number: teams[i].totalDistance / 1000,
                                text: format()((teams[i].totalDistance / 1000).toFixed(2), { noSeparator: false })
                            };
                            
                            for(var j=0;j<team.members.length;j++){
                                for(var k=0;k<teams[i].athletes.length;k++){

                                    if (team.members[j].id == teams[i].athletes[k].id){
                                        team.members[j].distances[item] = {
                                            number: teams[i].athletes[k].distance,
                                            text: format()(teams[i].athletes[k].distance.toFixed(2), { noSeparator: false })
                                        }
                                    }
                                }
                            }
                        }
                    }

                    callback();
                }
            });
        },
        function(err){

            data.teams.forEach(function(item){

                for(var i=0;i<item.members.length;i++){

                    var total = 0;
                    for(var j=0;j<item.members[i].distances.length;j++)
                        total += item.members[i].distances[j].number;

                    item.members[i].rank = i+1;
                    item.members[i].totalDistance = {
                        number: total,
                        text: format()(total.toFixed(2), { noSeparator: false })
                    }
                }

                var total = 0;
                for(var i=0;i<item.totals.length;i++)
                    total += item.totals[i].number;

                item.totalDistance = {
                    number: total,
                    text: format()(total.toFixed(2), { noSeparator: false })
                };
            });

            data.teams.sort(function(a, b){
                return a.totalDistance < b.totalDistance;
            })

            for(var i=0;i<data.teams.length;i++){
                data.teams[i].rank = i+1;
                data.teams[i].isTop = i+1 <= 3;
            }

            res.render('index-team-b', { title: 'VNG Level Up 12+1 - UPRACE', data: data });
        }
    );
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
