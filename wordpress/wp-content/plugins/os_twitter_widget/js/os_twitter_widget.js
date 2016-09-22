jQuery(document).ready(function() {

	console.log("twitter");


	var url_twitter = 'http://dquteo8n8b00y.cloudfront.net/bbva-components/twitter/?project=irnbsadx&baseUri=statuses/user_timeline&count=3&user_id=775250916622602241';

	jQuery.get(url_twitter, function(d) {

		console.log("he hecho la llamada a twitter");
	
		if (d.code === 200 && d.data.length > 0) {

			jQuery('.row.tweets-container').html('');
	        
	        jQuery.each(d.data, function(i, result) {
	        	console.log(result);

	        	var nombre = result.user.name;
	        	var usuario = '@' + result.user.screen_name;
	        	var imagen = result.user.profile_image_url_https;
	        	var likes = result.favorite_count;
	        	var fecha = new Date(result.created_at);
	        	var texto = result.text;

	        	var meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

	        	fecha = fecha.getDate() + ' ' +  meses[fecha.getMonth()];
	        	fecha = fecha.toString();
	        	fecha = fecha.toLowerCase();
	        	
	        	texto = texto.replace(/#(\S*)/g,'<b>#$1</b>');
	        	texto = texto.replace(/@(\S*)/g,'<b>@$1</b>');
	        	texto = texto.replace(/http(\S*)/g,'<b>http$1</b>');

	        	jQuery('.row.tweets-container').append('<div class="col-xs-10 col-xs-offset-1 col-sm-offset-0 col-sm-4"> <section class="row tweet"> <div class="image-container nopadding col-xs-3"> <img src="' + imagen + '" alt=""> </div> <div class="data-container col-xs-9"> <div class="user-info"> <span class="user-name">' + nombre + '</span> <span class="account">' + usuario + '</span> </div> <p class="tweet-content mt-xxs mb-xxs"> ' + texto + ' </p> <div class="row statistics"> <div class="col-xs-2 col-sm-2 nopadding likes"> <span class="bbva-icon-favorite"></span> <span>' + likes + '</span> </div> <div class="col-xs-1 col-sm-2 nopadding share"> <span class="bbva-icon-share"></span> </div> <div class="col-xs-9 col-sm-8 nopadding date"> <span>' + fecha + '</span> </div> </div> </div> </section> </div>');

	        });
		
		} else {
			// No hay ninguna categoría relacionada
		}
	}, 'json');

});