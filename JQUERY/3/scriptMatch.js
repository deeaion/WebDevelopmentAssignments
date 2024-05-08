$(document).ready(function() {
    function generateRandomPairs(size) {
        let numbers = [];
        for (let i = 1; i <= size; i++) {
            numbers.push(i, i);
        }
        numbers.sort(() => Math.random() - 0.5);
        return numbers;
    }

    function startGame() {
        let comboList = $('#comboList');
        if(comboList.val() !== 'None') {
            let size = parseInt(comboList.val(), 10);  // Get the value and convert to integer
            const numbers = generateRandomPairs(size * size / 2);
            let table = $('#table');
            table.empty();  // Clear the previous table
            let selected = [];
            let found = 0;
            createTable();

            function createTable() {
                for (let i = 0; i < size; i++) {
                    const row = $('<tr></tr>').appendTo(table);
                    for (let j = 0; j < size; j++) {
                        const cell = $('<td class="hidden"></td>').text(numbers[i * size + j]).appendTo(row);
                        cell.on('click', function() {
                            if (selected.length < 2 && $(this).hasClass('hidden')) {
                                $(this).removeClass('hidden');
                                selected.push($(this));
                                if (selected.length === 2) {
                                    checkIfCorrect();
                                }
                            }
                        });
                    }
                }
            }

            function checkIfCorrect() {
                const [first, second] = selected;
                if (first.text() === second.text()) {
                    first.add(second).removeClass('hidden').addClass('correct');
                    found++;
                    if (found === size * size / 2) {
                        alert('You won!');
                    }
                    selected = [];
                } else {
                    setTimeout(() => {
                        first.add(second).addClass('hidden').removeClass('correct');
                        selected = [];
                    }, 2000);
                }
            }
        }
    }

    $('#comboList').on('change', startGame);
});