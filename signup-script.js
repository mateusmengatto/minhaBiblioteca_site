const form = document.getElementById("form");
const minPasswordCharacters = 8;
const minNameLength = 4;

// Inputs
let name = document.getElementById("nome");
let email = document.getElementById("email");
let password = document.getElementById("senha");
let confirmPassword = document.getElementById("confirmPassword");

// Declarando mensagens de erro
let passMismatch = document.getElementById("passMismatch");
let minPassElement = document.getElementById("minPasswordCharacters");
let emailError = document.getElementById("emailError");
let usernameError = document.getElementById("usernameError");

// Client-side email validation
let emailExiste;
let usuarioExiste;
let senhaPadrao;

function checkPassMismatch(password, confirmPassword) {
  if (password != confirmPassword) {
      passMismatch.style.display = "block";
    } else {
      passMismatch.style.display = "none";
    }
}

$(document).ready(function () {
  $("#email").keyup(function () {
    var email = $(this).val();
    $.get("check_email.php", { email: email }, function (data) {
      if (data == "exists") {
        $("#emailError").show();
        emailExiste = true;
      } else {
        $("#emailError").hide();
        emailExiste = false;
      }
    });
  });

  $("#username").keyup(function () {
    var username = $(this).val();
    $.get("check_username.php", { username: username }, function (data) {
      if (data == "exists") {
        $("#usernameError").show();
        usuarioExiste = true;
      } else {
        $("#usernameError").hide();
        usuarioExiste = false;
      }
    });
  });
  
            
  $("#senha").keyup(function () {
    let password = $(this).val();
    $.get("check_passwordPattern.php", {senha : password}, function (data){
      if (data == "Fail"){
        senhaPadrao = false;
      } else {
        senhaPadrao = true;
      }
    });
  });

  $("#senha").keyup(function () {
    let password = $(this).val();
    let confirmPassword = $("#confirmPassword").val();

    // Senha muito curta
    if (password.length < minPasswordCharacters) {
      minPassElement.style.display = "block";
    } else {
      minPassElement.style.display = "none";
    }

    // Senhas nao coincidem
    checkPassMismatch(password, confirmPassword);
  });

  $("#confirmPassword").keyup(function () {
    let confirmPassword = $(this).val();
    let password = $("#senha").val();

    // Senhas nao coincidem
    checkPassMismatch(password, confirmPassword);
  });
});

window.onload = function () {
  // Função para evitar que o form seja enviado caso haja algum erro
  let formIsValid = true;
  function checkForm(event) {

    // Email ja existe
    if (emailExiste) {
      formIsValid = false;
      alert("E-mail já cadastrado. Tente novamente com outro e-mail.")
      return;
    }

    // Usuario ja existe
    if (usuarioExiste) {
      formIsValid = false;
     alert("Usuario já cadastrado. Tente novamente com outro nome de usuário.")
     return;
    }
    
    if (!senhaPadrao){
      formIsValid = false
      alert("A senha deve conter pelo menos 8 caracters, uma maiúscula,um número, e um caracatere especial. Tente novamente.")
      return;
    }

    // Senha muito curta
    if (password.value.length < minPasswordCharacters) {
      formIsValid = false;
      return;
    }

    // Senhas nao coincidem
    if (password.value != confirmPassword.value) {
      formIsValid = false;
      alert("As senhas não coincidem. Tente novamente.")
      return;
    }

    if (!formIsValid) {
      event.preventDefault();
    } else {
      // Submit realizado
    }
  }

  form.addEventListener("submit", checkForm);
};
