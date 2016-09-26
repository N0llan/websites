/*Daniel Jennebo

Programvaruteknik 2014
2016-01-24
Webbprogrammering DT058G*/

function suggest(str)
{
	url = "main.php?inmatat="+str;			//Skapar en url till phpscriptet och sätter inmatat variabel till inparametern 
	asyncRequest = new XMLHttpRequest();	//Skapar ett nytt objekt för att skicka och ta emot data 
	asyncRequest.addEventListener("readystatechange", processResponse, false);	//Lägger till en eventlistener
	asyncRequest.open("GET", url, true);	//Öppnar anslutning till php filen
	asyncRequest.send(null);				//Skickar ingenting
}

function processResponse()
{											//Om readystate ändras så sätter vi innerHTML (texten) i suggest (i htmlfilen)
											//Till det vi fått i svar, alltså förslagen.
	document.getElementById("suggest").innerHTML = this.responseText;
}
