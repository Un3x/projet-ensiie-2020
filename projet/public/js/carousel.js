
$(document).ready(function(){
    const indicatorsNav = document.querySelector('#carousel-indicators');
	const indicators = Array.from(indicatorsNav.children);
	const contentCarousel = document.querySelector('#carousel-inner');
	const slides = Array.from(contentCarousel.children);
	const nextButton = document.querySelector('#carousel-control-next-icon');
	const prevButton = document.querySelector('#carousel-control-prev-icon');


	const slideWidth = slides[0].getBoundingClientRect().width;
	indexImg = slides.length - 1; //Index maximal que peut prendre une slide


	currentIndex = 0;
	$(indicators[currentIndex]).addClass("active");
	$(slides[currentIndex]).css('display', 'block');

	$(nextButton).click(function(){ // image suivante

	    
	    $(slides[currentIndex]).css('display', 'none'); // on cache les images
	    $(indicators[currentIndex]).removeClass('active');
	    if(currentIndex < indexImg){ // si le compteur est inférieur au dernier index
		  	currentIndex++; // on incrémente le compteur
		}
		else{ // sinon, on le remet à 0 (première image)
		    currentIndex = 0;
		}

	    $(indicators[currentIndex]).addClass("active");
	    $(slides[currentIndex]).css('display', 'block'); // puis on l'affiche

	});

	$(prevButton).click(function(){ // image précédente

	    $(slides[currentIndex]).css('display', 'none');
	    $(indicators[currentIndex]).removeClass('active');
	     if( currentIndex > 0 ){
	     	currentIndex--; // on décrémente le compteur, puis on réalise la même chose que pour la fonction "suivante"
	     }
	     else{
	     	currentIndex=indexImg;
	     }
	    $(slides[currentIndex]).css('display', 'block');
	    $(indicators[currentIndex]).addClass("active");

	});

	indicators.forEach(function(indicator, index) {
  		indicator.addEventListener("click",function(){ // image précédente

		$(slides[currentIndex]).css('display', 'none');
		$(indicators[currentIndex]).removeClass('active');
		currentIndex=index;
		$(slides[currentIndex]).css('display', 'block');
		$(indicators[currentIndex]).addClass("active");

		});
	});
	

	function slideImg(){
	   setTimeout(function(){ // on utilise une fonction anonyme

	   	$(slides[currentIndex]).css('display', 'none');
	   	$(indicators[currentIndex]).removeClass('active');

		if(currentIndex < indexImg){ // si le compteur est inférieur au dernier index
		  	currentIndex++; // on l'incrémente
		}
		else{ // sinon, on le remet à 0 (première image)
		    currentIndex = 0;
		}



		$(slides[currentIndex]).css('display', 'block');
		$(indicators[currentIndex]).addClass("active");

		slideImg(); // on oublie pas de relancer la fonction à la fin

	    }, 7000); // on définit l'intervalle à 7000 millisecondes (7s)
	}

	slideImg(); // enfin, on lance la fonction une première fois


});
