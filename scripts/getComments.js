async function getComments(smurfId) {
  let response = await fetch("api/getComments.php", {
    method: "POST",
    body: objectToFormData({
      smurfsID: smurfId,
    }),
  });
  let responseJson = await response.json();
  return responseJson;
}
