const text_one = "Пройденные тесты : ";
const text_two = "Актуальные тесты : ";
const speed = 100;

function typeWriter(text, elementId) {
    let i = 0; 

    function type() {
        if (i < text.length) {
            document.getElementById(elementId).textContent += text.charAt(i);
            i++;
            setTimeout(type, speed);
        }
    }

    type(); 
}

typeWriter(text_one, "text_one");
typeWriter(text_two, "text_two");