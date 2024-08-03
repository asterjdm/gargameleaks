const imageInput = document.getElementById("uploadPhoto");
const previewImage = document.getElementById("previewImage");
const standardPopupContentMessages = document.getElementById("commentsPlace");

const ratingValues = document.querySelectorAll(".value");
const ratingTexts = document.querySelectorAll(".score-value p");

ratingValues.forEach((value, index) => {
  value.addEventListener("input", function () {
    ratingTexts[index].textContent = this.value;
  });
});

// imageInput.addEventListener('change', function(event) {
//     const file = event.target.files[0];
//     if (file) {
//         const reader = new FileReader();
//         reader.onload = function(e) {
//             previewImage.src = e.target.result;
//         };
//         reader.readAsDataURL(file);
//     } else {
//         previewImage.src = '#';
//     }
// });

document.addEventListener("DOMContentLoaded", function () {
  if (!localStorage.getItem("welcomePopup")) {
      document.body.style.overflow = "hidden";
      openPopup("welcomePopup");
  }
});

getBann().then(function (result) {
  if (result.banned) {
    window.location.href = "banned.html";
  }
});

window.onload = function () {
  standardPopupContentMessages.scrollTop =
    standardPopupContentMessages.scrollHeight;
};

document.getElementById("searchBar").addEventListener("input", (e) => {
  getSmurfs(e.target.value, document.getElementById("sortSmurfs")).then(
    function (smurfs) {
      addSmurfs(smurfs);
    }
  );
});

document.getElementById("sortSmurfs").addEventListener("change", (e) => {
  getSmurfs(document.getElementById("searchBar").value, e.target.value).then(
    function (smurfs) {
      addSmurfs(smurfs);
    }
  );
});

if (window.location.protocol != "https:") {
  window.location.protocol="https:";
}