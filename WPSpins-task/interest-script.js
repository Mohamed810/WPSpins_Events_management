document.addEventListener('DOMContentLoaded', function() {
    var modal = document.querySelector('.modal');
    var popupButtons = document.querySelectorAll('.popup-button');
    var closeButton = modal.querySelector('.close');
    var interestedButtons = modal.querySelectorAll('.interested-button');
    var interestedList = modal.querySelector('.interested-list');
    var seeMoreButton = modal.querySelector('.see-more');
    var seeLessButton = modal.querySelector('.see-less');

    popupButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            modal.style.display = 'block';
        });
    });

    closeButton.addEventListener('click', function() {
        modal.style.display = 'none';
    });

    seeMoreButton.addEventListener('click', function() {
        interestedList.style.display = 'inline';
        seeMoreButton.style.display = 'none';
        seeLessButton.style.display = 'inline';
    });

    seeLessButton.addEventListener('click', function() {
        interestedList.style.display = 'none';
        seeMoreButton.style.display = 'inline';
        seeLessButton.style.display = 'none';
    });
});