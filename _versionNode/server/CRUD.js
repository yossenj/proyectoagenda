module.exports.insertarRegistros = function(db, callback){
	let coleccion = db.collection("users")
	coleccion.insertMany([
		{nombre: "John", edad: 25, peso:100},
		{nombre: "Carl", edad: 20, peso:100},
		{nombre: "Steve", edad: 29, peso:100},
	], (err,result)=>{
		console.log("Resultados de insert: "+ result.toString())
	})
}
module.exports.eliminarRegistro = function(db,callback){
	let collection = db.collection("users")
	try{
		collection.deleteOne({edad: 20})
		console.log("Se elimino el registro correctamente")
	}catch(e){
		console.log("se genero un error: "+ e)
	}
}
module.exports.consultarYActualizar= function(db,callback){
	let collection = db.collection("users")
	collection.find().toArray((error,documents)=>{
		if(error)console.log(error)
		console.log(documents)
		callback()
	})
	try {
		collection.updateOne({name: "Steve"}, {$set: {peso: 100}})
		console.log("Se ha actualizado el registro correctamente")
	} catch(e) {
		console.log("Error actualizando el registro: "+e);
	}
	collection.find().toArray((error,documents)=>{
		if(error)console.log(error)
		console.log(documents)
		callback()
	})
}