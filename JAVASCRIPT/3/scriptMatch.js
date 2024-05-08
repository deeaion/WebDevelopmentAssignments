document.addEventListener('DOMContentLoaded', function() {
    function generateRandomPairs(size) {
        let numbers = [];
        for (let i = 1; i <= size; i++) {
            numbers.push(i, i);
        }
        numbers.sort(() => Math.random() - 0.5);
        return numbers;
    }

    function startGame() {
        let comboList = document.getElementById('comboList');
        if(comboList.value !== 'None')
            {let size = parseInt(comboList.value, 10);  // Get the value and convert to integer
        const numbers = generateRandomPairs(size * size / 2);
        let table = document.getElementById('table');
        table.innerHTML = '';  // Clear the previous table
        let selected = [];
        let found = 0;
        createTable();
        function createTable() {
            for (let i = 0; i < size; i++) {
                const row = table.insertRow();
                for (let j = 0; j < size; j++) {
                    const cell = row.insertCell();
                    cell.className = 'hidden';
                    cell.textContent = numbers[i * size + j];
                    cell.addEventListener('click', function() {
                        if (selected.length < 2 && cell.className === 'hidden') {
                            cell.classList.remove('hidden');
                            selected.push(cell);
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
            if (first.textContent === second.textContent) {
                first.className = second.className = 'correct';
                found++;
                if (found === size * size / 2) {
                    alert('You won!');
                }
                selected = [];
            } else {
                setTimeout(() => {
                    first.className = second.className = 'hidden';
                    selected = [];
                }, 2000);
            }
        }


    }}

    document.getElementById('comboList').addEventListener('change', startGame);
});
