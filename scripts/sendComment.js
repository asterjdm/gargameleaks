async function sendComment(content, smurf_ID) {
  let response = await fetch("api/newComment.php", {
    method: "POST",
    body: objectToFormData({
      content: content,
      smurfsId: smurf_ID,
    }),
  });
  let responseJson = await response.json();
  //   if (responseJson.info == "vote updated") {
  //     alert("Votre vote a été mis a jour");
  //   }
  if (responseJson.error == "banned") {
    window.location.reload();
  }
}
