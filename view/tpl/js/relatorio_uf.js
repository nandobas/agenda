$(function() {
	
	$.ajax({
	   type: 'GET',
	   url: "model/relatorio.php",
	   data: {info:'Rel_uf'},
	   success: function(msg)
	   {
			if(msg.success == true){
				notify(msg.mensagem);

				var idade_chart = Morris.Donut({
					element: 'hero-donut',
				data: msg.data,
					colors: ["#30a1ec", "#76bdee", "#c4dafe"],
					formatter: function (y) { return y + "%" }
				});
	
			}
			else{
				notify(msg.mensagem, 'error');
			}
		}
	 });

});