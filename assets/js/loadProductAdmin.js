document.addEventListener("DOMContentLoaded", () => {
  let productsConteiner = document.querySelector(".product-tables");
  let productStatus = document.querySelectorAll("[name='btn-status']");
  let products = [];

  getProducts("all");

  productStatus.forEach((item) => {
    item.addEventListener("click", async (e) => {
      await getProducts(e.currentTarget.dataset.statusId);
    });
  });

  async function getProducts(status) {
    const param = new URLSearchParams();
    param.append("status_id", status);

    products = await getData("/app/admin/tables/search.check.php", param);
    outOnPage(products);
  }

  function outOnPage(product) {
    productsConteiner.innerHTML = ``;
    product.forEach((item) => {
      productsConteiner.insertAdjacentHTML("beforeend", createCard(item));
    });
  }

  function createCard({ model, body, number, satus_car }) {
    return `<tr>
        <td>${model} ${body}</td>
        <td>${number}</td>
        <td>${satus_car}</td>
    </tr>`;
  }
});
