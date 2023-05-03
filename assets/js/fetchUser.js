async function getData(route, params = "") {
  if (params != "") {
    route += `?${params}`;
  }
  let response = await fetch(route);
  return await response.json();
}

async function postFormData(route, data) {
  let response = await fetch(route, {
    method: "POST",
    body: data,
  });

  return await response.json();
}
