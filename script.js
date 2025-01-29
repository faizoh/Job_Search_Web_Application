document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const searchInput = document.getElementById('search');

    form.addEventListener('submit',function(event) {
        event.preventDefault();

        const searchTerm = searchInput.value.trim();

        if (searchTerm) {
            alert('You searched for: ${searchTerm}');
        }
        else {
            alert('Please enter a search term.');
        }
    });
});