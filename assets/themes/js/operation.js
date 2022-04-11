	function filterOperation(surgery_id) {
		$.ajax({
			type: "POST",
			url: "patient/findoperation",
			data: "surgery_id="+surgery_id,		
			success: function (msg) {
				$('#operation').html(msg);
	
			}
		});
	}
	function filterOperation1(surgery_id) {
		$.ajax({
			type: "POST",
			url: "patient/findoperation",
			data: "surgery_id="+surgery_id,		
			success: function (msg) {
				$('#operation1').html(msg);
	
			}
		});
	}
	function filterOperation2(surgery_id) {
		$.ajax({
			type: "POST",
			url: "patient/findoperation",
			data: "surgery_id="+surgery_id,		
			success: function (msg) {
				$('#operation2').html(msg);
	
			}
		});
	}
    
	
	function finddoctors(category) {
		$.ajax({
			type: "POST",
			url: "patient/finddoctors",
			data: "category="+category,		
			success: function (msg) {
				$('#doctor').html(msg);
			}
		});
	}
	function finddoctors1(category) {
		$.ajax({
			type: "POST",
			url: "patient/finddoctors",
			data: "category="+category,		
			success: function (msg) {
				$('#doctor1').html(msg);
			}
		});
	}

	function finddoctors2(category) {
		$.ajax({
			type: "POST",
			url: "patient/finddoctors",
			data: "category="+category,		
			success: function (msg) {
				$('#doctor2').html(msg);
			}
		});
	}
    
    