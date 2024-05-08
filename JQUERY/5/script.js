$(document).ready(() => {
    const $items = $('.item');
    let index = 0;
    const intervalTime = 3000;

    function showItem(newIndex) {
        $items.eq(index).removeClass('fade fadeOut');
        $items.eq(newIndex).addClass('fade');
        setTimeout(() => {
            $items.eq(newIndex).addClass('fadeOut');
        }, 2000);

        index = newIndex;
    }

    function changeItem(step) {
        const newIndex = (index + step + $items.length) % $items.length;
        showItem(newIndex);
    }

    $items.eq(index).addClass('fade');
    let interval = setInterval(() => changeItem(1), intervalTime);

    function resetInterval() {
        clearInterval(interval);
        interval = setInterval(() => changeItem(1), intervalTime);
    }

    $('#next').click(() => {
        changeItem(1);
        resetInterval();
    });

    $('#prev').click(() => {
        changeItem(-1);
        resetInterval();
    });
});
