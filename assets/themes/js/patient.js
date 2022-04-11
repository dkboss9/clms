	$(document).ready(function(){		
		$("#userform").validate();
		$('#mytests :input').attr('disabled', true);
		$("#regtype").change(function(){
			if($("#regtype").val()=='tests'){
				 $('#mytests :input').removeAttr('disabled');
			}else{
				 $('#mytests :input').attr('disabled', true);
			}
		});
	});
	function calculateTotal1(){
		var total; 
		var rate = $("#rate1").val();
		var qty = $("#qty1").val();
		total = rate * qty;
		var discount= $("#discount1").val();
		$("#total1").val(total);
		if(discount.indexOf("%") != -1){
			discount = discount.substr(0,discount.length -1);
			discount = total * parseFloat(discount/100);
		}else{
			discount = parseFloat(discount);	
		}
		if(discount>0){
			var dprice = total - discount;
			var gtotal=dprice.toFixed(2);
			$("#total_amt1").val(gtotal);
			$("#dis1").val(discount);
			var totaldis = parseFloat($("#dis1").val())+parseFloat($("#dis2").val())+parseFloat($("#dis3").val())+parseFloat($("#dis4").val())+parseFloat($("#dis5").val())+parseFloat($("#dis6").val())+parseFloat($("#dis7").val())+parseFloat($("#dis8").val())+parseFloat($("#dis9").val())+parseFloat($("#dis10").val())+parseFloat($("#dis11").val())+parseFloat($("#dis12").val())+parseFloat($("#dis13").val())+parseFloat($("#dis14").val())+parseFloat($("#dis15").val())+parseFloat($("#dis16").val());
			$("#disamt").val(totaldis);
			var totalamt = 	parseFloat($("#total1").val())+parseFloat($("#total2").val())+parseFloat($("#total3").val())+parseFloat($("#total4").val())+parseFloat($("#total5").val())+parseFloat($("#total6").val())+parseFloat($("#total7").val())+parseFloat($("#total8").val())+parseFloat($("#total9").val())+parseFloat($("#total10").val())+parseFloat($("#total11").val())+parseFloat($("#total12").val())+parseFloat($("#total13").val())+parseFloat($("#total14").val())+parseFloat($("#total15").val())+parseFloat($("#total16").val());	
			$("#total_amt").val(totalamt);	
			var paid_amt = parseFloat(totalamt) - parseFloat(totaldis);
			$("#paid_amt").val(paid_amt);						
		}else{
			$("#total_amt1").val(total);
			var totalamt = 	parseFloat($("#total1").val())+parseFloat($("#total2").val())+parseFloat($("#total3").val())+parseFloat($("#total4").val())+parseFloat($("#total5").val())+parseFloat($("#total6").val())+parseFloat($("#total7").val())+parseFloat($("#total8").val())+parseFloat($("#total9").val())+parseFloat($("#total10").val())+parseFloat($("#total11").val())+parseFloat($("#total12").val())+parseFloat($("#total13").val())+parseFloat($("#total14").val())+parseFloat($("#total15").val())+parseFloat($("#total16").val());	
			$("#total_amt").val(totalamt);
			$("#paid_amt").val(totalamt);	
		}
	}
	function calculateTotal2(){
		var total; 
		var rate = $("#rate2").val();
		var qty = $("#qty2").val();
		total = rate * qty;
		$("#total2").val(total);
		var discount= $("#discount2").val();
		if(discount.indexOf("%") != -1){
			discount = discount.substr(0,discount.length -1);
			discount = total * parseFloat(discount/100);
		}else{
			discount = parseFloat(discount);	
		}
		if(discount>0){
			var dprice = total - discount;
			var gtotal=dprice.toFixed(2);
			$("#total_amt2").val(gtotal);
			$("#dis2").val(discount);		
			var totaldis = parseFloat($("#dis1").val())+parseFloat($("#dis2").val())+parseFloat($("#dis3").val())+parseFloat($("#dis4").val())+parseFloat($("#dis5").val())+parseFloat($("#dis6").val())+parseFloat($("#dis7").val())+parseFloat($("#dis8").val())+parseFloat($("#dis9").val())+parseFloat($("#dis10").val())+parseFloat($("#dis11").val())+parseFloat($("#dis12").val())+parseFloat($("#dis13").val())+parseFloat($("#dis14").val())+parseFloat($("#dis15").val())+parseFloat($("#dis16").val());
			$("#disamt").val(totaldis);
			var totalamt = 	parseFloat($("#total1").val())+parseFloat($("#total2").val())+parseFloat($("#total3").val())+parseFloat($("#total4").val())+parseFloat($("#total5").val())+parseFloat($("#total6").val())+parseFloat($("#total7").val())+parseFloat($("#total8").val())+parseFloat($("#total9").val())+parseFloat($("#total10").val())+parseFloat($("#total11").val())+parseFloat($("#total12").val())+parseFloat($("#total13").val())+parseFloat($("#total14").val())+parseFloat($("#total15").val())+parseFloat($("#total16").val());	
			$("#total_amt").val(totalamt);	
			var paid_amt = parseFloat(totalamt) - parseFloat(totaldis);
			$("#paid_amt").val(paid_amt);				
		}else{
			$("#total_amt2").val(total);
			var totalamt = 	parseFloat($("#total1").val())+parseFloat($("#total2").val())+parseFloat($("#total3").val())+parseFloat($("#total4").val())+parseFloat($("#total5").val())+parseFloat($("#total6").val())+parseFloat($("#total7").val())+parseFloat($("#total8").val())+parseFloat($("#total9").val())+parseFloat($("#total10").val())+parseFloat($("#total11").val())+parseFloat($("#total12").val())+parseFloat($("#total13").val())+parseFloat($("#total14").val())+parseFloat($("#total15").val())+parseFloat($("#total16").val());	
			$("#total_amt").val(totalamt);
			$("#paid_amt").val(totalamt);			
		}
	}	
	function calculateTotal3(){
		var total; 
		var rate = $("#rate3").val();
		var qty = $("#qty3").val();
		total = rate * qty;
		$("#total3").val(total);
		var discount= $("#discount3").val();
		if(discount.indexOf("%") != -1){
			discount = discount.substr(0,discount.length -1);
			discount = total * parseFloat(discount/100);
		}else{
			discount = parseFloat(discount);	
		}
		if(discount>0){
			var dprice = total - discount;
			var gtotal=dprice.toFixed(2);
			$("#total_amt3").val(gtotal);
			$("#dis3").val(discount);		
			var totaldis = parseFloat($("#dis1").val())+parseFloat($("#dis2").val())+parseFloat($("#dis3").val())+parseFloat($("#dis4").val())+parseFloat($("#dis5").val())+parseFloat($("#dis6").val())+parseFloat($("#dis7").val())+parseFloat($("#dis8").val())+parseFloat($("#dis9").val())+parseFloat($("#dis10").val())+parseFloat($("#dis11").val())+parseFloat($("#dis12").val())+parseFloat($("#dis13").val())+parseFloat($("#dis14").val())+parseFloat($("#dis15").val())+parseFloat($("#dis16").val());
			$("#disamt").val(totaldis);		
			var totalamt = 	parseFloat($("#total1").val())+parseFloat($("#total2").val())+parseFloat($("#total3").val())+parseFloat($("#total4").val())+parseFloat($("#total5").val())+parseFloat($("#total6").val())+parseFloat($("#total7").val())+parseFloat($("#total8").val())+parseFloat($("#total9").val())+parseFloat($("#total10").val())+parseFloat($("#total11").val())+parseFloat($("#total12").val())+parseFloat($("#total13").val())+parseFloat($("#total14").val())+parseFloat($("#total15").val())+parseFloat($("#total16").val());	
			$("#total_amt").val(totalamt);
			var paid_amt = parseFloat(totalamt) - parseFloat(totaldis);
			$("#paid_amt").val(paid_amt);									
		}else{
			$("#total_amt3").val(total);
			var totalamt = 	parseFloat($("#total1").val())+parseFloat($("#total2").val())+parseFloat($("#total3").val())+parseFloat($("#total4").val())+parseFloat($("#total5").val())+parseFloat($("#total6").val())+parseFloat($("#total7").val())+parseFloat($("#total8").val())+parseFloat($("#total9").val())+parseFloat($("#total10").val())+parseFloat($("#total11").val())+parseFloat($("#total12").val())+parseFloat($("#total13").val())+parseFloat($("#total14").val())+parseFloat($("#total15").val())+parseFloat($("#total16").val());	
			$("#total_amt").val(totalamt);	
			$("#paid_amt").val(totalamt);		
		}
	}	
	function calculateTotal4(){
		var total; 
		var rate = $("#rate4").val();
		var qty = $("#qty4").val();
		total = rate * qty;
		$("#total4").val(total);
		var discount= $("#discount4").val();
		if(discount.indexOf("%") != -1){
			discount = discount.substr(0,discount.length -1);
			discount = total * parseFloat(discount/100);
		}else{
			discount = parseFloat(discount);	
		}
		if(discount>0){
			var dprice = total - discount;
			var gtotal=dprice.toFixed(2);
			$("#total_amt4").val(gtotal);
			$("#dis4").val(discount);		
			var totaldis = parseFloat($("#dis1").val())+parseFloat($("#dis2").val())+parseFloat($("#dis3").val())+parseFloat($("#dis4").val())+parseFloat($("#dis5").val())+parseFloat($("#dis6").val())+parseFloat($("#dis7").val())+parseFloat($("#dis8").val())+parseFloat($("#dis9").val())+parseFloat($("#dis10").val())+parseFloat($("#dis11").val())+parseFloat($("#dis12").val())+parseFloat($("#dis13").val())+parseFloat($("#dis14").val())+parseFloat($("#dis15").val())+parseFloat($("#dis16").val());
			$("#disamt").val(totaldis);	
			var totalamt = 	parseFloat($("#total1").val())+parseFloat($("#total2").val())+parseFloat($("#total3").val())+parseFloat($("#total4").val())+parseFloat($("#total5").val())+parseFloat($("#total6").val())+parseFloat($("#total7").val())+parseFloat($("#total8").val())+parseFloat($("#total9").val())+parseFloat($("#total10").val())+parseFloat($("#total11").val())+parseFloat($("#total12").val())+parseFloat($("#total13").val())+parseFloat($("#total14").val())+parseFloat($("#total15").val())+parseFloat($("#total16").val());	
			$("#total_amt").val(totalamt);		
			var paid_amt = parseFloat(totalamt) - parseFloat(totaldis);
			$("#paid_amt").val(paid_amt);								
		}else{
			$("#total_amt4").val(total);
			var totalamt = 	parseFloat($("#total1").val())+parseFloat($("#total2").val())+parseFloat($("#total3").val())+parseFloat($("#total4").val())+parseFloat($("#total5").val())+parseFloat($("#total6").val())+parseFloat($("#total7").val())+parseFloat($("#total8").val())+parseFloat($("#total9").val())+parseFloat($("#total10").val())+parseFloat($("#total11").val())+parseFloat($("#total12").val())+parseFloat($("#total13").val())+parseFloat($("#total14").val())+parseFloat($("#total15").val())+parseFloat($("#total16").val());	
			$("#total_amt").val(totalamt);
			$("#paid_amt").val(totalamt);			
		}
	}
	function calculateTotal5(){
		var total; 
		var rate = $("#rate5").val();
		var qty = $("#qty5").val();
		total = rate * qty;
		$("#total5").val(total);
		var discount= $("#discount5").val();
		if(discount.indexOf("%") != -1){
			discount = discount.substr(0,discount.length -1);
			discount = total * parseFloat(discount/100);
		}else{
			discount = parseFloat(discount);	
		}
		if(discount>0){
			var dprice = total - discount;
			var gtotal=dprice.toFixed(2);
			$("#total_amt5").val(gtotal);
			$("#dis5").val(discount);		
			var totaldis = parseFloat($("#dis1").val())+parseFloat($("#dis2").val())+parseFloat($("#dis3").val())+parseFloat($("#dis4").val())+parseFloat($("#dis5").val())+parseFloat($("#dis6").val())+parseFloat($("#dis7").val())+parseFloat($("#dis8").val())+parseFloat($("#dis9").val())+parseFloat($("#dis10").val())+parseFloat($("#dis11").val())+parseFloat($("#dis12").val())+parseFloat($("#dis13").val())+parseFloat($("#dis14").val())+parseFloat($("#dis15").val())+parseFloat($("#dis16").val());
			$("#disamt").val(totaldis);		
			var totalamt = 	parseFloat($("#total1").val())+parseFloat($("#total2").val())+parseFloat($("#total3").val())+parseFloat($("#total4").val())+parseFloat($("#total5").val())+parseFloat($("#total6").val())+parseFloat($("#total7").val())+parseFloat($("#total8").val())+parseFloat($("#total9").val())+parseFloat($("#total10").val())+parseFloat($("#total11").val())+parseFloat($("#total12").val())+parseFloat($("#total13").val())+parseFloat($("#total14").val())+parseFloat($("#total15").val())+parseFloat($("#total16").val());	
			$("#total_amt").val(totalamt);	
			var paid_amt = parseFloat(totalamt) - parseFloat(totaldis);
			$("#paid_amt").val(paid_amt);								
		}else{
			$("#total_amt5").val(total);
			var totalamt = 	parseFloat($("#total1").val())+parseFloat($("#total2").val())+parseFloat($("#total3").val())+parseFloat($("#total4").val())+parseFloat($("#total5").val())+parseFloat($("#total6").val())+parseFloat($("#total7").val())+parseFloat($("#total8").val())+parseFloat($("#total9").val())+parseFloat($("#total10").val())+parseFloat($("#total11").val())+parseFloat($("#total12").val())+parseFloat($("#total13").val())+parseFloat($("#total14").val())+parseFloat($("#total15").val())+parseFloat($("#total16").val());	
			$("#total_amt").val(totalamt);	
			$("#paid_amt").val(totalamt);		
		}
	}
	function calculateTotal6(){
		var total; 
		var rate = $("#rate6").val();
		var qty = $("#qty6").val();
		total = rate * qty;
		$("#total6").val(total);
		var discount= $("#discount6").val();
		if(discount.indexOf("%") != -1){
			discount = discount.substr(0,discount.length -1);
			discount = total * parseFloat(discount/100);
		}else{
			discount = parseFloat(discount);	
		}
		if(discount>0){
			var dprice = total - discount;
			var gtotal=dprice.toFixed(2);
			$("#total_amt6").val(gtotal);
			$("#dis6").val(discount);			
			var totaldis = parseFloat($("#dis1").val())+parseFloat($("#dis2").val())+parseFloat($("#dis3").val())+parseFloat($("#dis4").val())+parseFloat($("#dis5").val())+parseFloat($("#dis6").val())+parseFloat($("#dis7").val())+parseFloat($("#dis8").val())+parseFloat($("#dis9").val())+parseFloat($("#dis10").val())+parseFloat($("#dis11").val())+parseFloat($("#dis12").val())+parseFloat($("#dis13").val())+parseFloat($("#dis14").val())+parseFloat($("#dis15").val())+parseFloat($("#dis16").val());
			$("#disamt").val(totaldis);	
			var totalamt = 	parseFloat($("#total1").val())+parseFloat($("#total2").val())+parseFloat($("#total3").val())+parseFloat($("#total4").val())+parseFloat($("#total5").val())+parseFloat($("#total6").val())+parseFloat($("#total7").val())+parseFloat($("#total8").val())+parseFloat($("#total9").val())+parseFloat($("#total10").val())+parseFloat($("#total11").val())+parseFloat($("#total12").val())+parseFloat($("#total13").val())+parseFloat($("#total14").val())+parseFloat($("#total15").val())+parseFloat($("#total16").val());	
			$("#total_amt").val(totalamt);
			var paid_amt = parseFloat(totalamt) - parseFloat(totaldis);
			$("#paid_amt").val(paid_amt);										
		}else{
			$("#total_amt6").val(total);
			var totalamt = 	parseFloat($("#total1").val())+parseFloat($("#total2").val())+parseFloat($("#total3").val())+parseFloat($("#total4").val())+parseFloat($("#total5").val())+parseFloat($("#total6").val())+parseFloat($("#total7").val())+parseFloat($("#total8").val())+parseFloat($("#total9").val())+parseFloat($("#total10").val())+parseFloat($("#total11").val())+parseFloat($("#total12").val())+parseFloat($("#total13").val())+parseFloat($("#total14").val())+parseFloat($("#total15").val())+parseFloat($("#total16").val());	
			$("#total_amt").val(totalamt);
			$("#paid_amt").val(totalamt);			
		}
	}
	function calculateTotal7(){
		var total; 
		var rate = $("#rate7").val();
		var qty = $("#qty7").val();
		total = rate * qty;
		$("#total7").val(total);
		var discount= $("#discount7").val();
		if(discount.indexOf("%") != -1){
			discount = discount.substr(0,discount.length -1);
			discount = total * parseFloat(discount/100);
		}else{
			discount = parseFloat(discount);	
		}
		if(discount>0){
			var dprice = total - discount;
			var gtotal=dprice.toFixed(2);
			$("#total_amt7").val(gtotal);
			$("#dis7").val(discount);		
			var totaldis = parseFloat($("#dis1").val())+parseFloat($("#dis2").val())+parseFloat($("#dis3").val())+parseFloat($("#dis4").val())+parseFloat($("#dis5").val())+parseFloat($("#dis6").val())+parseFloat($("#dis7").val())+parseFloat($("#dis8").val())+parseFloat($("#dis9").val())+parseFloat($("#dis10").val())+parseFloat($("#dis11").val())+parseFloat($("#dis12").val())+parseFloat($("#dis13").val())+parseFloat($("#dis14").val())+parseFloat($("#dis15").val())+parseFloat($("#dis16").val());
			$("#disamt").val(totaldis);			
			var totalamt = 	parseFloat($("#total1").val())+parseFloat($("#total2").val())+parseFloat($("#total3").val())+parseFloat($("#total4").val())+parseFloat($("#total5").val())+parseFloat($("#total6").val())+parseFloat($("#total7").val())+parseFloat($("#total8").val())+parseFloat($("#total9").val())+parseFloat($("#total10").val())+parseFloat($("#total11").val())+parseFloat($("#total12").val())+parseFloat($("#total13").val())+parseFloat($("#total14").val())+parseFloat($("#total15").val())+parseFloat($("#total16").val());	
			$("#total_amt").val(totalamt);				
			var paid_amt = parseFloat(totalamt) - parseFloat(totaldis);
			$("#paid_amt").val(paid_amt);		
		}else{
			$("#total_amt7").val(total);
			var totalamt = 	parseFloat($("#total1").val())+parseFloat($("#total2").val())+parseFloat($("#total3").val())+parseFloat($("#total4").val())+parseFloat($("#total5").val())+parseFloat($("#total6").val())+parseFloat($("#total7").val())+parseFloat($("#total8").val())+parseFloat($("#total9").val())+parseFloat($("#total10").val())+parseFloat($("#total11").val())+parseFloat($("#total12").val())+parseFloat($("#total13").val())+parseFloat($("#total14").val())+parseFloat($("#total15").val())+parseFloat($("#total16").val());	
			$("#total_amt").val(totalamt);	
			$("#paid_amt").val(totalamt);		
		}
	}
	function calculateTotal8(){
		var total; 
		var rate = $("#rate8").val();
		var qty = $("#qty8").val();
		total = rate * qty;
		$("#total8").val(total);
		var discount= $("#discount1").val();
		if(discount.indexOf("%") != -1){
			discount = discount.substr(0,discount.length -1);
			discount = total * parseFloat(discount/100);
		}else{
			discount = parseFloat(discount);	
		}
		if(discount>0){
			var dprice = total - discount;
			var gtotal=dprice.toFixed(2);
			$("#total_amt8").val(gtotal);
			$("#dis8").val(discount);			
			var totaldis = parseFloat($("#dis1").val())+parseFloat($("#dis2").val())+parseFloat($("#dis3").val())+parseFloat($("#dis4").val())+parseFloat($("#dis5").val())+parseFloat($("#dis6").val())+parseFloat($("#dis7").val())+parseFloat($("#dis8").val())+parseFloat($("#dis9").val())+parseFloat($("#dis10").val())+parseFloat($("#dis11").val())+parseFloat($("#dis12").val())+parseFloat($("#dis13").val())+parseFloat($("#dis14").val())+parseFloat($("#dis15").val())+parseFloat($("#dis16").val());
			$("#disamt").val(totaldis);
			var totalamt = 	parseFloat($("#total1").val())+parseFloat($("#total2").val())+parseFloat($("#total3").val())+parseFloat($("#total4").val())+parseFloat($("#total5").val())+parseFloat($("#total6").val())+parseFloat($("#total7").val())+parseFloat($("#total8").val())+parseFloat($("#total9").val())+parseFloat($("#total10").val())+parseFloat($("#total11").val())+parseFloat($("#total12").val())+parseFloat($("#total13").val())+parseFloat($("#total14").val())+parseFloat($("#total15").val())+parseFloat($("#total16").val());	
			$("#total_amt").val(totalamt);		
			var paid_amt = parseFloat(totalamt) - parseFloat(totaldis);
			$("#paid_amt").val(paid_amt);		
		}else{
			$("#total_amt8").val(total);
			var totalamt = 	parseFloat($("#total1").val())+parseFloat($("#total2").val())+parseFloat($("#total3").val())+parseFloat($("#total4").val())+parseFloat($("#total5").val())+parseFloat($("#total6").val())+parseFloat($("#total7").val())+parseFloat($("#total8").val())+parseFloat($("#total9").val())+parseFloat($("#total10").val())+parseFloat($("#total11").val())+parseFloat($("#total12").val())+parseFloat($("#total13").val())+parseFloat($("#total14").val())+parseFloat($("#total15").val())+parseFloat($("#total16").val());	
			$("#total_amt").val(totalamt);
			$("#paid_amt").val(totalamt);			
		}
	}
	function calculateTotal9(){
		var total; 
		var rate = $("#rate9").val();
		var qty = $("#qty9").val();
		total = rate * qty;
		$("#total9").val(total);
		var discount= $("#discount9").val();
		if(discount.indexOf("%") != -1){
			discount = discount.substr(0,discount.length -1);
			discount = total * parseFloat(discount/100);
		}else{
			discount = parseFloat(discount);	
		}
		if(discount>0){
			var dprice = total - discount;
			var gtotal=dprice.toFixed(2);
			$("#total_amt9").val(gtotal);
			$("#dis9").val(discount);		
			var totaldis = parseFloat($("#dis1").val())+parseFloat($("#dis2").val())+parseFloat($("#dis3").val())+parseFloat($("#dis4").val())+parseFloat($("#dis5").val())+parseFloat($("#dis6").val())+parseFloat($("#dis7").val())+parseFloat($("#dis8").val())+parseFloat($("#dis9").val())+parseFloat($("#dis10").val())+parseFloat($("#dis11").val())+parseFloat($("#dis12").val())+parseFloat($("#dis13").val())+parseFloat($("#dis14").val())+parseFloat($("#dis15").val())+parseFloat($("#dis16").val());
			$("#disamt").val(totaldis);
			var totalamt = 	parseFloat($("#total1").val())+parseFloat($("#total2").val())+parseFloat($("#total3").val())+parseFloat($("#total4").val())+parseFloat($("#total5").val())+parseFloat($("#total6").val())+parseFloat($("#total7").val())+parseFloat($("#total8").val())+parseFloat($("#total9").val())+parseFloat($("#total10").val())+parseFloat($("#total11").val())+parseFloat($("#total12").val())+parseFloat($("#total13").val())+parseFloat($("#total14").val())+parseFloat($("#total15").val())+parseFloat($("#total16").val());	
			$("#total_amt").val(totalamt);	
			var paid_amt = parseFloat(totalamt) - parseFloat(totaldis);
			$("#paid_amt").val(paid_amt);			
		}else{
			$("#total_amt9").val(total);
			var totalamt = 	parseFloat($("#total1").val())+parseFloat($("#total2").val())+parseFloat($("#total3").val())+parseFloat($("#total4").val())+parseFloat($("#total5").val())+parseFloat($("#total6").val())+parseFloat($("#total7").val())+parseFloat($("#total8").val())+parseFloat($("#total9").val())+parseFloat($("#total10").val())+parseFloat($("#total11").val())+parseFloat($("#total12").val())+parseFloat($("#total13").val())+parseFloat($("#total14").val())+parseFloat($("#total15").val())+parseFloat($("#total16").val());	
			$("#total_amt").val(totalamt);	
			$("#paid_amt").val(totalamt);		
		}
	}
	function calculateTotal10(){
		var total; 
		var rate = $("#rate10").val();
		var qty = $("#qty10").val();
		total = rate * qty;
		$("#total10").val(total);
		var discount= $("#discount10").val();
		if(discount.indexOf("%") != -1){
			discount = discount.substr(0,discount.length -1);
			discount = total * parseFloat(discount/100);
		}else{
			discount = parseFloat(discount);	
		}
		if(discount>0){
			var dprice = total - discount;
			var gtotal=dprice.toFixed(2);
			$("#total_amt10").val(gtotal);
			$("#dis10").val(discount);		
			var totaldis = parseFloat($("#dis1").val())+parseFloat($("#dis2").val())+parseFloat($("#dis3").val())+parseFloat($("#dis4").val())+parseFloat($("#dis5").val())+parseFloat($("#dis6").val())+parseFloat($("#dis7").val())+parseFloat($("#dis8").val())+parseFloat($("#dis9").val())+parseFloat($("#dis10").val())+parseFloat($("#dis11").val())+parseFloat($("#dis12").val())+parseFloat($("#dis13").val())+parseFloat($("#dis14").val())+parseFloat($("#dis15").val())+parseFloat($("#dis16").val());
			$("#disamt").val(totaldis);
			var totalamt = 	parseFloat($("#total1").val())+parseFloat($("#total2").val())+parseFloat($("#total3").val())+parseFloat($("#total4").val())+parseFloat($("#total5").val())+parseFloat($("#total6").val())+parseFloat($("#total7").val())+parseFloat($("#total8").val())+parseFloat($("#total9").val())+parseFloat($("#total10").val())+parseFloat($("#total11").val())+parseFloat($("#total12").val())+parseFloat($("#total13").val())+parseFloat($("#total14").val())+parseFloat($("#total15").val())+parseFloat($("#total16").val());	
			$("#total_amt").val(totalamt);	
			var paid_amt = parseFloat(totalamt) - parseFloat(totaldis);
			$("#paid_amt").val(paid_amt);	
		}else{
			$("#total_amt10").val(total);
			var totalamt = 	parseFloat($("#total1").val())+parseFloat($("#total2").val())+parseFloat($("#total3").val())+parseFloat($("#total4").val())+parseFloat($("#total5").val())+parseFloat($("#total6").val())+parseFloat($("#total7").val())+parseFloat($("#total8").val())+parseFloat($("#total9").val())+parseFloat($("#total10").val())+parseFloat($("#total11").val())+parseFloat($("#total12").val())+parseFloat($("#total13").val())+parseFloat($("#total14").val())+parseFloat($("#total15").val())+parseFloat($("#total16").val());	
			$("#total_amt").val(totalamt);	
			$("#paid_amt").val(totalamt);		
		}
	}
	function calculateTotal11(){
		var total; 
		var rate = $("#rate11").val();
		var qty = $("#qty11").val();
		total = rate * qty;
		$("#total11").val(total);
		var discount= $("#discount11").val();
		if(discount.indexOf("%") != -1){
			discount = discount.substr(0,discount.length -1);
			discount = total * parseFloat(discount/100);
		}else{
			discount = parseFloat(discount);	
		}
		if(discount>0){
			var dprice = total - discount;
			var gtotal=dprice.toFixed(2);
			$("#total_amt11").val(gtotal);
			$("#dis11").val(discount);		
			var totaldis = parseFloat($("#dis1").val())+parseFloat($("#dis2").val())+parseFloat($("#dis3").val())+parseFloat($("#dis4").val())+parseFloat($("#dis5").val())+parseFloat($("#dis6").val())+parseFloat($("#dis7").val())+parseFloat($("#dis8").val())+parseFloat($("#dis9").val())+parseFloat($("#dis10").val())+parseFloat($("#dis11").val())+parseFloat($("#dis12").val())+parseFloat($("#dis13").val())+parseFloat($("#dis14").val())+parseFloat($("#dis15").val())+parseFloat($("#dis16").val());
			$("#disamt").val(totaldis);
			var totalamt = 	parseFloat($("#total1").val())+parseFloat($("#total2").val())+parseFloat($("#total3").val())+parseFloat($("#total4").val())+parseFloat($("#total5").val())+parseFloat($("#total6").val())+parseFloat($("#total7").val())+parseFloat($("#total8").val())+parseFloat($("#total9").val())+parseFloat($("#total10").val())+parseFloat($("#total11").val())+parseFloat($("#total12").val())+parseFloat($("#total13").val())+parseFloat($("#total14").val())+parseFloat($("#total15").val())+parseFloat($("#total16").val());	
			$("#total_amt").val(totalamt);	
			var paid_amt = parseFloat(totalamt) - parseFloat(totaldis);
			$("#paid_amt").val(paid_amt);	
		}else{
			$("#total_amt11").val(total);
			var totalamt = 	parseFloat($("#total1").val())+parseFloat($("#total2").val())+parseFloat($("#total3").val())+parseFloat($("#total4").val())+parseFloat($("#total5").val())+parseFloat($("#total6").val())+parseFloat($("#total7").val())+parseFloat($("#total8").val())+parseFloat($("#total9").val())+parseFloat($("#total10").val())+parseFloat($("#total11").val())+parseFloat($("#total12").val())+parseFloat($("#total13").val())+parseFloat($("#total14").val())+parseFloat($("#total15").val())+parseFloat($("#total16").val());	
			$("#total_amt").val(totalamt);	
			$("#paid_amt").val(totalamt);		
		}
	}
	function calculateTotal12(){
		var total; 
		var rate = $("#rate12").val();
		var qty = $("#qty12").val();
		total = rate * qty;
		$("#total12").val(total);
		var discount= $("#discount12").val();
		if(discount.indexOf("%") != -1){
			discount = discount.substr(0,discount.length -1);
			discount = total * parseFloat(discount/100);
		}else{
			discount = parseFloat(discount);	
		}
		if(discount>0){
			var dprice = total - discount;
			var gtotal=dprice.toFixed(2);
			$("#total_amt12").val(gtotal);
			$("#dis12").val(discount);		
			var totaldis = parseFloat($("#dis1").val())+parseFloat($("#dis2").val())+parseFloat($("#dis3").val())+parseFloat($("#dis4").val())+parseFloat($("#dis5").val())+parseFloat($("#dis6").val())+parseFloat($("#dis7").val())+parseFloat($("#dis8").val())+parseFloat($("#dis9").val())+parseFloat($("#dis10").val())+parseFloat($("#dis11").val())+parseFloat($("#dis12").val())+parseFloat($("#dis13").val())+parseFloat($("#dis14").val())+parseFloat($("#dis15").val())+parseFloat($("#dis16").val());
			$("#disamt").val(totaldis);
			var totalamt = 	parseFloat($("#total1").val())+parseFloat($("#total2").val())+parseFloat($("#total3").val())+parseFloat($("#total4").val())+parseFloat($("#total5").val())+parseFloat($("#total6").val())+parseFloat($("#total7").val())+parseFloat($("#total8").val())+parseFloat($("#total9").val())+parseFloat($("#total10").val())+parseFloat($("#total11").val())+parseFloat($("#total12").val())+parseFloat($("#total13").val())+parseFloat($("#total14").val())+parseFloat($("#total15").val())+parseFloat($("#total16").val());	
			$("#total_amt").val(totalamt);
			var paid_amt = parseFloat(totalamt) - parseFloat(totaldis);
			$("#paid_amt").val(paid_amt);					
		}else{
			$("#total_amt12").val(total);
			var totalamt = 	parseFloat($("#total1").val())+parseFloat($("#total2").val())+parseFloat($("#total3").val())+parseFloat($("#total4").val())+parseFloat($("#total5").val())+parseFloat($("#total6").val())+parseFloat($("#total7").val())+parseFloat($("#total8").val())+parseFloat($("#total9").val())+parseFloat($("#total10").val())+parseFloat($("#total11").val())+parseFloat($("#total12").val())+parseFloat($("#total13").val())+parseFloat($("#total14").val())+parseFloat($("#total15").val())+parseFloat($("#total16").val());	
			$("#total_amt").val(totalamt);
			$("#paid_amt").val(totalamt);			
		}
	}
	function calculateTotal13(){
		var total; 
		var rate = $("#rate13").val();
		var qty = $("#qty13").val();
		total = rate * qty;
		$("#total13").val(total);
		var discount= $("#discount13").val();
		if(discount.indexOf("%") != -1){
			discount = discount.substr(0,discount.length -1);
			discount = total * parseFloat(discount/100);
		}else{
			discount = parseFloat(discount);	
		}
		if(discount>0){
			var dprice = total - discount;
			var gtotal=dprice.toFixed(2);
			$("#total_amt13").val(gtotal);
			$("#dis13").val(discount);		
			var totaldis = parseFloat($("#dis1").val())+parseFloat($("#dis2").val())+parseFloat($("#dis3").val())+parseFloat($("#dis4").val())+parseFloat($("#dis5").val())+parseFloat($("#dis6").val())+parseFloat($("#dis7").val())+parseFloat($("#dis8").val())+parseFloat($("#dis9").val())+parseFloat($("#dis10").val())+parseFloat($("#dis11").val())+parseFloat($("#dis12").val())+parseFloat($("#dis13").val())+parseFloat($("#dis14").val())+parseFloat($("#dis15").val())+parseFloat($("#dis16").val());
			$("#disamt").val(totaldis);
			var totalamt = 	parseFloat($("#total1").val())+parseFloat($("#total2").val())+parseFloat($("#total3").val())+parseFloat($("#total4").val())+parseFloat($("#total5").val())+parseFloat($("#total6").val())+parseFloat($("#total7").val())+parseFloat($("#total8").val())+parseFloat($("#total9").val())+parseFloat($("#total10").val())+parseFloat($("#total11").val())+parseFloat($("#total12").val())+parseFloat($("#total13").val())+parseFloat($("#total14").val())+parseFloat($("#total15").val())+parseFloat($("#total16").val());	
			$("#total_amt").val(totalamt);	
			var paid_amt = parseFloat(totalamt) - parseFloat(totaldis);
			$("#paid_amt").val(paid_amt);				
		}else{
			$("#total_amt13").val(total);
			var totalamt = 	parseFloat($("#total1").val())+parseFloat($("#total2").val())+parseFloat($("#total3").val())+parseFloat($("#total4").val())+parseFloat($("#total5").val())+parseFloat($("#total6").val())+parseFloat($("#total7").val())+parseFloat($("#total8").val())+parseFloat($("#total9").val())+parseFloat($("#total10").val())+parseFloat($("#total11").val())+parseFloat($("#total12").val())+parseFloat($("#total13").val())+parseFloat($("#total14").val())+parseFloat($("#total15").val())+parseFloat($("#total16").val());	
			$("#total_amt").val(totalamt);
			$("#paid_amt").val(totalamt);			
		}
	}	
	function calculateTotal14(){
		var total; 
		var rate = $("#rate14").val();
		var qty = $("#qty14").val();
		total = rate * qty;
		$("#total14").val(total);
		var discount= $("#discount14").val();
		if(discount.indexOf("%") != -1){
			discount = discount.substr(0,discount.length -1);
			discount = total * parseFloat(discount/100);
		}else{
			discount = parseFloat(discount);	
		}
		if(discount>0){
			var dprice = total - discount;
			var gtotal=dprice.toFixed(2);
			$("#total_amt14").val(gtotal);
			$("#dis14").val(discount);		
			var totaldis = parseFloat($("#dis1").val())+parseFloat($("#dis2").val())+parseFloat($("#dis3").val())+parseFloat($("#dis4").val())+parseFloat($("#dis5").val())+parseFloat($("#dis6").val())+parseFloat($("#dis7").val())+parseFloat($("#dis8").val())+parseFloat($("#dis9").val())+parseFloat($("#dis10").val())+parseFloat($("#dis11").val())+parseFloat($("#dis12").val())+parseFloat($("#dis13").val())+parseFloat($("#dis14").val())+parseFloat($("#dis15").val())+parseFloat($("#dis16").val());
			$("#disamt").val(totaldis);
			var totalamt = 	parseFloat($("#total1").val())+parseFloat($("#total2").val())+parseFloat($("#total3").val())+parseFloat($("#total4").val())+parseFloat($("#total5").val())+parseFloat($("#total6").val())+parseFloat($("#total7").val())+parseFloat($("#total8").val())+parseFloat($("#total9").val())+parseFloat($("#total10").val())+parseFloat($("#total11").val())+parseFloat($("#total12").val())+parseFloat($("#total13").val())+parseFloat($("#total14").val())+parseFloat($("#total15").val())+parseFloat($("#total16").val());	
			$("#total_amt").val(totalamt);	
			var paid_amt = parseFloat(totalamt) - parseFloat(totaldis);
			$("#paid_amt").val(paid_amt);				
		}else{
			$("#total_amt14").val(total);
			var totalamt = 	parseFloat($("#total1").val())+parseFloat($("#total2").val())+parseFloat($("#total3").val())+parseFloat($("#total4").val())+parseFloat($("#total5").val())+parseFloat($("#total6").val())+parseFloat($("#total7").val())+parseFloat($("#total8").val())+parseFloat($("#total9").val())+parseFloat($("#total10").val())+parseFloat($("#total11").val())+parseFloat($("#total12").val())+parseFloat($("#total13").val())+parseFloat($("#total14").val())+parseFloat($("#total15").val())+parseFloat($("#total16").val());	
			$("#total_amt").val(totalamt);	
			$("#paid_amt").val(totalamt);		
		}
	}	
	function calculateTotal14(){
		var total; 
		var rate = $("#rate15").val();
		var qty = $("#qty15").val();
		total = rate * qty;
		$("#total15").val(total);		
		var discount= $("#discount15").val();
		if(discount.indexOf("%") != -1){
			discount = discount.substr(0,discount.length -1);
			discount = total * parseFloat(discount/100);
		}else{
			discount = parseFloat(discount);	
		}
		if(discount>0){
			var dprice = total - discount;
			var gtotal=dprice.toFixed(2);
			$("#total_amt15").val(gtotal);
			$("#dis15").val(discount);		
			var totaldis = parseFloat($("#dis1").val())+parseFloat($("#dis2").val())+parseFloat($("#dis3").val())+parseFloat($("#dis4").val())+parseFloat($("#dis5").val())+parseFloat($("#dis6").val())+parseFloat($("#dis7").val())+parseFloat($("#dis8").val())+parseFloat($("#dis9").val())+parseFloat($("#dis10").val())+parseFloat($("#dis11").val())+parseFloat($("#dis12").val())+parseFloat($("#dis13").val())+parseFloat($("#dis14").val())+parseFloat($("#dis15").val())+parseFloat($("#dis16").val());
			$("#disamt").val(totaldis);
			var totalamt = 	parseFloat($("#total1").val())+parseFloat($("#total2").val())+parseFloat($("#total3").val())+parseFloat($("#total4").val())+parseFloat($("#total5").val())+parseFloat($("#total6").val())+parseFloat($("#total7").val())+parseFloat($("#total8").val())+parseFloat($("#total9").val())+parseFloat($("#total10").val())+parseFloat($("#total11").val())+parseFloat($("#total12").val())+parseFloat($("#total13").val())+parseFloat($("#total14").val())+parseFloat($("#total15").val())+parseFloat($("#total16").val());	
			$("#total_amt").val(totalamt);	
			var paid_amt = parseFloat(totalamt) - parseFloat(totaldis);
			$("#paid_amt").val(paid_amt);						
		}else{
			$("#total_amt15").val(total);
			var totalamt = 	parseFloat($("#total1").val())+parseFloat($("#total2").val())+parseFloat($("#total3").val())+parseFloat($("#total4").val())+parseFloat($("#total5").val())+parseFloat($("#total6").val())+parseFloat($("#total7").val())+parseFloat($("#total8").val())+parseFloat($("#total9").val())+parseFloat($("#total10").val())+parseFloat($("#total11").val())+parseFloat($("#total12").val())+parseFloat($("#total13").val())+parseFloat($("#total14").val())+parseFloat($("#total15").val())+parseFloat($("#total16").val());	
			$("#total_amt").val(totalamt);	
			$("#paid_amt").val(totalamt);		
		}
	}
	function calculateTotal16(){
		var total; 
		var rate = $("#rate16").val();
		var qty = $("#qty16").val();
		total = rate * qty;
		$("#total16").val(total);		
		var discount= $("#discount16").val();
		if(discount.indexOf("%") != -1){
			discount = discount.substr(0,discount.length -1);
			discount = total * parseFloat(discount/100);
		}else{
			discount = parseFloat(discount);	
		}
		if(discount>0){
			var dprice = total - discount;
			var gtotal=dprice.toFixed(2);
			$("#total_amt16").val(gtotal);
			$("#dis16").val(discount);
			$("#total16").val(gtotal);			
			var totaldis = parseFloat($("#dis1").val())+parseFloat($("#dis2").val())+parseFloat($("#dis3").val())+parseFloat($("#dis4").val())+parseFloat($("#dis5").val())+parseFloat($("#dis6").val())+parseFloat($("#dis7").val())+parseFloat($("#dis8").val())+parseFloat($("#dis9").val())+parseFloat($("#dis10").val())+parseFloat($("#dis11").val())+parseFloat($("#dis12").val())+parseFloat($("#dis13").val())+parseFloat($("#dis14").val())+parseFloat($("#dis15").val())+parseFloat($("#dis16").val());
			$("#disamt").val(totaldis);
			var totalamt = 	parseFloat($("#total1").val())+parseFloat($("#total2").val())+parseFloat($("#total3").val())+parseFloat($("#total4").val())+parseFloat($("#total5").val())+parseFloat($("#total6").val())+parseFloat($("#total7").val())+parseFloat($("#total8").val())+parseFloat($("#total9").val())+parseFloat($("#total10").val())+parseFloat($("#total11").val())+parseFloat($("#total12").val())+parseFloat($("#total13").val())+parseFloat($("#total14").val())+parseFloat($("#total15").val())+parseFloat($("#total16").val());	
			$("#total_amt").val(totalamt);
			var paid_amt = parseFloat(totalamt) - parseFloat(totaldis);
			$("#paid_amt").val(paid_amt);	
		}else{
			$("#total_amt16").val(total);
			var totalamt = 	parseFloat($("#total1").val())+parseFloat($("#total2").val())+parseFloat($("#total3").val())+parseFloat($("#total4").val())+parseFloat($("#total5").val())+parseFloat($("#total6").val())+parseFloat($("#total7").val())+parseFloat($("#total8").val())+parseFloat($("#total9").val())+parseFloat($("#total10").val())+parseFloat($("#total11").val())+parseFloat($("#total12").val())+parseFloat($("#total13").val())+parseFloat($("#total14").val())+parseFloat($("#total15").val())+parseFloat($("#total16").val());	
			$("#total_amt").val(totalamt);	
			$("#paid_amt").val(totalamt);		
		}
	}	
	
	$(document).ready(function(){	
		$('#test1').change(function(){
			values = $(this).val();
			values = values.split('_');
			price = parseFloat(values[1]);
			$("#rate1").val(price);
			$("#qty1").val('1');
			calculateTotal1();
		});
	$('#test2').change(function(){
			values = $(this).val();
			values = values.split('_');
			price = parseFloat(values[1]);
			$("#rate2").val(price);
			$("#qty2").val('1');
			calculateTotal2();
		});

	$('#test3').change(function(){
			values = $(this).val();
			values = values.split('_');
			price = parseFloat(values[1]);
			$("#rate3").val(price);
			$("#qty3").val('1');
			calculateTotal3();
		});
		
	$('#test4').change(function(){
		values = $(this).val();
		values = values.split('_');
		price = parseFloat(values[1]);
		$("#rate4").val(price);
		$("#qty4").val('1');
		calculateTotal4();
	});

	$('#test5').change(function(){
			values = $(this).val();
			values = values.split('_');
			price = parseFloat(values[1]);
			$("#rate5").val(price);
			$("#qty5").val('1');
			calculateTotal5();
		});
	$('#test6').change(function(){
			values = $(this).val();
			values = values.split('_');
			price = parseFloat(values[1]);
			$("#rate6").val(price);
			$("#qty6").val('1');
			calculateTotal6();
	});
	$('#test7').change(function(){
			values = $(this).val();
			values = values.split('_');
			price = parseFloat(values[1]);
			$("#rate7").val(price);
			$("#qty7").val('1');
			calculateTotal7();
	});
	$('#test8').change(function(){
			values = $(this).val();
			values = values.split('_');
			price = parseFloat(values[1]);
			$("#rate8").val(price);
			$("#qty8").val('1');
			calculateTotal8();
	});

	$('#test9').change(function(){
			values = $(this).val();
			values = values.split('_');
			price = parseFloat(values[1]);
			$("#rate9").val(price);
			$("#qty9").val('1');
			calculateTotal9();
		});
	$('#test10').change(function(){
			values = $(this).val();
			values = values.split('_');
			price = parseFloat(values[1]);
			$("#rate10").val(price);
			$("#qty10").val('1');
			calculateTotal10();
		});
	$('#test11').change(function(){
			values = $(this).val();
			values = values.split('_');
			price = parseFloat(values[1]);
			$("#rate11").val(price);
			$("#qty11").val('1');
			calculateTotal11();
	});
	
	$('#test12').change(function(){
			values = $(this).val();
			values = values.split('_');
			price = parseFloat(values[1]);
			$("#rate12").val(price);
			$("#qty12").val('1');
			calculateTotal12();
	});
	$('#test13').change(function(){
			values = $(this).val();
			values = values.split('_');
			price = parseFloat(values[1]);
			$("#rate13").val(price);
			$("#qty13").val('1');
			calculateTotal13();
		});
	$('#test14').change(function(){
			values = $(this).val();
			values = values.split('_');
			price = parseFloat(values[1]);
			$("#rate14").val(price);
			$("#qty14").val('1');
			calculateTotal14();
		});	
	$('#test15').change(function(){
			values = $(this).val();
			values = values.split('_');
			price = parseFloat(values[1]);
			$("#rate15").val(price);
			$("#qty15").val('1');
			calculateTotal15();
		});
	$('#test16').change(function(){
			values = $(this).val();
			values = values.split('_');
			price = parseFloat(values[1]);
			$("#rate16").val(price);
			$("#qty16").val('1');
			calculateTotal16();
		});					
	$("#hospital").autoSuggest({
			ajaxFilePath	 : "patient/findhospital", 
			ajaxParams       : "dummydata=dummyData",
			autoFill	 : "true",
			iwidth		 : "auto",
			opacity		 : "0.9",
			ilimit		 : "10",
			idHolder	 : "id-holder",
			match		 : "starts"
		});
	});
	function findTest1(department) {
		$("#rate1").val('');
		$("#qty1").val('');
		$("#total_amt1").val('');
		$("#discount1").val('');
		$.ajax({
			type: "POST",
			url: "patient/findTest",
			data: "department="+department,		
			success: function (msg) {
				$('#test1').html(msg);
	
			}
		});
	}
	function findTest2(department) {
		$.ajax({
			type: "POST",
			url: "patient/findTest",
			data: "department="+department,		
			success: function (msg) {
				$('#test2').html(msg);
	
			}
		});
	}
	function findTest3(department) {
		$.ajax({
			type: "POST",
			url: "patient/findTest",
			data: "department="+department,		
			success: function (msg) {
				$('#test3').html(msg);
	
			}
		});
	}	
	function findTest4(department) {
		$.ajax({
			type: "POST",
			url: "patient/findTest",
			data: "department="+department,		
			success: function (msg) {
				$('#test4').html(msg);
	
			}
		});
	}	
	function findTest5(department) {
		$.ajax({
			type: "POST",
			url: "patient/findTest",
			data: "department="+department,		
			success: function (msg) {
				$('#test5').html(msg);
	
			}
		});
	}
	function findTest6(department) {
		$.ajax({
			type: "POST",
			url: "patient/findTest",
			data: "department="+department,		
			success: function (msg) {
				$('#test6').html(msg);
	
			}
		});
	}	
	function findTest7(department) {
		$.ajax({
			type: "POST",
			url: "patient/findTest",
			data: "department="+department,		
			success: function (msg) {
				$('#test7').html(msg);
	
			}
		});
	}	
	function findTest8(department) {
		$.ajax({
			type: "POST",
			url: "patient/findTest",
			data: "department="+department,		
			success: function (msg) {
				$('#test8').html(msg);
	
			}
		});
	}
	function findTest9(department) {
		$.ajax({
			type: "POST",
			url: "patient/findTest",
			data: "department="+department,		
			success: function (msg) {
				$('#test9').html(msg);
	
			}
		});
	}	
	function findTest10(department) {
		$.ajax({
			type: "POST",
			url: "patient/findTest",
			data: "department="+department,		
			success: function (msg) {
				$('#test10').html(msg);
	
			}
		});
	}	
	function findTest11(department) {
		$.ajax({
			type: "POST",
			url: "patient/findTest",
			data: "department="+department,		
			success: function (msg) {
				$('#test11').html(msg);
	
			}
		});
	}
	function findTest12(department) {
		$.ajax({
			type: "POST",
			url: "patient/findTest",
			data: "department="+department,		
			success: function (msg) {
				$('#test12').html(msg);
	
			}
		});
	}
	function findTest13(department) {
		$.ajax({
			type: "POST",
			url: "patient/findTest",
			data: "department="+department,		
			success: function (msg) {
				$('#test13').html(msg);
	
			}
		});
	}	
	function findTest14(department) {
		$.ajax({
			type: "POST",
			url: "patient/findTest",
			data: "department="+department,		
			success: function (msg) {
				$('#test14').html(msg);
	
			}
		});
	}	
	function findTest15(department) {
		$.ajax({
			type: "POST",
			url: "patient/findTest",
			data: "department="+department,		
			success: function (msg) {
				$('#test15').html(msg);
	
			}
		});
	}	
	function findTest16(department) {
		$.ajax({
			type: "POST",
			url: "patient/findTest",
			data: "department="+department,		
			success: function (msg) {
				$('#test16').html(msg);
	
			}
		});
	}						
	function findRegistration(regtype) {
		var ptype = $("#ptype").val();
		$.ajax({
			type: "POST",
			url: "patient/findregistration",
			data: "regtype="+regtype+"&ptype="+ptype,		
			success: function (msg) {
				$('#total_amt').val(msg);
				$("#paid_amt").val(msg);
			}
		});
	}
	function getVdc(district) {
		$.ajax({
			type: "POST",
			url: "patient/getVdc",
			data: "district="+district,		
			success: function (msg) {
				$("#vdc").html(msg);
			}
		});
	}
	function getDob(){
		var dob;
		var ageopt = $("#age_option").val();
		var age = $("#age").val();
		$.ajax({
			type: "POST",
			url: 'patient/getDob',
			data : "age="+age+"&ageopt="+ageopt,
			success: function (msg){
				dob = msg.split('_');
				$("#dob").val(dob[0]);	
				$("#ndob").val(dob[1]);	
			}
		});
	}