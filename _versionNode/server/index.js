/*var MongoClient = require('mongodb').MongoClient

var url = 'mongodb://localhost/proyectoagenda'

var op = require('./CRUD.js')
MongoClient.connect(url, function(err, db){
	if(err)console.log(err)	
	console.log("La conexión se ejecuto correctamente")
	// op.insertarRegistros(db, (err,result)=>{
	// 	if(err)console.log("Error insertando los registros: "+ err.toString())	
	// 	console.log("La conexión se ejecuto correctamente")
	// })
	op.eliminarRegistro(db, (err,db)=>{
		if(err)console.log("Error eliminando los registros: "+ err.toString())	
		console.log("La conexión se ejecuto correctamente")
	})
	op.consultarYActualizar(db, (err,db)=>{
		if(err)console.log("Error insertando los registros: "+ err.toString())	
		console.log("La conexión se ejecuto correctamente")
	})
})*/
const http = require('http'),
	path = require('path'),
	Auth = require('./auth.js'),
	Routing = require('./rutas.js'),
	express = require('express'),
	bodyParser = require('body-parser'),
	mongoose = require('mongoose');

const PORT = 8082
const app = express()

const Server = http.createServer(app)

app.use(bodyParser.json())
app.use(bodyParser.urlencoded({extended: true}))

app.use(express.static('client'))

app.use('/users', Routing)
app.use('/login', Auth)
Server.listen(PORT, function(){
	console.log("Server id listening on port "+ PORT);
})