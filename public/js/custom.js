$("#place-order").click(function() {
	$("#loader").removeAttr('hidden');
	$('.container').css({ "opacity" : "0.5" });
});

$("#process-order").click(function() {
	$("#loader").removeAttr('hidden');
	$('.main').css({ "opacity" : "0.5" });
});

$("#reject-order").click(function() {
	$("#loader").removeAttr('hidden');
	$('.main').css({ "opacity" : "0.5" });
});

$("#send-nostock").click(function() {
	$("#loader").removeAttr('hidden');
	$('.main').css({ "opacity" : "0.5" });
});

$("#send-email").click(function() {
	$("#loader").removeAttr('hidden');
	$('.main').css({ "opacity" : "0.5" });
});

$("#register-customer").click(function() {
	$("#loader").removeAttr('hidden');
	$('.container').css({ "opacity" : "0.5" });
});

$('input[name=date_from]').change(function() {
	var datefrom = $('input[name=date_from]').val();
	var dateto = $('input[name=date_to]').val();

	$('input[name=date_to]').attr({
		"min" : datefrom
	});
});
