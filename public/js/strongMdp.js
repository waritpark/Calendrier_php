$(document).ready(function() {
    $('#password, #password2').on('keyup', function() {
        var strongRegex = new RegExp("^(?=.{8,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");
        var mediumRegex = new RegExp("^(?=.{7,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
        var okRegex = new RegExp("(?=.{6,}).*", "g");

        if (okRegex.test($(this).val()) === false) {
            $('#passwordStrength').removeClass().addClass('alert alert-danger').html('Le mot de passe doit contenir 6 caractères minimum.');
        } else if (strongRegex.test($(this).val())) {
            $('#passwordStrength').removeClass().addClass('alert alert-success').html('Fiabilité du mot de passe : Excellent !');
        } else if (mediumRegex.test($(this).val())) {
            $('#passwordStrength').removeClass().addClass('alert alert-info').html('Fiabilité du mot de passe : moyenne.');
        } else {
            $('#passwordStrength').removeClass().addClass('alert alert-danger').html('Fiabilité du mot de passe : mauvais.');
        }
        return true;
    });
});
