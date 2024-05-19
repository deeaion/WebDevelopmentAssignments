
$(document).ready(function() {
    const $cells= $('td'); // iau toate celulele din tabel\
    let playTurn = Math.random() > 0.5 ? 'X' : 'O'; // aleg random cine incepe
    let board = ['', '', '', '', '', '', '', '', '']; // initializare tabla
    let gameOver = false; // jocul incepe
    function handleClick(event) {
        if(gameOver) return; // daca jocul s-a terminat, ignoram click-urile
        const $cell = $(event.target); // celula pe care am dat click
        const index = $cell.data('cell'); // indexul celulei
        if(board[index]==='') {
            board[index] = playTurn; // o umplu cu simbolul jucatorului curent
            $cell.text(playTurn); // afisez simbolul in celula
            checkGameStatus(); // verific daca jocul s-a terminat
            if(!gameOver) {
                playTurn = playTurn === 'X' ? 'O' : 'X'; // schimb jucatorul
                if(playTurn === 'O') {
                    computerTurn();
                }
            }
        }
    }

    function checkGameStatus() {
        const winningCombinations = [
            [0, 1, 2], [3, 4, 5], [6, 7, 8], // linii
            [0, 3, 6], [1, 4, 7], [2, 5, 8], // coloane
            [0, 4, 8], [2, 4, 6]             // diagonale
        ];

        for (let combination of winningCombinations) {
            const [a, b, c] = combination;
            if (board[a] && board[a] === board[b] && board[a] === board[c]) {
                gameOver = true;
                setTimeout(() => {
                    alert(`${board[a]} wins`);
                    resetBoard();
                }, 100);
                return;
            }
            if (board.every(cell => cell !== '')) {
                gameOver = true;
                setTimeout(() => {
                    alert('Draw');
                    resetBoard();
                }, 100);
            }
        }
    }
    function computerTurn(){
        $.ajax({
            url:'computer_turn.php',
            method:'POST',
            contentType:'application/json',
            data: JSON.stringify({ board: board }),
            success: function(data) {
                board = data.board;
                updateBoard();
                checkGameStatus();
                if (!gameOver) {
                    playTurn = 'X';
                }
            }
        });

    }
    function updateBoard(){
        $cells.each(function(index, cell) {
            $(cell).text(board[index]);
        });
    }
    function resetBoard(){
        board = ['', '', '', '', '', '', '', '', ''];
        updateBoard();
        gameOver = false;
        playTurn = Math.random() > 0.5 ? 'X' : 'O';
        if (playTurn === 'O') {
            computerTurn();
        }
    }
    $cells.on('click', handleClick);
    if (playTurn === 'O') {
        computerTurn();
    }

});