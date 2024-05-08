$(document).ready(function() {
    var found = 0; // Moved found to a higher scope

    $('#comboList').on('change', function() {
        found = 0; // Reset found for a new game
        startGame($(this).val());
    });

    function generateRandomPairs(size) {
        let numbers = [];
        for (let i = 0; i < size; i++) {
            numbers.push(i, i);
        }
        numbers.sort(() => 0.5 - Math.random());
        return numbers;
    }

    function startGame(selectedSize) {
        let size = parseInt(selectedSize, 10);
        if (isNaN(size)) return; // Early return if size is not a number

        const numbers = generateRandomPairs(size * size / 2); // Generate the pairs based on size squared divided by 2
        createTable(size, numbers);
    }

    function createTable(size, numbers) {
        let $table = $('#table').empty();
        let selected = [];

        for (let i = 0; i < size; i++) {
            let $row = $('<tr></tr>').appendTo($table);
            for (let j = 0; j < size; j++) {
                let index = i * size + j;
                let imgIndex = numbers[index];
                let imgSrc = `images/${imgIndex + 1}.jpg`; // Make sure this corresponds correctly to the image file names
                let $cell = $('<td></td>').addClass('hidden').appendTo($row);

                $('<img>').attr('src', imgSrc)
                    .on('error', function() {
                        console.error('Failed to load image with src:', imgSrc);
                    })
                    .css('width', '100%').appendTo($cell);

                $cell.on('click', function() {
                    if (selected.length < 2 && $(this).hasClass('hidden')) {
                        $(this).removeClass('hidden');
                        selected.push($(this));
                        if (selected.length === 2) {
                            checkIfCorrect(selected, size); // Pass size, not found
                        }
                    }
                });
            }
        }
    }

    function checkIfCorrect(selected, size) {
        const [first, second] = selected;
        if (first.find('img').attr('src') === second.find('img').attr('src')) {
            first.addClass('correct').removeClass('hidden');
            second.addClass('correct').removeClass('hidden');
            found++; // Increment found for each correct pair
            if (found === size * size / 2) { // Check if all pairs are found
                setTimeout(function() { alert('You won!'); }, 500); // Alert after a short delay to ensure the last pair is visible
            }
        } else {
            setTimeout(() => {
                first.addClass('hidden').removeClass('correct');
                second.addClass('hidden').removeClass('correct');
            }, 1000);
        }
        selected.length = 0; // Clear selected array
    }
});
