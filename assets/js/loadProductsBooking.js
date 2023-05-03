let locked = document.querySelectorAll(".locked")
if(locked.length >0){
  document.querySelector(".btn-confirm-order").setAttribute("disabled", "disabled")
}
async function outOnBasketPage(productId, action) {
  let { productInBasket, totalPrice, totalCount } = await postJSON(
    "/app/tables/basket/save.booking.php",
    productId,
    action
  );

  if (totalCount == 0) {
    console.log("fghjk");
    checkForEmpty();
  }

  document.querySelector(".booking-user-info-registr-count").textContent = totalCount.count_car ?? 0;
}

document.addEventListener("click", async (event) => {
  if (event.target.classList.contains("btn-delete-booking")) {
    outOnBasketPage(event.target.dataset.productId, "delete");
    event.target.closest(".car-booking-all").remove();
    checkForEmpty();
  }
  if (event.target.classList.contains("btn-delete-order")) {
    outOnBasketPage(event.target.dataset.productId, "delete");
    event.target.closest(".car-booking-all").remove();
  }
  if (event.target.classList.contains("clear")) {
    outOnBasketPage(event.target.dataset.productId, "clear");
    document.querySelector(".totalPrice").style.display = "none";
    document.querySelector(".totalCount").style.display = "none";
    document.querySelector(".message").textContent = "Добавьте товар в корзину";
    document
      .querySelectorAll(".car-booking-all")
      .forEach((item) => item.remove());
    checkForEmpty();
  }
});

function checkForEmpty() {
  if (
    document.querySelector(".car-booking-all") == null
  ) {
    document.querySelector(".booking-user-info").style.display = "none";
    document.querySelector(".booking").style.display = "none";
    document.querySelector(".booking-two").style.display = "none";
    document.querySelector(".section-basket-null").style.display = "grid";
    document.querySelector(".booking-user-info-registr-count").style.display =
      "none";
    document.querySelector(".message").textContent = "Добавьте товар в корзину";
  }
}

checkForEmpty()