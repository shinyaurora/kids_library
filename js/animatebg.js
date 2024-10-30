// function flyBird(birdElement, duration) {
//     function startFlying() {
//         const screenHeight = window.innerHeight;
//         const screenWidth = window.innerWidth;
//         // Random starting point on Y-axis
//         const randomY = Math.random() * (screenHeight - birdElement.offsetHeight);

//         // Ensure the bird is off-screen initially
//         birdElement.style.left = `-100px`;
//         birdElement.style.top = `${randomY}px`;
//         birdElement.style.visibility = 'visible';  // Make the bird visible when starting

//         // Animate bird from left to right, then reset after flying across the screen
//         const animation = birdElement.animate([
//             { transform: 'translateX(0)' },  // Start at -100px (off-screen left)
//             { transform: `translateX(${screenWidth + 100}px)` }  // Fly across to right (100px past screen width)
//         ], {
//             duration: duration,
//             iterations: 1,  // Run animation once
//             easing: 'linear'
//         });

//         // When the bird finishes flying, restart the process with a new random Y position
//         animation.onfinish = startFlying;
//     }

//     startFlying();
// }


// function flyBalloon(balloonElement, duration) {
//     function startFlying() {
//         const screenHeight = window.innerHeight;
//         const screenWidth = window.innerWidth;
//         // Random starting point on X-axis
//         const randomX = Math.random() * (screenWidth - balloonElement.offsetWidth);
//         console.log(screenWidth, randomX);


//         // Ensure the balloon is off-screen at the bottom initially
//         balloonElement.style.left = `${randomX}px`;
//         balloonElement.style.top = `${screenHeight + 100}px`;

//         // Show the balloon
//         balloonElement.style.visibility = 'visible';

//         // Animate the balloon from bottom to top
//         const animation = balloonElement.animate([
//             { transform: 'translateY(0)' },  // Start at the bottom
//             { transform: `translateY(-${screenHeight + 200}px)` }  // Fly upwards, off-screen
//         ], {
//             duration: duration,
//             iterations: 1,  // Run animation once
//             easing: 'linear'
//         });

//         // When the balloon finishes flying, restart the process with a new random X position
//         animation.onfinish = startFlying;
//     }

//     startFlying();
// }

// window.onload = function () {
//     // Birds start flying with different speeds
//     flyBird(document.getElementById('bird1'), 10000);  // Far bird (small)
//     flyBird(document.getElementById('bird2'), 7000);   // Middle bird
//     flyBird(document.getElementById('bird3'), 5000);   // Near bird (big)

//     flyBalloon(document.getElementById('balloon1'), 29000);  // Small balloon (far away)
//     flyBalloon(document.getElementById('balloon2'), 20000);  // Medium balloon (closer)
//     flyBalloon(document.getElementById('balloon3'), 15000);  // Large balloon (nearest)
// };
let birds = [];

function flyBird(birdElement, duration) {
    const screenHeight = window.innerHeight;
    const screenWidth = window.innerWidth;

    function startFlying() {
        // Random starting point on Y-axis (vertical)
        const randomY = Math.random() * (screenHeight - birdElement.offsetHeight);

        // Start the bird off-screen at the right
        birdElement.style.top = `${randomY}px`;
        birdElement.style.left = `${screenWidth + 100}px`;  // Off-screen to the right

        // Make the bird visible
        birdElement.style.visibility = 'visible';

        // Animate the bird moving from right to left
        const animation = birdElement.animate([
            { transform: 'translateX(0)' },  // Start position (right)
            { transform: `translateX(-${screenWidth + 200}px)` }  // Fly off-screen (left)
        ], {
            duration: duration,
            iterations: 1,
            easing: 'linear'
        });

        // When the animation finishes, restart the flight
        animation.onfinish = startFlying;

        // Store the bird's animation reference for handling resize events
        birds.push({ birdElement, animation, duration });
    }

    startFlying();
}

let balloons = [];

function flyBalloon(balloonElement, duration) {

    function startFlying() {
        const screenHeight = window.innerHeight;
        const screenWidth = window.innerWidth;
        // Random starting point on X-axis
        const randomX = Math.random() * (screenWidth - balloonElement.offsetWidth);

        // Start the balloon off-screen at the bottom
        balloonElement.style.left = `${randomX}px`;
        balloonElement.style.top = `${screenHeight + 100}px`;

        // Make the balloon visible
        balloonElement.style.visibility = 'visible';

        // Animate the balloon moving from bottom to top
        const animation = balloonElement.animate([
            { transform: 'translateY(0)' },  // Start position
            { transform: `translateY(-${screenHeight + 200}px)` }  // Move up off-screen
        ], {
            duration: duration,
            iterations: 1,
            easing: 'linear'
        });

        // When the animation finishes, restart the flight
        animation.onfinish = startFlying;

        // Store the balloon's animation reference for handling resize events
        balloons.push({ balloonElement, animation, duration });
    }

    startFlying();
}

// Handle window resize
function onResize() {
    const screenHeight = window.innerHeight;
    const screenWidth = window.innerWidth;

    // Restart all bird animations
    birds.forEach(({ birdElement, animation, duration }) => {
        // Cancel the current animation
        animation.cancel();

        // Ensure the bird's position is within the new screen dimensions
        let randomY = Math.random() * (screenHeight - birdElement.offsetHeight);
        if (parseInt(birdElement.style.top, 10) > screenHeight) {
            randomY = screenHeight - birdElement.offsetHeight;  // Keep within screen
        }

        // Reset bird position
        birdElement.style.top = `${randomY}px`;
        birdElement.style.left = `${screenWidth + 100}px`;  // Start again from right

        // Restart the animation
        const newAnimation = birdElement.animate([
            { transform: 'translateX(0)' },  // Start at right
            { transform: `translateX(-${screenWidth + 200}px)` }  // Move to left
        ], {
            duration: duration,
            iterations: 1,
            easing: 'linear'
        });

        // On finish, restart the flying motion
        newAnimation.onfinish = function () {
            flyBird(birdElement, duration);
        };

        // Update the stored animation reference
        birds = birds.map(b => b.birdElement === birdElement ? { birdElement, animation: newAnimation, duration } : b);
    });

    // Restart all balloon animations
    balloons.forEach(({ balloonElement, animation, duration }) => {
        // Cancel the current animation
        animation.cancel();

        // Ensure the balloon's position is within the new screen dimensions
        let randomX = Math.random() * (screenWidth - balloonElement.offsetWidth);
        if (parseInt(balloonElement.style.left, 10) > screenWidth) {
            randomX = screenWidth - balloonElement.offsetWidth;  // Keep within screen
        }

        // Reset balloon position to avoid it being cut off after resizing
        balloonElement.style.left = `${randomX}px`;
        balloonElement.style.top = `${screenHeight + 100}px`;  // Start again from bottom

        // Restart the animation
        const newAnimation = balloonElement.animate([
            { transform: 'translateY(0)' },  // Start from bottom
            { transform: `translateY(-${screenHeight + 200}px)` }  // Move to top
        ], {
            duration: duration,
            iterations: 1,
            easing: 'linear'
        });

        // On finish, restart the flying motion
        newAnimation.onfinish = function () {
            flyBalloon(balloonElement, duration);
        };

        // Update the stored animation reference
        balloons = balloons.map(b => b.balloonElement === balloonElement ? { balloonElement, animation: newAnimation, duration } : b);
    });
}

// Listen for window resize event
window.addEventListener('resize', onResize);

window.onload = function () {

    flyBird(document.getElementById('bird1'), 10000);  // Small bird (far away)
    flyBird(document.getElementById('bird2'), 12000);  // Medium bird (middle)
    flyBird(document.getElementById('bird3'), 15000);  // Large bird (nearest)

    // Start flying balloons with different speeds
    flyBalloon(document.getElementById('balloon1'), 15000);  // Small balloon
    flyBalloon(document.getElementById('balloon2'), 10000);  // Medium balloon
    flyBalloon(document.getElementById('balloon3'), 12000);  // Large balloon
};