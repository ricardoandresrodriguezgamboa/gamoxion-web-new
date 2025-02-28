 
  

$(document).ready(function() {

    loadPage('home');
    
    var height = $('#navbarLayout').height();
    var scrollTop = $(window).scrollTop();

    var path = window.location.pathname;
    var pagename = path;
    var windowWidth = $(window).width();


    $('.close').click(function(e) {  
            var url = $('#trailer').attr('src');
            $('#trailer').attr('src', '');
            $('#trailer').attr('src', url);
      });
    
    
  

   


      //Navbar active view

            if(pagename == '/'){

                $('.nav-item').removeClass('active');
                $('.home').addClass('active');

            }else if(pagename == '/games'){
                $('.nav-item').removeClass('active');
                $('.games').addClass('active');

            }else if(pagename == '/advergaming' || pagename == '/appmovil'  || pagename == '/web'  || pagename == '/desktop' || pagename == '/it-solutions' ){
                $('.nav-item').removeClass('active');
                // $('.services').addClass('active');

            }else if(pagename == '/about'){
                $('.nav-item').removeClass('active');
                $('.about').addClass('active');

            }else if(pagename == '/contact'){
                $('.nav-item').removeClass('active');
                $('.contact').addClass('active');

            }
 
  
        //change color transparent to solid

        if($(this).scrollTop() > 10) { 
            $('.navbar').addClass('solid-nav');
            $('.navbar-brand').css('color','#333');
            $('.nav-link').css('color','#333'); 
            $('.fa.fa-navicon').css('color','#333');
            
           
           

        } else {
            $('.navbar').removeClass('solid-nav');
            $('.navbar-brand').css('color','#fff');
            $('.nav-link').css('color','#fff'); 
            $('.fa.fa-navicon').css('color','#fff');

          
        }

        $(window).scroll(function() {

            if($(this).scrollTop() > 10) { 
                $('.navbar').addClass('solid-nav');
                $('.navbar-brand').css('color','#333');
                $('.nav-link').css('color','#333'); 
                $('.fa.fa-navicon').css('color','#333');
 

            } else {
                $('.navbar').removeClass('solid-nav');
                $('.navbar-brand').css('color','#fff');
                $('.nav-link').css('color','#fff'); 
                $('.fa.fa-navicon').css('color','#fff');

              
            }
        

        });
    
});

 



function zooming($id,$url){

    // console.log($id);
    var modal = document.getElementById("myModal");
    var img = document.getElementById($id);
    //var linkid = document.getElementById($linkid);
    var modal = document.getElementById("myModal");
    var modalImg = document.getElementById("img01");
    var modalLink = document.getElementById("link01");

    modal.style.display = "block";
    modalImg.src = img.src;
    //modalLink.setAttribute('href', $url);
    
    // modalLink.setAttribute('target','_blank');
   
    var span = document.getElementById("closeimg");
    span.onclick = function() { 
    modal.style.display = "none";
   

}
    

}

function zooming2(){

    var modal = document.getElementById("trailerModal");

    modal.style.display = "block";
    
    //modalImg.src = img.src;

    
    // modalLink.setAttribute('target','_blank');
   var span = document.getElementsByClassName("close")[0];
span.onclick = function() { 
    modal.style.display = "none";

}




}



function loadPage(page) {
   
    const contentDiv = document.getElementById('content-page');

   
    fetch(`pages/${page}.html`)
        .then(response => response.text())
        .then(data => {
            contentDiv.innerHTML = data;  
        })
        .catch(error => {
            contentDiv.innerHTML = "<p>Error al cargar el contenido.</p>";
            console.error("Error al cargar la página:", error);
        });
}
  
