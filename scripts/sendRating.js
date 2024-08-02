async function sendVotes(smurfId, intelligence, utility, sympathy) {
  let response = await fetch("api/newRating.php", {
    method: "POST",
    body: objectToFormData({
      smurfsId: smurfId,
      intelligence: intelligence,
      utility: utility,
      sympathy: sympathy,
    }),
  });
  let responseJson = await response.json();
  if (responseJson.info == "vote updated") {
    openPopup("alertPopup");
  }
}
