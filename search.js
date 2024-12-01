
const toggleIcon = document.querySelector('.toggle-icon');
const searchSidebar = document.getElementById('searchSidebar');
const closeicon = document.getElementById('closeSidebar');


toggleIcon.addEventListener('mouseenter', () => {
  searchSidebar.style.left = '0'; 
});

// closeicon.addEventListener('click', ()=> {
//     console.log("Close Button Clicked")
//     searchSidebar.style.left = '-300px';
// });


searchSidebar.addEventListener('mouseleave', ()=> {
        searchSidebar.style.left = '-300px';
    });


    document.getElementById('filterForm').addEventListener('input', function () {
      const searchQuery = document.querySelector('input[type="search"]').value;
      const departments = Array.from(document.querySelectorAll('input[type="checkbox"]:checked'))
          .filter(el => el.id.endsWith("CheckBox"))
          .map(el => el.value);
      const floors = Array.from(document.querySelectorAll('input[type="checkbox"]:checked'))
          .filter(el => el.id.endsWith("FloorRadio"))
          .map(el => el.value);
      const capacity = document.getElementById('capacity').value;
      const bookingTime = document.getElementById('bookingTime').value;
  
      const filters = {
          searchQuery,
          departments,
          floors,
          capacity,
          bookingTime
      };
  
      // AJAX POST request
      fetch('filter_rooms.php', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json'
          },
          body: JSON.stringify(filters)
      })
          .then(response => response.text())
          .then(data => {
              document.getElementById('cardsSection').innerHTML = data;
          })
          .catch(error => console.error('Error:', error));
  });
  

  

