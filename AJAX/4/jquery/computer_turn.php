<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$board = $data['board'];

// Logica pentru a face următoarea mutare a calculatorului
function makeMove($board) {
    // Căutăm primul loc liber și plasăm 'O'
    //fac random
    $emptyCells = array_keys($board, '');
    $randomCell = $emptyCells[array_rand($emptyCells)];
    $board[$randomCell] = 'O';

    return $board;
}

// Verifică dacă există o victorie sau egalitate
function checkWin($board) {
    $winningCombinations = [
        [0, 1, 2], [3, 4, 5], [6, 7, 8], // linii
        [0, 3, 6], [1, 4, 7], [2, 5, 8], // coloane
        [0, 4, 8], [2, 4, 6]             // diagonale
    ];

    foreach ($winningCombinations as $combination) {
        if ($board[$combination[0]] != '' &&
            $board[$combination[0]] == $board[$combination[1]] &&
            $board[$combination[1]] == $board[$combination[2]]) {
            return $board[$combination[0]];
        }
    }

    if (!in_array('', $board)) {
        return 'draw';
    }

    return null;
}

$board = makeMove($board);
$winner = checkWin($board);

echo json_encode(['board' => $board, 'winner' => $winner]);
