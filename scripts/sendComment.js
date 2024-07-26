async function sendComment(content, smurfs_ID) {
  let response = await fetch("api/newComment.php", {
    method: "POST",
    body: objectToFormData({
      content: content,
      smurfsId: smurfs_ID,
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
