// Функция для показа/скрытия пароля
document.getElementById('togglePassword').addEventListener('click', function () {
  const passwordField = document.getElementById('password');
  const isPasswordVisible = passwordField.getAttribute('type') === 'password';
  passwordField.setAttribute('type', isPasswordVisible ? 'text' : 'password');
  this.textContent = isPasswordVisible ? 'Скрыть' : 'Показать';
});
