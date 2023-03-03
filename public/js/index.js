$(function() {
	var $successAlert = $("#registrationSuccess");
	var $failAlert = $("#registrationFail");
	var $form = $("#signup")

	var request;
	$("#signup").submit(function(event) {
		$successAlert.hide();
		$failAlert.hide();

		event.preventDefault();

		if (request) {
			request.abort();
		}

		var $form = $(this);
		var $inputs = $form.find("input, select, button, textarea");
		var serializedData = $form.serialize();

		$inputs.prop("disabled", true);
		request = $.post("signup.php", serializedData, function(data) {
			const response = JSON.parse(data);
			console.log(response);
			if (response.status == "success") {
				$successAlert.show();
				$form.hide();
			} else {
				$failAlert.text(response.message);
				$failAlert.show();
			}
		}).fail(function (jqXHR, textStatus, errorThrown) {
			console.error("The following error occured: " +
				errorThrown);
		}).always(function() {
			$inputs.prop("disabled", false);
		});
	});
});