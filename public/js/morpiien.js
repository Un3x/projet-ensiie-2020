{
	// Récupère toutes les cases du morpion et leur applique un listener
	let morpiienContainer = document.getElementById('morpiien-container');
	let cells = morpiienContainer.getElementsByClassName('morpiien-cell-empty');
	for(let i = 0; i < cells.length; i++)
		cells[i].addEventListener('click', function(event){sendChoice(event.target.id)});
	
	// Envoie une requête http post au deuxième joueur
	let sendChoice = function(number)
	{
		// Création et envoi de la requête
		var request = new XMLHttpRequest();
		request.open('POST', "/morpiien?cell="+number, true);
		request.send();
		
		request.onreadystatechange = processRequest;
		
		// Regarde le résultat de la réponse
		function processRequest(e)
		{
			if (request.readyState == 4 && request.status == 200)
			{
				let response = JSON.parse(request.responseText);
				let error = document.getElementById('error');
				if (response['failure'])
				{
					error.style.display = 'block';
					error.innerHTML = 'Une erreur est survenue, la partie ne peut être finie.';
				}
				else if (response['valid_move'])
				{
					error.style.display = 'block';
					error.innerHTML = 'Vous ne pouvez pas jouer ici.';
				}
				else
				{
					let cell = document.getElementById(number);
					cell.classList.remove('morpiien-cell-empty');
					cell.classList.add('morpiien-cell-circle');
					//cell.removeEventListener('click', clickCellListener);
					
					error.style.display = 'none';
					if (response['finished'] != false)
					{
						let winDisplay = document.getElementById('victory');
						winDisplay.style.display = 'block';
						if (response['finished'] == 'No one')
							winDisplay.innerHTML = 'Personne n\'a gagné, égalité parfaite !';
						else
						{
							winDisplay.innerHTML = response['finished'] + ' a gagné !';
							if (response['finished'] != 'L\'IA')
							{
								let sound = new Audio();
								sound.src = "../sound/aplaude.wav";
								sound.play();
							}
						}
					}
					if (response['opponent'] != 'NO')
					{
						let oponentCell = document.getElementById(response['opponent']);
						oponentCell.classList.remove('morpiien-cell-empty');
						oponentCell.classList.add('morpiien-cell-cross');
					}
				}
			}
		}
	}
}
