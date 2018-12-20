require('dotenv').config();

const express = require('express');
const request = require('request');
const fs = require('fs');

const API_KEY = process.env.API_KEY;
const ACCESS_TOKEN = process.env.ACCESS_TOKEN;

let svpa = {
    getAllPhotos: function (callback) {
        let photosInfo =  request({
            method: 'GET',
            url: 'https://streetviewpublish.googleapis.com/v1/photos' + '?key=' + API_KEY,
        }, (e, response, body) => {
            if (e) {
                callback(e);
            }
            callback(body);
        }).auth(null, null, true, ACCESS_TOKEN);
    },
    getAPhotos: function (photoId) {
        request({
            method: 'GET',
            url: 'https://streetviewpublish.googleapis.com/v1/photo/' + photoId + '?key=' + API_KEY
        }, (e, response, body) => {
            if (e) {
                return e;
            }
            return body;
        }).auth(null, null, true, ACCESS_TOKEN);
    },
    uploadAPhoto: function (photoInfo) {
        request({
            method: 'POST',
            url: 'https://streetviewpublish.googleapis.com/v1/photo:startUpload' + API_KEY,
            headers: {
                'Content-Length': 0
            }
        }, (e, response, body) => {
            if (e) {
                return e;
            }
            // Zuragaa upload hii url irne
            const uploadUrl = JSON.parse(body).uploadUrl;

            // upload hiih url ruu zuragaa hiij ugnu
            fs.createReadStream('./images/room.jpg').pipe(request.post({
                url: uploadUrl
            }, (e, response, body) => {
                if (e) {
                    return e;
                }

                const updateInfo = {
                    method: 'POST',
                    url: 'https://streetviewpublish.googleapis.com/v1/photo' + '?key=' + API_KEY,
                    json: true,
                    body: {
                        uploadReference: {
                            uploadUrl: uploadUrl
                        },
                        pose: {
                            heading: photoInfo.heading,
                            latLngPair: {
                                latitude: photoInfo.latitude,
                                longitude: photoInfo.longitude
                            }
                        },
                        captureTime: {
                            seconds: photoInfo.captureSeconds
                        },
                    },
                };
                request(updateInfo, (e, response, body) => {
                    if (e) {
                        return e;
                    }
                    return body;
                }).auth(null, null, true, ACCESS_TOKEN);
            }).auth(null, null, true, ACCESS_TOKEN));
        }).auth(null, null, true, ACCESS_TOKEN);
    },
}

module.exports = svpa;