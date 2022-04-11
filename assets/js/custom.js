	$(document).ready(function() {
		$("#email_address").keypress(function(){
			$("#email_address").css('background','#fff');
			$("#email_address").css('border','#CCC 1px solid');
		})
		$("#name").keypress(function(){
			$("#name").css('background','#fff');
			$("#name").css('border','#CCC 1px solid');
		})
		$("#newsletterSubmit").click(function(){
			if($("#name").val()==''){
				$("#name").css('border','#F00 1px solid');
				$("#name").css('background','#F00');
				return false;
			}
			if($("#email_address").val()==''){
				$("#email_address").css('border','#F00 1px solid');
				$("#email_address").css('background','#F00');
				return false;
			}
			var fname 	 = $("#name").val();
			var email 	 = $("#email_address").val();
			$.ajax({
				type: "POST",
				url: base_url+"home/subscribe",
				data: "fname="+fname+"&email="+email+"&action=submit",
				success: function (msg) {
					var msg = msg.trim();
					if(msg=='yes'){
						$("#newsletterSuccess").removeAttr('class','hidden');
						$("#newsletterSuccess").attr('class','alert alert-success');
						$("#newsletterSuccess").delay(2000).slideUp('slow',function(){
							$("#newsletterSuccess").html('');
						});
						$("#name").val('');	
						$("#email_address").val('');			
					}else{
						$("#newsletterError").removeAttr('class','hidden');
						$("#newsletterError").attr('class','alert alert-success');
						$("#newsletterError").show();
						$("#newsletterError").delay(2000).slideUp('slow',function(){
							$("#newsletterError").html('');
						});
						
					}
				}
			});
		});	
		 $('.icon-info').tooltip({'placement': 'top','title':'Sorry you can’t upload your Artwork for the orders with artwork status as "Processed". If you want to re-supply your artwork or any urgent matter, Please send email to '+email+'. With your Order No. or Job No.'});			
	})
		