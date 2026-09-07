const addForm = document.getElementById('addForm');
const num1 = document.getElementById('num1');
const num2 = document.getElementById('num2');
const total = document.getElementById('total');

addForm.addEventListener('submit', (event) => {
    event.preventDefault();
    const sum = Number(num1.value) + Number(num2.value);
    if (isNaN(sum)) {
        total.textContent = "Please enter valid numbers";
        return;
    }
    total.textContent = "Total = " + sum;
});

const styleForm = document.getElementById('styleForm');
const styleSelect = document.getElementById('styleSelect');
const styledText = document.getElementById('styledText');

styleForm.addEventListener('submit', (event) => {
    event.preventDefault();
    styledText.classList.remove("normal", "bold", "italic", "bold-italic");
    styledText.classList.add(styleSelect.value);
});