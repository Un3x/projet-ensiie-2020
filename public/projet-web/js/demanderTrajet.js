
let mymap; //variable pour la carte
let marqueur1,marqueur2; //variable pour les marqueurs


//On s'assure qe la page est chargée
window.onload = function(){
	mymap = L.map("carte").setView([48.852969,2.349903],11)
	L.tileLayer("https://maps.wikimedia.org/osm-intl/{z}/{x}/{y}.png",{
		attribution: "Carte fournie par Wikimedia",
		minZoom: 1,
		maxZoom: 20,
	}).addTo(mymap);
	
	//mymap.on("click", mapClickListen1);
	document.querySelector("#ville1").addEventListener("blur",getCity1);
	//mymap.on("click", mapClickListen2);
	document.querySelector("#ville2").addEventListener("blur",getCity2);

	
}

function mapClickListen1(event){
	//On récupère les coordonnées du clic
	let pos = event.latlng;

	//Ajout du marqueur
	addMarker1(pos);

	// On affiche les coordonnées dans le formulaire
	document.querySelector("#lat1").value = pos.lat;
	document.querySelector("#lon1").value = pos.lng;

}

function addMarker1(pos){
	//On vérifie si un marqueur existe
	if(marqueur1 != undefined){
		mymap.removeLayer(marqueur1);
	}
	marqueur1 = L.marker(pos, {
		//On déplace le marqueur
		draggable: true
	});

	//On écoute le glisser:déposer sur le marqueur
	marqueur1.on("dragend", function(e){
		pos = e.target.getLatLng();
		// On affiche les coordonnées dans le formulaire
		document.querySelector("#lat1").value = pos.lat;
		document.querySelector("#lon1").value = pos.lng;

	})

	marqueur1.addTo(mymap);
}


function getCity1(){
	//Pn fabrique l'adresse
	let adresse = document.querySelector("#adresse1").value +", " + document.querySelector("#cp1").value + " " + document.querySelector("#ville1").value;
	//On initialise une requête Ajax
	const xmlhttp = new XMLHttpRequest;

	xmlhttp.onreadystatechange = () => {
		// Si la requête est terminée
		if (xmlhttp.readyState ==4){
			//si on a une réponse
			if(xmlhttp.status == 200){
				//On récupère la réponse
				let reponse = JSON.parse(xmlhttp.response);

				let lat = reponse[0]["lat"];
				let lon = reponse[0]["lon"];

				document.querySelector("#lat1").value = lat;
				document.querySelector("#lon1").value = lon;

				let pos = [lat,lon];
				addMarker1(pos);

				mymap.setView(pos,11);
			}
		}
	}

	//On ouvre la requête
	xmlhttp.open("get", `https://nominatim.openstreetmap.org/search?q=${adresse}&format=json&addressdetails=1&limit=1&polygon_svg=1`);

	xmlhttp.send();
}



function mapClickListen2(event){
	//On récupère les coordonnées du clic
	let pos = event.latlng;

	//Ajout du marqueur
	addMarker2(pos);

	// On affiche les coordonnées dans le formulaire
	document.querySelector("#lat2").value = pos.lat;
	document.querySelector("#lon2").value = pos.lng;

}

function addMarker2(pos){
	//On vérifie si un marqueur existe
	if(marqueur2 != undefined){
		mymap.removeLayer(marqueur2);
	}
	marqueur2 = L.marker(pos, {
		//On déplace le marqueur
		draggable: true 
	});

	//On écoute le glisser:déposer sur le marqueur
	marqueur2.on("dragend", function(e){
		pos = e.target.getLatLng();
		// On affiche les coordonnées dans le formulaire
		document.querySelector("#lat2").value = pos.lat;
		document.querySelector("#lon2").value = pos.lng;

	})

	marqueur2.addTo(mymap);
}


function getCity2(){
	//Pn fabrique l'adresse
	let adresse = document.querySelector("#adresse2").value +", " + document.querySelector("#cp2").value + " " + document.querySelector("#ville2").value;
	//On initialise une requête Ajax
	const xmlhttp = new XMLHttpRequest;

	xmlhttp.onreadystatechange = () => {
		// Si la requête est terminée
		if (xmlhttp.readyState ==4){
			//si on a une réponse
			if(xmlhttp.status == 200){
				//On récupère la réponse
				let reponse = JSON.parse(xmlhttp.response);

				let lat = reponse[0]["lat"];
				let lon = reponse[0]["lon"];

				document.querySelector("#lat2").value = lat;
				document.querySelector("#lon2").value = lon;

				let pos = [lat,lon];
				addMarker2(pos);

				mymap.setView(pos,5);
			}
		}
	}

	//On ouvre la requête
	xmlhttp.open("get", `https://nominatim.openstreetmap.org/search?q=${adresse}&format=json&addressdetails=1&limit=1&polygon_svg=1`);

	xmlhttp.send();
}

