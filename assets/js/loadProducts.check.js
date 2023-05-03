document.addEventListener("DOMContentLoaded", () => {
  let productsContainer = document.querySelector(".products");
  let hfhf = document.querySelector(".products");
  let buttonsFilter = document.querySelectorAll(".button-filter");
  let products = [];

  getProducts("all");

  buttonsFilter.forEach((item) => {
    item.addEventListener("click", async (event) => {
      await getProducts(event.currentTarget.dataset.bodyId);
    });
  });

  document.querySelector(".button-filter-all").addEventListener("click", () => {
    getProducts("all");
  });

  async function getProducts(body) {
    const param = new URLSearchParams();
    param.append("body", body);
    res = await getData("/app/tables/product/search.check.php", param);
    outOnPage(res);
  }

  function outOnPage(data) {
    productsContainer.innerHTML = ``;
    data.bodies.forEach((body) => {
      productsContainer.insertAdjacentHTML("beforeend", createCardBody(body));
      let automobyle = data.automobiles.filter((item) => {
        return item.body_id == body.id;
      });
      let automobilesContainer = document.querySelector(
        `[data-category='${body.id}']`
      );

      automobyle.forEach((item) => {
        automobilesContainer.insertAdjacentHTML(
          "beforeend",
          createCardAutomobyle(item)
        );
      });
    });
  }

  function createCardBody({ name, id }) {
    return `<p class="car-hatchback">${name}</p>
    <hr class="vertikal-car">
    <div class="catalog-cars" data-category="${id}"></div>
    `;
  }

  function createCardAutomobyle({
    id,
    model,
    photo,
    price_hour,
    transmission,
    speed,
    power,
  }) {
    return `  
                        <div class="product">
                            <br>
                            <p class="model-name">${model}</p>
                            <img src="/upload/cars/${photo}" alt="">
                            <p class="catalog-price-car">${price_hour} ₽ в сутки</p>
                            <div class="car-info">
                                <p>${transmission}</p>
                                <hr>
                                <p>${speed} км/ч</p>
                                <hr>
                                <p>${power} л.с</p>
                            </div>
                            <div class="button-catalog">
                                <a href="/app/tables/product/show.php?id=${id}" class="btn btn-primary button-catalog-car">Информация</a>
                                <button id="btn-${id}" data-btn-id="${id}" class="btn-basket btn btn-primary button-catalog-car">Забронировать</button>
                            </div>`;
  }

  document.addEventListener("click", async (event) => {
    if (event.target.classList.contains("btn-basket")) {
      let id = event.target.dataset.btnId;
      await postJSON("/app/tables/basket/save.booking.php", id, "add");
    }
  });
});
