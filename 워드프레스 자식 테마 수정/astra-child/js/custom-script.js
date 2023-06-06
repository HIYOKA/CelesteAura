//결제 페이지에서 로그인 폼 부분이 번역이 쉽게 되어 있지 않아서 자바스크립트로 수정함
document.addEventListener("DOMContentLoaded", function () {
  // 비밀번호 찾기 링크 텍스트 변경
  var lostPasswordLink = document.querySelector(".lost_password a");
  if (lostPasswordLink) {
    lostPasswordLink.textContent = "비밀번호를 잊으셨나요?";
  }
  var usernameLabel = document.querySelector('label[for="username"]');
  if (usernameLabel) {
    usernameLabel.textContent = "유저명 또는 이메일";
  }

  // 'Password' 텍스트 변경
  var passwordLabel = document.querySelector('label[for="password"]');
  if (passwordLabel) {
    passwordLabel.textContent = "비밀번호";
  }
  var loginButton = document.querySelector(".woocommerce-form-login__submit");
  if (loginButton) {
    loginButton.textContent = "로그인";
  }
  // 'Remember me' 작동하지 않아서 삭제
  var rememberMeLabel = document.querySelector(
    ".woocommerce-form__label-for-checkbox"
  );
  if (rememberMeLabel) {
    rememberMeLabel.remove();
  }

  // 'Remember me' 체크박스 삭제
  var rememberMeCheckbox = document.querySelector(
    ".woocommerce-form__input-checkbox"
  );
  if (rememberMeCheckbox) {
    rememberMeCheckbox.remove();
  }
});
