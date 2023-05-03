async function outOnBasketPage(productId, action) {
  await postJSON(
    "/app/admin/tables/save.admin.php",
    productId,
    action
  );
}

document.addEventListener("click", async (event) => {
  if (event.target.classList.contains("btn-delete-category")) {
    outOnBasketPage(event.target.dataset.productId, "deleteCategory");
    event.target.closest(".tr-category").remove();
  }
  if (event.target.classList.contains("btn-delete-speed")) {
    outOnBasketPage(event.target.dataset.productId, "deleteSpeed");
    event.target.closest(".tr-speed").remove();
  }
  if (event.target.classList.contains("btn-delete-model")) {
    outOnBasketPage(event.target.dataset.productId, "deleteModel");
    event.target.closest(".tr-model").remove();
  }
  if (event.target.classList.contains("btn-delete-admin")) {
    outOnBasketPage(event.target.dataset.productId, "deleteAdmin");
    event.target.closest(".tr-admin").remove();
  }
  if (event.target.classList.contains("delete-product")) {
    outOnBasketPage(event.target.dataset.productId, "deleteProduct");
    event.target.closest(".tr-product").remove();
  }
});
