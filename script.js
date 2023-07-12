var carousel = document.getElementById('carousel');
let x=0;

// Delete confirmation alert

function confirmDelete() {
    return confirm("Confirmer la suppression ?");
}


// Carousel

var autoCarousel = () => {setTimeout(() => {
    var backgroundCollection = ['url("./images_ref/carousel1.JPG")','url("./images_ref/carousel2.JPG")','url("./images_ref/carousel3.JPG")','url("./images_ref/carousel4.JPG")','url("./images_ref/carousel5.jpeg")']
    carousel.style.backgroundImage = backgroundCollection[x];
    if(x<4){x+=1}else{x=0}
        
    autoCarousel()
},5000);              
}

autoCarousel();


// Prevent Right Click

window.addEventListener('contextmenu', function (e) {
    e.preventDefault();
});


