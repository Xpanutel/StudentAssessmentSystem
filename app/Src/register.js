const container = document.getElementById('container');
const registerBtn = document.getElementById('register');
const loginBtn = document.getElementById('login');

registerBtn.addEventListener('click', () => {
    container.classList.add("active");
});

loginBtn.addEventListener('click', () => {
    container.classList.remove("active");
});

// Анимация
const login = document.getElementById('text')
const text = "Войти";
const speed = 300;
let i = 0;

function typeWriter() {
  if (i < text.length) {
    document.getElementById("text").textContent += text.charAt(i);
    i++;
    setTimeout(typeWriter, speed);
  }
}

typeWriter();
