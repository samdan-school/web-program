const express = require('express');
const request = require('request');
const fs = require('fs');

const svpa = require('./function');

let api = express.Router();
// https://www.google.com/maps/@0,0,0a,90y,90t/data=!3m4!1e1!3m2!1sAF1QipMjhTEnSnmowCE2w7DUiJQSbxhxER2Y6-jfrJAR!2e10

// *Get a photo
const getAPhoto = 'https://streetviewpublish.googleapis.com/v1/photo/'
// # Upload Photo
// 1. Request an Upload URL

api.get('/get-photos', (req, res) => {
    svpa.getAllPhotos((api_response) => {
        res.setHeader('Content-Type', 'application/json');
        res.send(JSON.stringify(JSON.parse(api_response), null, 3));
    });
});


api.get('/upload-photo', (req, res) => {
});

module.exports = api;