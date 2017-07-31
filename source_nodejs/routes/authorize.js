var express = require('express');
var strava = require('strava-v3');

var router = express.Router();

/* GET authorize. */
router.get('/', function(req, res, next) {

    var url = strava.oauth.getRequestAccessURL({ scope: "view_private" });
    res.redirect(301, url);
});

/* GET authorize token. */
router.get('/token_exchange', function(req, res, next) {

    if (req.query.error){

        var error = {
            title: "Lỗi đăng ký",
            message: "Có lỗi xảy ra trong quá trình đăng ký. Xin vui lòng thử lại sau."
        };

        res.render('error_authorize', { title: 'VNG Level Up 12+1 - UPRACE', error: error });
    }
    else {

        strava.oauth.getToken(req.query.code,function(err, payload, limits) {
            console.log(payload.access_token);
            res.render('index', { title: 'VNG Level Up 12+1 - UPRACE', data: [] });
        });
    }
});

module.exports = router;