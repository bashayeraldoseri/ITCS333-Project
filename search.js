
const toggleIcon = document.querySelector('.toggle-icon');
const searchSidebar = document.getElementById('searchSidebar');
const closeicon = document.getElementById('closeSidebar');


toggleIcon.addEventListener('mouseenter', () => {
  searchSidebar.style.left = '0'; // Show the sidebar on hover
});

// closeicon.addEventListener('click', ()=> {
//     console.log("Close Button Clicked")
//     searchSidebar.style.left = '-300px';
// });


searchSidebar.addEventListener('mouseleave', ()=> {
        searchSidebar.style.left = '-300px';
    });




  

