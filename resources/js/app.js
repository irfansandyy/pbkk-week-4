document.querySelectorAll('.dismiss-banner').forEach((button) => {
    button.addEventListener('click', () => {
        button.closest('[data-banner]').remove();
    });
});

const description = document.querySelector('#description');
const count = document.querySelector('#character-count');
if (description && count) {
    description.addEventListener('input', () => {
        count.textContent = `${Array.from(description.value).length}/2000`;
    });
}

const errors = document.querySelector('#form-errors');
if (errors) errors.focus();
