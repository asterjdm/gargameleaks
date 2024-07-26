const smurfsCards = document.getElementById("smurfsCards");

function getStarsHtml(n) {
  let starsHtml = "";
  const fullStars = Math.floor(n / 2);
  const hasHalfStar = n % 2 !== 0;

  for (let i = 0; i < 5; i++) {
    if (i < fullStars) {
      starsHtml += `<label class='star star-full'></label>`;
    } else if (i === fullStars && hasHalfStar) {
      starsHtml += `<label class='star star-half'></label>`;
    } else {
      starsHtml += "<label class='star'></label>";
    }
  }
  return starsHtml;
}

function addSmurfs(smurfs) {
  let mdrr = [
    "Francoi holland",
    "Le bon vieu Staline",
    "Donald Trump",
    "Ta grand mère",
    "Vlad Poutine",
    "Macron",
    "Satoshie Nakamoto",
    "Ton grand père",
    "Ta mère",
    "Ton père",
  ];

  let htmlResult = "";
  smurfs.forEach((smurfs) => {
    htmlResult += /*html*/ `
      <div class="standard-card">
        <div class="standard-card-top">
          <img
            class="standard-card-image"
            src="${smurfs.image_url}"
            onerror="this.onerror=null; this.src='images/default.png'"
            alt="${mdrr[Math.floor(Math.random() * mdrr.length)]}"
          />
          <div class="standard-card-top-right">
            <h1 class="standard-card-name">${smurfs.name}</h1>
            <button
              class="standard-button standard-card-top-right-button"
              onclick="openRatingPopup('ratingPopup',${smurfs.ID})"
            >
              Voter
            </button>
          </div>
        </div>

        <div class="standard-card-stars-container">
          <p class="standart-card-stars-text">Moyenne <span style='text-transform: lowercase'>(${
            smurfs.votes_count
          } ${smurfs.votes_count >= 2 ? "votes" : "vote"})</span></p>

          <div class="standard-card-stars">
            ${getStarsHtml(
              Math.round(
                (smurfs.intelligence + smurfs.utility + smurfs.sympathy) /
                  3
              )
            )}
          </div>


          <p class="standart-card-stars-text">Humour</p>
          <div class="standard-card-stars">${getStarsHtml(smurfs.sympathy)}</div>

          <p class="standart-card-stars-text">Qualité des cours</p>
          <div class="standard-card-stars">
            ${getStarsHtml(smurfs.intelligence)}
          </div>

          <p class="standart-card-stars-text">Sympathie</p>
          <div class="standard-card-stars">
            ${getStarsHtml(smurfs.utility)}
          </div>
        </div>
        <!-- Open comments popup -->
        <div
          class="standard-button standard-card-button"
          onclick="openCommentsPopup('commentPopup', ${smurfs.ID})"
        >
          Lire les avis (${smurfs.comments_count})
        </div>
      </div>
    `;
  });

  smurfsCards.innerHTML = htmlResult;
}

getSmurfs(
  document.getElementById("searchBar").value,
  document.getElementById("sortSmurfs").value
).then(function (smurfs) {
  addSmurfs(smurfs);
});
