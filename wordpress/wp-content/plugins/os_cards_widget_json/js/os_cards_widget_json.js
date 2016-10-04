/*jQuery(document).ready(function() {
	jQuery("a.readmore").on("click", function(e) {
		e.preventDefault();
		console.log("padipoaisd");
		var last = jQuery(".card-container:visible").last().attr("name");
		var n = last.replace("card_", "");
		console.log(n);
	});
});

$(document).ready(
	$("#mas").click(
		alert("Hello! I am an alert box!!")
		);
);*/
jQuery(document).on("click","#mas",function(){
	var tipo = jQuery(this).attr("tipo");
	var orden = jQuery(this).attr("orden");
	var path = "/wp-content/jsons/" + tipo + "/";
	jQuery.getJSON(  path + orden + "." + tipo + ".json", getIndice);

});

function getIndice(indice){
	var npv = parseInt(jQuery("#mas").attr("npv"));
	var npt = parseInt(jQuery("#mas").attr("npt"));
	var npc = parseInt(jQuery("#mas").attr("npc"));

	for (var i = npc - 1; i < npc + npv - 1; i++) {
		console.log(indice[i]);
		crearPost(indice[i]);
	}

	jQuery("#mas").attr("npc", npc + npv);
}

function crearPost(indice){
	var tipo = jQuery("#mas").attr("tipo");
	var orden = jQuery("#mas").attr("orden");
	var path = "/wp-content/jsons/" + tipo + "/";
	jQuery.getJSON(  path + indice + ".json", montarPost);
}

function montarPost(post){
	console.log(post);
	jQuery("#card-container").append(getPost(post));
}

function getPost(post){
	return '<div class="main-card-container col-xs-12 col-sm-4 noppading"> \
		                    <section class="container-fluid main-card"> \
		                        <header class="row header-container"> \
		                            <div class="image-container nopadding col-xs-12"> \
		                                <img class="img-responsive" src=" + post["urlImagen"] + " alt=""> \
		                            </div> \
		                            <div class="hidden-xs floating-text col-xs-9"> \
		                                <p class="date">" + post["fecha"] + "</p> \
		                                <h1>" + post["titulo"] + "</h1> \
		                            </div> \
		                        </header> \
		                        <div class="row data-container"> \
		                            <p class="nopadding col-xs-9 date"> " + post["fecha"] + " </p> \
		                            <h1 class="title nopadding col-xs-9">" + post["titulo"] + "</h1> \
		                            <p><?php echo $post_abstract; ?></p> \
		                            <a href="<?php echo $post_guid; ?>" class="hidden-xs readmore">"Leer más"</a> \
		                            <footer class="row"> \
		                            	<?php if ($post_abstract) : ?> \
			                                <div class="col-xs-2 col-lg-1"> \
			                                    <div class="card-icon"> \
			                                        <span class="icon bbva-icon-quote"></span> \
			                                        <div class="triangle triangle-up-left"></div> \
			                                        <div class="triangle triangle-down-right"></div> \
			                                    </div> \
			                                </div> \
		                                <?php endif; ?> \
		                                <?php if (false) :?> \
			                                <div class="col-xs-2 col-lg-1"> \
			                                    <div class="card-icon"> \
			                                        <span class="icon bbva-icon-audio"></span> \
			                                        <div class="triangle triangle-up-left"></div> \
			                                        <div class="triangle triangle-down-right"></div> \
			                                    </div> \
			                                </div> \
										<?php endif; ?> \
		                                <?php if ($pdf) : ?> \
			                                <div class="col-xs-2 col-lg-1"> \
			                                    <div class="card-icon"> \
			                                        <span class="icon bbva-icon-comments"></span> \
			                                        <div class="triangle triangle-up-left"></div> \
			                                        <div class="triangle triangle-down-right"></div> \
			                                    </div> \
			                                </div> \
		                                <?php endif; ?> \
		                            </footer> \
		                        </div> \
		                    </section> \
		                    </div>'
}