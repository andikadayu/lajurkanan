function sendSMTP() {
    var email = $('#email').val();
    if (email != "") {
        $.ajax({
            url: "controller/remember_pass.php",
            method: "GET",
            data: {
                email: email,
                purpose: "cekEmail"
            }
        }).done(function (data) {
            if (data == 'success') {
                $('#code').prop("disabled", false);
                $('#codeBtn').prop("disabled", false);
                alert("Success send Code OTP check your email");
            } else {
                alert(data);
            }
        })
    } else {
        alert("input your email");
    }
}

function checkOTP() {
    var email = $('#email').val();
    var code = $('#code').val();

    if (email != "" && code != "") {
        $.ajax({
            url: "controller/remember_pass.php",
            method: "GET",
            data: {
                email: email,
                purpose: "cekOTP",
                code: code
            }
        }).done(function (data) {
            if (data == 'success') {
                $('#password').prop("disabled", false);
                $('#btnSubmit').prop("disabled", false);
                alert("The Code OTP Is Correctly");
            } else {
                alert("The Code OTP Is not Correctly");
            }
        })
    } else {
        alert("input your code otp");
    }
}