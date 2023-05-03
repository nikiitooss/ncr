document.addEventListener("DOMContentLoaded", () => {
  let user = document.querySelector(".user");
  let modalWrapper = document.querySelector(".modal-wrapper");
  let modalClose = document.querySelector(".modal__close");
  let modal = document.querySelector(".modal");
  let sign = document.querySelector(".sign");
  let reg = document.querySelector(".reg");
  let btnBasketNoIin = document.querySelector(".btn-basket-no-in");

  if (user != null) {
    user.addEventListener("click", (e) => {
      e.preventDefault();
      modalWrapper.style.display = "block";
      modal.style.display = "block";
    });
  }

  let closeModal = () => (modalWrapper.style.display = "none");

  document.addEventListener("keyup", (e) => {
    if (e.key == "Escape") {
      closeModal();
    }
  });

  if (btnBasketNoIin != null)
    btnBasketNoIin.addEventListener("click", (e) => {
      e.preventDefault();
      modalWrapper.style.display = "block";
      modal.style.display = "block";
    });

  modalClose.onclick = function () {
    closeModal();
  };

  reg.addEventListener("click", () => {
    document.querySelector(".modal__content").innerHTML = `
    <form class="entrance" action="" method="POST" id="form-reg">
        <input type="hidden" name="action" value="reg">
        <input class="entrance-input" type="text" placeholder="Имя" name="name">
        <input class="entrance-input" type="text" placeholder="Фамилия" name="surname">
        <input class="entrance-input" type="date" placeholder="Дата рождения" name="data_of_birth">
        <input class="entrance-input" type="phone" placeholder="Телефон" name="phone">
        <input class="entrance-input" type="password" placeholder="Пароль" name="password">
        <input class="entrance-input" type="password" name="password_confirmation" placeholder="Подтвердите пароль">
        <p class="error-modal"></p>
        <div class="agreem">
            <input checked type="checkbox" name="agreement" id="agreement">
            <label for="agreement">Согласен на обработку персональных данных</label>
        </div>
        <button class="btn-reg btn-modal" name="btn-reg">
            <h3>Зарегестрироваться</h3>
        </button>
     </form>`;
    document.querySelector(".text-header-auth").textContent = "Регистрация";
    document.querySelector(".sign").style.display = "block";
    modal.style.height = "625px";
    modalWrapper.style.paddingTop = "2.5rem";
    reg.style.borderBottom = "1px solid white";

    document.querySelector("#agreement").addEventListener("change", (e) => {
      document.querySelector(".btn-reg").disabled = !e.target.checked;
    });

    document
      .querySelector(".btn-reg")
      .addEventListener("click", async (event) => {
        let form = document.querySelector("#form-reg");
        event.preventDefault();
        let fd = new FormData(form);
        let res = await postFormData("/app/tables/users/save.user.php", fd);
        console.log(typeof res.error);
        if (res.error != null) {
          document.querySelector(".error-modal").style.display = "block";
          document.querySelector(".error-modal").textContent = res.error;
        } else {
          closeModal();
          window.location.reload();
        }
      });
  });

  sign.addEventListener("click", () => {
    document.querySelector(".modal__content").innerHTML = `
          <form class="entrance" action="" method="POST" id="form-auth">
              <input type="hidden" name="action" value="auth">
              <input class="entrance-input" type="text" placeholder="Логин" name="text">
              <input class="entrance-input" type="password" placeholder="Пароль" name="password">
              <p class="error-modal"></p>
              <button class="btn-auth btn-modal" name="btnAuth">
                  <h3>Войти</h3>
              </button>
              <div class="btn-modal-reg">
                  <p class="text-gray">Нет учетной записи?</p>
                  <button class="btn-modal-header reg">
                      <p>Создайте её.</p>
                  </button>
              </div>
          </form>`;
    document.querySelector(".sign").style.display = "none";
    document.querySelector(".text-header-auth").textContent = "Авторизация";
    modal.style.height = "370px";
    modalWrapper.style.paddingTop = "8rem";
    reg.style.borderBottom = "none";
    sign.style.borderBottom = "1px solid white";
  });

  document
    .querySelector(".btn-auth")
    .addEventListener("click", async (event) => {
      let form = document.querySelector("#form-auth");
      event.preventDefault();
      let fd = new FormData(form);
      let res = await postFormData("/app/tables/users/save.user.php", fd);
      console.log(res);
      if (res.user == null) {
        document.querySelector(".error-modal").style.display = "block";
        document.querySelector(".error-modal").textContent = res.error;
      } else {
        closeModal();
        window.location.reload();
      }
    });
});
