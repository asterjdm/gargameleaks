async function getComments(smurfId) {
  let response = await fetch("api/getComments.php", {
    method: "POST",
    body: objectToFormData({
      teacherID: smurfId,
    }),
  });
  let responseJson = await response.json();
  return responseJson;
}
