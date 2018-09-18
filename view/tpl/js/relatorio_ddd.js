$(function() {	
	ddd_chart = Morris.Bar({
		element: 'hero-bar',
		data: [0,0],
		xkey: 'ddd',
		ykeys: ['registros'],
		labels: ['registros'],
		barRatio: 0.4,
		xLabelMargin: 10,
		hideHover: 'auto',
		barColors: ["#3d88ba"]
	});
	
	$.ajax({
	   type: 'GET',
	   url: "model/relatorio.php",
	   data: {info:'Rel_ddd'},
	   success: function(msg)
	   {
			if(msg.success == true){
				notify(msg.mensagem);
				ddd_chart.setData(msg.data);
			}
			else{
				notify(msg.mensagem, 'error');
			}
		}
	 });


});