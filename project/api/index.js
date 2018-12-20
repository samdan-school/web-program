const express = require('express');
const request = require('request');
const fs = require('fs');
const path = require('path');

const svpa = require('./function');

let api = express.Router();
// https://www.google.com/maps/@0,0,0a,90y,90t/data=!3m4!1e1!3m2!1sAF1QipMjhTEnSnmowCE2w7DUiJQSbxhxER2Y6-jfrJAR!2e10

// *Get a photo
const getAPhoto = 'https://streetviewpublish.googleapis.com/v1/photo/'
// # Upload Photo
// 1. Request an Upload URL

api.get('/get-photos', (req, res) => {
    svpa.getAllPhotos((error, response, body) => {
        if (error) {
            res.send(error);
        }
        res.setHeader('Content-Type', 'application/json');
        res.send(JSON.parse(body), null, 3);
    });
});

api.get('/get-photo', (req, res) => {
    const photoId = 'CAoSLEFGMVFpcE1WeXdPRFJpcjV3MXZtWVp0a1BrX3U5NFhfUm5uX1pVLXZDY2RH';
    svpa.getAPhoto(photoId, (error, response, body) => {
        if (error) {
            res.send(error);
        }
        res.setHeader('Content-Type', 'application/json');
        res.send(JSON.parse(body), null, 3);
    });
});

api.get('/upload-photo', (req, res) => {
    const photoInfos = [{
        photoPath: path.join(__dirname, '../' + 'images/', 'school_1.jpg'),
        heading: 0,
        latitude: 47.922778,
        longitude: 106.921056,
        captureTime: 1545325560
    }, {
        photoPath: path.join(__dirname, '../' + 'images/', 'school_2.jpg'),
        heading: 0,
        latitude: 47.922784,
        longitude: 106.920971,
        captureTime: 1545325560
    }];

    svpa.uploadAPhoto(photoInfos[1], (error, response, body) => {
        if (error) {
            res.send(error);
        }

        res.send(body);
    });
});

api.get('/update-photo', (req, res) => {
    const photosUpdateInfo = [{
        'photo': {
            'photoId': {
                'id': 'CAoSLEFGMVFpcE1WeXdPRFJpcjV3MXZtWVp0a1BrX3U5NFhfUm5uX1pVLXZDY2RH'
            },
            'connections': [
                {
                    'target': {
                        'id': 'CAoSLEFGMVFpcE81TXpzT210cGttblZFVW5GS1VkcFBtZDZuUk5RaWluX0lIRUhF'
                    }
                }
            ]
        },
        'updateMask': 'connections'
    }, {
        'photo': {
            'photoId': {
                'id': 'CAoSLEFGMVFpcE81TXpzT210cGttblZFVW5GS1VkcFBtZDZuUk5RaWluX0lIRUhF'
            },
            'connections': [
                {
                    'target': {
                        'id': 'CAoSLEFGMVFpcE1WeXdPRFJpcjV3MXZtWVp0a1BrX3U5NFhfUm5uX1pVLXZDY2RH'
                    }
                }
            ]
        },
        'updateMask': 'connections'
    }];

    svpa.updatePhotos(photosUpdateInfo, (error, response, body) => {
        if (error) {
            res.send(error);
        }

        res.send(body);
    });
});

api.get('/delete-photo', (req, res) => {
    const photoId = 'CAoSLEFGMVFpcFAxcUJlZUJ5aDR5T1U4ajJxVnBUQkhrVVRHeHV1NjJPNXhGT2du';
    svpa.deleteAPhoto(photoId, (error, response, body) => {
        if (error) {
            res.send(error);
        }
        res.setHeader('Content-Type', 'application/json');
        res.send(JSON.parse(body), null, 3);
    });
});

module.exports = api;