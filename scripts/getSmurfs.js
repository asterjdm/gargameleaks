async function getSmurfs(searchQuery, sort) {
  let data = await fetch(
    `api/getSmurfs.php?searchQuery=${searchQuery}&sort=${sort}`
  );
  console.log(data);
  return data.json();

}
