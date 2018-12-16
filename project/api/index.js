const express = require('express');
const request = require('request');
const fs = require('fs');

let api = express.Router();
// https://www.google.com/maps/@0,0,0a,90y,90t/data=!3m4!1e1!3m2!1sAF1QipMjhTEnSnmowCE2w7DUiJQSbxhxER2Y6-jfrJAR!2e10
// Options
const API_KEY = '?key=AIzaSyDzRNFAzXgtn-TlTjAwj9guLgHshytukpw';
const ACCESS_TOKEN = 'ya29.Glt0Bq10-skD4-Xo0DbdhScTx8xejdZdkWpSkPHy9cGSTAy5-sJPNz-Vrf7G4O9E5aG91Q1qsnzonekLJsqe97VWHfbCFidk7TwcShcRvnhSwik0TRiFb0HrDY2q';

// *Get all photo
const getPhotosURL = 'https://streetviewpublish.googleapis.com/v1/photos';
let getPhotosOption = {
    method: 'GET',
    url: getPhotosURL + API_KEY,
};

let uploadAPhotoOptions = {
    method: 'POST',
    url: 'https://streetviewpublish.googleapis.com/v1/photo:startUpload' + API_KEY,
    headers: {
        'Content-Length': 0
    }
};

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
    request(uploadAPhotoOptions, (e, response, body) => {
        if (e) {
            res.send(e);
        }
        const uploadUrl = JSON.parse(body).uploadUrl;
        console.log(uploadUrl);

        fs.createReadStream('./images/room.jpg').pipe(request.post({
            url: uploadUrl,
            headers: {
            }
        }, (e, response, body) => {
            if (e) {
                res.send(e);
            }

            const updateInfo = {
                method: 'POST',
                url: 'https://streetviewpublish.googleapis.com/v1/photo' + API_KEY,
                json: true,
                body: {
                    uploadReference: {
                        uploadUrl: uploadUrl
                    },
                    pose: {
                        heading: 0,
                        latLngPair: {
                            latitude: 47.891451,
                            longitude: 106.896849
                        }
                    },
                    captureTime: {
                        seconds: 1544973844
                    },

                },
            };
            request(updateInfo, (e, response, body) => {
                if (e) {
                    res.send(e);
                }

                console.log(body);
                res.send(response);
            }).auth(null, null, true, ACCESS_TOKEN);
        }).auth(null, null, true, ACCESS_TOKEN));
    }).auth(null, null, true, ACCESS_TOKEN);
});

module.exports = api;