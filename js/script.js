var IDField = document.getElementById("student_id");
IDField.addEventListener("change", function() {
    var stID = IDField.value;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            document.getElementById("id-status").innerHTML = xhr.responseText;
        }
    };

    xhr.open("GET", "validation_ID_student.php?id_num=" + stID, true);
    xhr.send();
});

var emailField2 = document.getElementById("email");
emailField2.addEventListener("change", function() {
    var email = emailField2.value;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            document.getElementById("email-status").innerHTML = xhr.responseText;
        }
    };

    xhr.open("GET", "validation_email_student.php?email=" + email, true);
    xhr.send();
});


var PassField = document.getElementById("pass");
PassField.addEventListener("change", function() {
    var pswd = PassField.value;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            document.getElementById("pass-status").innerHTML = xhr.responseText;
        }
    };
    xhr.open("GET", "validation_password_student.php?pass=" + pswd, true);
    xhr.send();
});

var IDField2 = document.getElementById("faculty_id");
IDField2.addEventListener("change", function() {
    var fcID = IDField2.value;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            document.getElementById("id-status2").innerHTML = xhr.responseText;
        }
    };

    xhr.open("GET", "validation_ID_admin.php?id_num=" + fcID, true);
    xhr.send();
});

var emailField2 = document.getElementById("email_admin");
emailField2.addEventListener("change", function() {
    var email2 = emailField2.value;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            document.getElementById("email-status2").innerHTML = xhr.responseText;
        }
    };

    xhr.open("GET", "validation_email_admin.php?email=" + email2, true);
    xhr.send();
});


var PassField2 = document.getElementById("pass");
PassField2.addEventListener("change", function() {
    var pswd2 = PassField2.value;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            document.getElementById("pass-status").innerHTML = xhr.responseText;
        }
    };
    xhr.open("GET", "validation_password_student.php?pass=" + pswd2, true);
    xhr.send();
});



