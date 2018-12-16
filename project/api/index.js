const express = require('express');
const request = require('request');

let api = express.Router();

// Options
const API_KEY = '?key=AIzaSyDzRNFAzXgtn-TlTjAwj9guLgHshytukpw';
const ACCESS_TOKEN = 'ya29.Glt0BixGQ8apKc0MbGqW6n3DsCJUNkYMciXxy9LK07CLdyOXb7ffeq16w1SNA8MWyXVHeGDI0PAX3FMRCGfkJV2yIOeRp3Lco8Pb85tbkpIvgLceHqN_jgD-DJkf';

// *Get all photo
const getPhotosURL = 'https://streetviewpublish.googleapis.com/v1/photos';
let getPhotosOption = {
    method: 'GET',
    url: getPhotosURL + API_KEY,
};

let uploadAPhotoOptions = [
    {
        method: 'POST',
        url: 'https://streetviewpublish.googleapis.com/v1/photo:startUpload' + API_KEY,
        headers: {
            'Content-Length': 0
        }
    }, {
        method: 'POST',
        url: 'https://streetviewpublish.googleapis.com/v1/photo:startUpload' + API_KEY,
        headers: {
            'Content-Length': 0
        }
    }, {

    }
];

// *Get a photo
const getAPhoto = 'https://streetviewpublish.googleapis.com/v1/photo/'
// # Upload Photo
// 1. Request an Upload URL

api.get('/get-photos', (req, res) => {
    // request(getPhotosURL, (e, response, body) => {
    //     if (e) {
    //         res.send(e);
    //     }
    //     console.log(body);
    //     res.send(response);
    // });
    request(getPhotosOption, (e, response, body) => {
        if (e) {
            res.send(e);
        }
        console.log(body);
        res.send(response);
    }).auth(null, null, true, ACCESS_TOKEN);
});


api.get('/upload-photo', (req, res) => {
    request(uploadAPhotoOptions[0], (e, response, body) => {
        if (e) {
            res.send(e);
        }
        const uploadUrl = JSON.parse(body).uploadUrl;
        console.log(uploadUrl);

        request.post({
            url: uploadUrl,
            headers: {
                'upload-file': 'https://photos.google.com/album/AF1QipMrpZHRcw9xQpk11IH2qOGXmRWFMMGoEzF-1MEk/photo/AF1QipN8MrutGS_pzBBI-VQDoa13YOqNq-1NBRITixIA'
            }
        }, (e, response, body) => {
            if (e) {
                res.send(e);
            }
            console.log(body);
            res.send(response);
        }).auth(null, null, true, ACCESS_TOKEN);

    }).auth(null, null, true, ACCESS_TOKEN);
});

module.exports = api;
// curl --request GET \
//     --url 'https://streetviewpublish.googleapis.com/v1/photos?key=AIzaSyDzRNFAzXgtn-TlTjAwj9guLgHshytukpw' \
//     --header 'authorization: Bearer ya29.GltyBn_C4zHtTb1jYFTl0ibPJLDi6dR2cI10Yl2sF1nHM93NDLsGWiC7kLFD6PpNGC0s0_zDqb6LAhasglA81AMQm07eBUejK3kEwkgjcTDfiH3MbKTIayBdbzxR'