const hamburger = document.querySelector('.hamburger');
const list = document.querySelector('.list');
hamburger.addEventListener('click', function(){
    list.classList.toggle('show');
});
var image=["images/food.jpg","images/music.jpg","images/sports.jpg","images/travel.jpg"];
var  i=0;
function prev()
{
    if(i==0){
        i=image.length-1;
        document.getElementById("sliderImg").src=image[i];
        i--;
    }
    else if(i<=(image.length)){
        i=i-1;
        document.getElementById("sliderImg").src=image[i];
        i--;
    }
    else{
        i=0;
    }
}
function next()
{
    document.getElementById("sliderImg").src=image[i];
    if(i<(image.length-1))
        i++;
    else
        i=0;

}
function slides()
{
    document.getElementById("sliderImg").src=image[i];
    if(i<(image.length-1))
        i++;
    else
        i=0;
    
}
setInterval(slides,3000)