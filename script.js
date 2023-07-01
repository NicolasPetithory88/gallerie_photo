var carousel = document.getElementById('carousel');
let x=0;

// Delete confirmation alert

function confirmDelete() {
    return confirm("Confirmer la suppression ?");
}


// Carousel

var autoCarousel = () => {setTimeout(() => {
    var backgroundCollection = ['url("./images_ref/1666340701_0011.jpg")','url("./images_ref/1666340735_0022.jpg")','url("./images_ref/1666340761_0033.jpg")']
    carousel.style.backgroundImage = backgroundCollection[x];
    if(x<2){x+=1}else{x=0}
        
    autoCarousel()
},5000);              
}

autoCarousel();


// Prevent Right Click

// window.addEventListener('contextmenu', function (e) {
//     e.preventDefault();
// });