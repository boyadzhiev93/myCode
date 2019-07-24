$("#button_add_pay_value").click(function() {

    var payValue = $("#payment_processor_amount").val().repSpaciealChar();
    var paymentProcessor = $("#payment_processor_list").val().repSpaciealChar();

    if (payValue || paymentProcessor) {

        $.ajax({

            type: "POST",
            url: "",
            data: {
                'payValue': payValue,
                'paymentProcessor': paymentProcessor
            },
            dataType: "json",
            cache: false,
            success: function(result) {

                $('#addCreditsModal').modal('hide');
                $("#pay-value").val("");
                $("#credits_on_wallet").text(result.credits);
                toastr.warning("Вашата сметка e заредена с " + result.paymentAmount + " кредита!");

            },

            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
                toastr.warning("Настъпи грешка при входирането на вашите данни");
            }

        })

    } else {

        toastr.warning("Моля попълнете всички полета!");
    }
});
