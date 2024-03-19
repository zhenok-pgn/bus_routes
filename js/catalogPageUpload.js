/* class CarCard{
  #images = [];

  constructor(id, brand, model, price, condition, image){
    this.#images.push(image);
    this.id = id;
    this.brand = brand;
    this.model = model;
    this.price = price;
    this.condition = condition;
  }

  addImage(image)
  {
    this.#images.push(image);
  }

  get images()
  {
    return this.#images;
  }
}

window.onload = async () => {
    let params = new URLSearchParams(document.location.search);
    let response = await fetch(`LoadCarsCatalog.php?${params.toString()}`, {
        method: "GET",
    });

    let list = await response.json();

    let dom = document.querySelector(".cars-section");
    dom.innerHTML = renderCard(list.content);
}

const renderCard = (list) => {
    let htmlCode = new Map();
    let count = 0;
    for (const row in list) {
        for (const key in row)
        {
          htmlCode.set(ke)
          htmlCode += `<div class="col w-35">
          <div class="card border-0 rounded-2 p-2 h-100">
            <div id="carouselExampleIndicators${count}" class="carousel slide">
              <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators${count}" data-bs-slide-to="0" class="active bg-info" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators${count}" data-bs-slide-to="1" class="active bg-info" aria-label="Slide 2"></button>
              </div>
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <img src="https://www.tts.ru/upload/iblock/e3b/q7xnj0xvt17f01fg9s07egjza20f87ke/exeed-lx-vnedorozhnik-sky-blue-2.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                  <img src="https://www.tts.ru/upload/iblock/e3b/q7xnj0xvt17f01fg9s07egjza20f87ke/exeed-lx-vnedorozhnik-sky-blue-2.jpg" class="d-block w-100" alt="...">
                </div>
              </div>
            </div>
          <div class="card-body container">
            <div class="row">
              <h6 class="card-title col">Название</h6>
              <div class="col text-end">
                <img src="image/favorites.svg" alt="...">
              </div>
            </div>
            <div class="row">
              <h5 class="card-title">Цена</h5>
            </div>
            <div class="row">
              <p class="col">Основные характеристики автомобиля</p>
            </div>
            <div class="row">
              <div class="col text-center">
                <a href="#" class="btn btn-primary w-100">Забронировать</a>
              </div>               
            </div>
            </div>
          </div>
        </div>`;
        count++;
        }
    }   
    
    return htmlCode;
} */

/* window.onload = async () => {
  let likeButtons = document.querySelectorAll(".like-button");

  likeButtons.forEach(element => {
    if(element.dataset.selected == '1')
      element.onclick
  });

  let response = await fetch(`LoadCarsCatalog.php?${params.toString()}`, {
      method: "GET",
  });

  let list = await response.json();

  let dom = document.querySelector(".cars-section");
  dom.innerHTML = renderCard(list.content);
}


const  = (list) => {

} */