const express = require('express');
const bodyParser = require('body-parser');
const connectDB = require('./config/db');
const itemRoutes = require('./routes/itemRoutes');

const app = express();


connectDB();


app.use(bodyParser.json());


app.use('/api', itemRoutes);

const PORT = process.env.PORT || 5000;
app.listen(PORT, () => console.log(`Server running on port ${PORT}`));