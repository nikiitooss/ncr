document.addEventListener("DOMContentLoaded", () => {
  let startDateOfDay = document.querySelectorAll(".start-date-of-day");
  let startDateOfMonths = document.querySelectorAll(".start-date-of-month");
  let startDateOfYear = document.querySelectorAll(".start-date-of-year");

  let endDateOfDay = document.querySelectorAll(".end-date-of-day");
  let totalSum = document.querySelector(".booking-user-info-sum");
  let sum = 0;
  let elementDay = 0;
  let month;

  document.addEventListener("click", function (e) {
    if (e.target.classList.contains("end-date-of-day")) {
      let day = e.target.value;
      let priceCar = e.target.dataset.price;
      let productId = e.target.dataset.carId;
      document.querySelector(
        `[data-res-product-id = '${productId}']`
      ).textContent = day * priceCar;
      getSum();
    }
  });

  let monthArray = [
    { name: "январь", days: 31 },
    { name: "февраль", days: 28 },
    { name: "март", days: 31 },
    { name: "апрель", days: 30 },
    { name: "май", days: 31 },
    { name: "июнь", days: 30 },
    { name: "июль", days: 31 },
    { name: "август", days: 31 },
    { name: "сентябрь", days: 30 },
    { name: "октябрь", days: 31 },
    { name: "ноябрь", days: 30 },
    { name: "декабрь", days: 31 },
  ];

  let strDay = ``;
  let strEndDay = ``;
  let strMonth = ``;

  function loadDays(element, index, str) {
    month = monthArray[index];
    for (let i = 1; i <= month.days; i++) {
      str += `<option value="${i}">${i}</option>`;
    }
    element.innerHTML = str;
  }

  monthArray.forEach((item, index) => {
    strMonth += `<option value="${index+1}">${item.name}</option>`;
  });

  startDateOfMonths.forEach((element) => {
    element.innerHTML = strMonth;
  });

  startDateOfDay.forEach((element) => {
    loadDays(element, 0, strDay);
  });

  endDateOfDay.forEach((element) => {
    loadDays(element, 0, strEndDay);
  });

  startDateOfMonths.forEach((element) => {
    element.addEventListener("change", (e) => {
      elementDay = element.nextElementSibling;
      loadDays(elementDay, e.target.value, strDay);
    });
  });

  let date = new Date();
  let year = date.getFullYear();
  let strYear = ``;
  let strEndYear = ``;
  for (let i = 1; i <= 3; i++) {
    strYear += `<option value="${year}">${year}</option>`;
    strEndYear += `<option value="${year}">${year}</option>`;
    year++;
  }

  startDateOfYear.forEach((element) => {
    element.innerHTML = strYear;
  });

  function getSum() {
    sum = 0;
    let price = document.querySelectorAll(".price");
    price.forEach((item) => {
      sum = sum + +item.textContent;
    });

    totalSum.textContent = sum;
  }
  getSum();
  // dataAll();
});
document.addEventListener("change", function (e) {
  if (e.target.classList.contains("booking-date")) {
    let day = document.querySelector(
      `#start-date-of-day${e.target.dataset.prodId}`
    ).value;
    let month = document.querySelector(
      `#start-date-of-month${e.target.dataset.prodId}`
    ).value;
    let year = document.querySelector(
      `#start-date-of-year${e.target.dataset.prodId}`
    ).value;
    let dopDni = document.querySelector(
      `#dop_dni${e.target.dataset.prodId}`
    ).value;
    let date_start = document.querySelector(
      `#date_start${e.target.dataset.prodId}`
    );
    let endDate = document.querySelector(`#date_end${e.target.dataset.prodId}`);

    dataAll(year, month, day , dopDni,date_start,endDate);
  }
});

function dataAll(year,month,day, dopDni,date_start,endDate) {
  let date = new Date();
  date.setFullYear(year, month, day);
  let formatDateStart =
    date.getFullYear() + "-" + (date.getMonth()) + "-" + date.getDate();
  date.setDate(date.getDate() + +dopDni);
  let formatDateEnd =
    date.getFullYear() + "-" + (date.getMonth()) + "-" + date.getDate();
  
  date_start.textContent = formatDateStart;
  endDate.textContent = formatDateEnd;
}


