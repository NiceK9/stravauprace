var express = require('express');

var strava = require('strava-v3');
var uprace = require('../logic/uprace');

var router = express.Router();

/* GET authorize. */
router.get('/', function(req, res, next) {

    var url = strava.oauth.getRequestAccessURL({ scope: "view_private" });
    res.redirect(301, url);
});

/* GET authorize token. */
router.get('/token_exchange', function(req, res, next) {

    if (req.query.error){
        res.redirect('/authorize/error');
    }
    else {

        strava.oauth.getToken(req.query.code,function(err, payload, limits) {

            if (err){
                res.redirect('/authorize/error');
            }
            else {

                console.log(payload.access_token);
                res.redirect('/authorize/success');
            }
        });
    }
});

/* GET authorize success. */
router.get('/success', function(req, res, next) {

    var result = {
        title: "Đăng ký thành công",
        message: "Xin chúc mừng! Bạn đã đăng ký thành công."
    };

    res.render('authorize', { title: 'VNG Level Up 12+1 - UPRACE', result: result });
});

/* GET authorize failed. */
router.get('/error', function(req, res, next) {

    var error = {
        title: "Lỗi đăng ký",
        message: "Có lỗi xảy ra trong quá trình đăng ký. Xin vui lòng thử lại sau."
    };

    res.render('authorize', { title: 'VNG Level Up 12+1 - UPRACE', error: error });
});

module.exports = router;