// Libraries
const express = require('express');

// Variables
const app = express();
const port = 3000;

// Routes
const api = require('./api/index')

app.use('/api/', api);
app.get('/', (req, res) => {
    res.json('hello world')
});

app.listen(port, () => console.log(`Example app listening on port ${port}!`));