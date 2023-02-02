'use strict';
let element = document.getElementById("floatingCelect");
element.onchange = function () {
    let techacademy = this.value;
    document.getElementById('box').textContent = techacademy;
}

// const buttonOpen = document.getElementById('modalOpen');
// const modal = document.getElementById('easyModal');
// const buttonClose = document.getElementsByClassName('modalClose')[0];

// // ボタンがクリックされた時
// buttonOpen.addEventListener('click', modalOpen);
// function modalOpen() {
//     modal.style.display = 'block';
// }

// // バツ印がクリックされた時
// buttonClose.addEventListener('click', modalClose);
// function modalClose() {
//     modal.style.display = 'none';
// }

// // モーダルコンテンツ以外がクリックされた時
// addEventListener('click', outsideClose);
// function outsideClose(e) {
//     if (e.target == modal) {
//         modal.style.display = 'none';
//     }
// }
// var xhr = new XMLHttpRequest();
// xhr.open('POST', 'register_plant_form.php');
// xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
// xhr.onload = function () {
//   if (xhr.status === 200 && xhr.responseText !== "") {
//     console.log('Success: ' + xhr.responseText);
//   } else if (xhr.status !== 200) {
//     console.log('Error: ' + xhr.status);
//   }
// };
// xhr.send('selected-value=' + encodeURIComponent(document.getElementById('floatingCelect').value));
