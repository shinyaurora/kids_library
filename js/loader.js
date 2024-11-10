$(document).ready(function () {
    // Progress bar starts moving when the page begins to load
    let progressBar = $('.progress-bar');

    // Increment the progress bar over time to simulate loading
    let progress = 0;

    function updateProgressBar() {
        // Increase progress value
        progress += 5;

        // Update progress bar width
        progressBar.css('width', progress + '%');

        // Stop once it reaches 90% (full loading will complete when the page finishes loading)
        if (progress < 90) {
            setTimeout(updateProgressBar, 200); // Adjust speed if needed
        }

        console.log(progress);
        
    }

    // Start the simulated loading progress
    updateProgressBar();

    // When the page is fully loaded, set progress to 100%
    $(window).on('load', function () {
        progressBar.css('width', '100%');
        progress = 100;

        // Fade out the progress bar after loading completes
        setTimeout(function () {
            $('.loader').fadeOut();

            setTimeout(function () {
                $(".search, .title, .content, .dogImg, .dogHouse, .footerContent").css("opacity", "1");
            }, 500);
        }, 500); // Adjust delay if needed
    });
});