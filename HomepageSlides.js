
var leftSlide = document.getElementById("leftSlide");
var rightSlide = document.getElementById("rightSlide");

var slide1 = document.getElementById("slide1");
var slide2 = document.getElementById("slide2");

function goToSlide1()
{
	slide2.style.display = "none";
	slide1.style.display = "block";
	leftSlide.style.backgroundColor = "white";
	rightSlide.style.backgroundColor = "#cce6ff";
}

function goToSlide2()
{
	slide1.style.display = "none";
	slide2.style.display = "block";
	rightSlide.style.backgroundColor = "white";
	leftSlide.style.backgroundColor = "#cce6ff";
}