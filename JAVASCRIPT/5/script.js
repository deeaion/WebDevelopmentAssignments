document.addEventListener('DOMContentLoaded', () => {
    const items = document.querySelectorAll('.item');
    let index = 0;
    const intervalTime = 5000;
    // let transitionInterval=setInterval(showItem, intervalTime);
    function showItem(newIndex) {
        items[index].classList.remove('fade');
        items[index].classList.remove('fadeOut');
        items[newIndex].classList.add('fade');
        setTimeout(() => {
        items[newIndex].classList.add('fadeOut');},4000);

        index = newIndex; // Update the current index
    }

    function next() {
        const nextIndex = (index + 1) % items.length;
        showItem(nextIndex);
    }

    function prev() {
        // items[index].remove('fade');

        const prevIndex = (index - 1 + items.length) % items.length;
        showItem(prevIndex);
    }

    // Initialize the carousel
    items[index].classList.add('fade');

    // Automatic change every intervalTime seconds
    let interval = setInterval(next, intervalTime);

    // Reset the interval for carousel when user manually changes the slide
    function resetInterval() {
        clearInterval(interval);
        interval = setInterval(next, intervalTime);
    }

    // Next and Previous buttons
    document.getElementById('next').addEventListener('click', () => {
        next();
        resetInterval();
    });

    document.getElementById('prev').addEventListener('click', () => {
        prev();
        resetInterval();
    });
});
