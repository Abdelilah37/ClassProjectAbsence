
    var popup = document.getElementById('popup');
    var overlay = document.getElementById('overlay');
    var openPopupButton = document.getElementById('openPopup');
    var closePopupButton = document.getElementById('button-cancel');
   
    function openPopup() {
        popup.style.display = 'block';
        overlay.style.display = 'block';
        setTimeout(() => {
            popup.classList.add('active');
            overlay.classList.add('active');
        }, 50); // Adding a slight delay for better transition
    }
    function closePopup() {
        popup.classList.remove('active');
        overlay.classList.remove('active');
        setTimeout(() => {
            overlay.style.display = 'none';
            popup.style.display = 'none';
        }, 300); // Assuming the transition duration is 300ms
    }
    openPopupButton.addEventListener('click', openPopup);
    closePopupButton.addEventListener('click', closePopup);
    // Add event listener to close pop-up when clicking outside
    document.getElementById('button-cancel').addEventListener('click', closePopup);
