const Router = require('express').Router();

Router.get('all', function(req,res){
	Users.find({}).exec(function(err,docs){
		if(err)
		{
			res.status(500)
			res.json(err)
		}
		res.json(docs)
	})
})
Router.get('/:id', function(req,res){
	
})
Router.get('/new', function(req,res){
	let user = new Users({
		userId:Math.floor(Math.random()*50),
		nombres: req.body.nombre,
		apellidos: req.body.apellidos,
		edad: req.body.edad,
		sexo: req.body.sexo,
		estado: "Activo"
	})
	user.save(function(err){
		if(err)
		{
			res.status(500)
			res.json(error)
		}
		res.send("Registro guardado")
	})
})
Router.get('/delete/:id', function(req,res){
	
})
Router.get('/active/:id', function(req,res){
	
})
Router.get('/inactive/:id', function(req,res){
	
})
Router.get('/users', function(req,res){
	
})

module.exports = Router