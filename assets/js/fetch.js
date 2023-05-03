async function getData(route, params = "") {
    if (params != "") {
      route += `?${params}`;
    }
    let response = await fetch(route);
    return await response.json();
  }
  
  async function postJSON(route, data, action) {
    let response = await fetch(route, {
      method: "POST",
      headers: {
        "Content-Type": "application/json;charset=UTF-8",
      },
      body: JSON.stringify({ data, action }),
    });
  
    return await response.json();
  }