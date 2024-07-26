async function sendVotes(smurfId, intelligence, utility, beauty) {
  let response = await fetch("api/newRating.php", {
    method: "POST",
    body: objectToFormData({
      smurfsId: smurfId,
      intelligence: intelligence,
      utility: utility,
      beauty: beauty,
    }),
  });
  let responseJson = await response.json();
  if (responseJson.info == "vote updated") {
    openPopup("alertPopup");
  }
}
