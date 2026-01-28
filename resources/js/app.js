import './bootstrap';

// document.getElementById('weather-form').addEventListener('submit', function(e) {
//
//     let formData = new FormData(this);
//
//     axios.post('/submit-form', formData)
//         .then(response => {
//             if (response.status === 422) { // Если валидация не прошла
//                 return response.json().then(data => {
//                     displayErrors(data.errors); // Функция отображения ошибок
//                 });
//             }
//         });
//
//     function displayErrors(errors) {
//         // Логика очистки старых ошибок и отображения новых
//         for (let field in errors) {
//             let message = errors[field][0];
//             document.querySelector(`.${field}-error`).innerText = message;
//         }
//     }
// });
