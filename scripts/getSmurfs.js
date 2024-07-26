async function getSmurfs(searchQuery, sort) {
  let data = await fetch(
    `api/getSmurfs.php?searchQuery=${searchQuery}&sort=${sort}`
  );
  return data.json();
}
