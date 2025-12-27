document.addEventListener('DOMContentLoaded', function() {
    // Add a confirmation dialog for all delete links/buttons
    const deleteLinks = document.querySelectorAll('.delete-link');

    deleteLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            const confirmation = confirm('Are you sure you want to delete this item?');
            if (!confirmation) {
                event.preventDefault(); // Stop the link from being followed
            }
        });
    });
});