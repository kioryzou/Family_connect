const express = require('express');
const { MongoClient } = require('mongodb');


const app = express();
const port = 3000;

const uri = 'mongodb://localhost:27017';
const client = new MongoClient(uri);

async function main() {
  await client.connect();
  const db = client.db('FamilyConnect'); // Cambia por tu base de datos
  const collection = db.collection('visitas'); // Cambia por tu colección

app.get('/visitas', async (req, res) => {
  try {
    const visitas = await collection.find({}).toArray();
    console.log('Visitas encontradas:', visitas.length);
    console.log(visitas);
    res.json(visitas);
  } catch (error) {
    console.error(error);
    res.status(500).send('Error al obtener visitas');
  }
});

  app.listen(port, () => {
    console.log(`Servidor escuchando en http://localhost:${port}`);
  });
}

main().catch(console.error);
