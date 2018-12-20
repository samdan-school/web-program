require('dotenv').config();

const express = require('express');
const request = require('request');
const fs = require('fs');

const API_KEY = process.env.API_KEY;
const ACCESS_TOKEN = process.env.ACCESS_TOKEN;

let svpa = {
    /*
    getAllPhotos - Энэ функц нь хэрэглэгчийн оруулсан зураагуудын мэдээлэлийг харна.

    Params:
        callback function - энэ нь 3 аргументтэй
            1. Алдаа                - error
            2. Хариултийн объект    - request object 
            3. Хариултийн эх бие    - response body
     */
    getAllPhotos: function (callback) {
        let photosInfo = request({
            method: 'GET',
            url: 'https://streetviewpublish.googleapis.com/v1/photos' + '?key=' + API_KEY,
            'auth': {
                'bearer': ACCESS_TOKEN
            }
        }, (error, response, body) => {
            callback(error, response, body);
        });
    },
    /*
    getAPhotos - Энэ функц нь хэрэглэгчийн оруулсан photoId-тай зурагийн мэдээлэлийг авна.


    Params:
        photoId :   string   - Зурагийн дугаар
        callback:   function - энэ нь 3 аргументтэй
            1. Алдаа                - error
            2. Хариултийн объект    - request object 
            3. Хариултийн эх бие    - response body
     */
    getAPhoto: function (photoId, callback) {
        request({
            method: 'GET',
            url: 'https://streetviewpublish.googleapis.com/v1/photo/' + photoId + '?key=' + API_KEY,
            'auth': {
                'bearer': ACCESS_TOKEN
            }
        }, (error, response, body) => {
            callback(error, response, body);
        });
    },
    /*
    uploadAPhoto - Энэ функц нь хэрэглэгчийн оруулсан зурагыг Street View руу оруулна.


    Params:
        photoInfo   :   Object      - Зурагий талаарах мэдээлэл - үүнийг (https://developers.google.com/streetview/publish/reference/rest/v1/photo) дэлэгрэгүй харна уу.
        callback    :   function    - энэ нь 3 аргументтэй
            1. Алдаа                - error
            2. Хариултийн объект    - request object 
            3. Хариултийн эх бие    - response body
     */
    uploadAPhoto: function (photoInfo = {}, callback) {
        // Zaaval baih yctoa talbaruud
        const mustIncludePhotoInfo = ['photoPath', 'heading', 'latitude', 'longitude', 'captureTime'];
        // deereh talbar baigaa hesgiig shalgaj baina
        const missingInfo = mustIncludePhotoInfo.filter((info) => {
            return !(info in photoInfo);
        });

        // herev dutuu talbar n 0 ees ih ued aldaa butsaana
        if (missingInfo.length > 0) {
            const error = {
                'info': 'missing photo information!',
                'missing': missingInfo
            }
            callback(error, null, null);
        }
        // Zuragiin zamiin shalgaj baina
        if (!fs.existsSync(photoInfo.photoPath)) {
            callback('Photo path is wrong!', null, null);
        }

        request({
            method: 'POST',
            url: 'https://streetviewpublish.googleapis.com/v1/photo:startUpload?key=' + API_KEY,
            'auth': {
                'bearer': ACCESS_TOKEN
            },
            headers: {
                'Content-Length': 0
            },
        }, (error, response, body) => {
            if (error) {
                callback(error, response, body);
            }
            // Zuragaa upload hii url irne
            const uploadUrl = JSON.parse(body).uploadUrl;

            // upload hiih url ruu zuragaa hiij ugnu
            fs.createReadStream(photoInfo.photoPath).pipe(request.post({
                url: uploadUrl,
                'auth': {
                    'bearer': ACCESS_TOKEN
                }
            }, (error, response, body) => {
                if (error) {
                    callback(error, response, body);
                }

                const updateInfo = {
                    method: 'POST',
                    url: 'https://streetviewpublish.googleapis.com/v1/photo' + '?key=' + API_KEY,
                    json: true,
                    'auth': {
                        'bearer': ACCESS_TOKEN
                    },
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
                            seconds: photoInfo.captureTime
                        },
                    },
                };
                // amjilttai ued zuragiin id butsaana 
                request(updateInfo, (error, response, body) => {
                    callback(error, response, body);
                });
            }));
        });
    },
    /*
    updatePhotos - Энэ функц нь Street View-д байгаа зурагуудын мэдээлэлийг өөрчилнө.

    Params:
        photosUpdateInfo    :   Объектэн хүснэгт- Шинэчлэх зурагуудын мэдээлэл
        callback            :   function        - энэ нь 3 аргументтэй
            1. Алдаа                - error
            2. Хариултийн объект    - request object 
            3. Хариултийн эх бие    - response body
     */
    updatePhotos: function (photosUpdateInfo = [], callback) {
        request({
            method: 'POST',
            url: 'https://streetviewpublish.googleapis.com/v1/photos:batchUpdate' + '?key=' + API_KEY,
            'auth': {
                'bearer': ACCESS_TOKEN
            },
            json: true,
            body: {
                'updatePhotoRequests': photosUpdateInfo
            }
        }, (error, response, body) => {
            callback(error, response, body);
        });
    },
    /*
    deleteAPhoto - Энэ функц нь Street View-д байгаа зурагийг устгна.

    Params:
        photoId     :   string      - Зурагийн дугаар
        callback    :   function    - энэ нь 3 аргументтэй
            1. Алдаа                - error
            2. Хариултийн объект    - request object 
            3. Хариултийн эх бие    - response body
     */
    deleteAPhoto: function (photoId, callback) {
        request({
            method: 'DELETE',
            url: 'https://streetviewpublish.googleapis.com/v1/photo/' + photoId + '?key=' + API_KEY,
            'auth': {
                'bearer': ACCESS_TOKEN
            }
        }, (error, response, body) => {
            callback(error, response, body);
        });
    }
}

module.exports = svpa;