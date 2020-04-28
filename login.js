// document.addEventListener("DOMContentLoaded", function() {
//     console.log('Carregou');
//     var iconMedical = document.querySelector('.iconMedical');
//     var iconPatient = document.querySelector('.iconPatient');
//     var textMedical = document.querySelector('.textMedical');
//     var textPatient = document.querySelector('.textPatient');

//     iconMedical.addEventListener('click', function() {
//         onClick('medical');
//     });
//     iconPatient.addEventListener('click', function() {
//         onClick('patient');
//     });
//     textMedical.addEventListener('click', function() {
//         onClick('medical');
//     });
//     textPatient.addEventListener('click', function() {
//         onClick('patient');
//     });

//     function onClick(event) {
//         switch (event) {
//             case 'medical':
//                 setLoading();
//                 console.log('chamou onClick >> ', event);
//                 break;
//             case 'patient':
//                 console.log('chamou onClick >> ', event);
//                 break
//             default:
//                 break;
//         }
//     }

//     function setLoading() {
//         var container = document.getElementById('container');
//         console.log('container >> ', container);
//         var ctt = container.substring(0, container.indexOf('div'));
//         document.getElementById('container').innerHTML = ctt;
//     }
// });