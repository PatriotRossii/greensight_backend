$(function() {
	var request;
	$("#signup").submit(function(event) {
		event.preventDefault();

		if (request) {
			request.abort();
		}

		var $form = $(this);
		var $inputs = $form.find("input, select, button, textarea");
		var serializedData = $form.serialize();

		$inputs.prop("disabled", true);
		request = $.post("signup.php", serializedData).fail(function (jqXHR, textStatus, errorThrown) {
			console.error("The following error occured: " +
				errorThrown);
		}).always(function() {
			$inputs.prop("disabled", false);
		});
	});
});