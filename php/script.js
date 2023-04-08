function togglePassword() {
    let x = document.getElementById("password");
    let y = document.getElementById("showPassword");
    if (y.checked) {
        x.type = "text";
    } else {
        x.type = "password";
    }
}

function togglePassword2() {
    let x = document.getElementById("password2");
    let y = document.getElementById("showPassword2");
    if (y.checked) {
        x.type = "text";
    } else {
        x.type = "password";
    }
}