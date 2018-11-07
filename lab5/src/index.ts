// Style
import './main.scss';
// Color
import {Colors, face} from './def';

type ColorMap = { [key in Colors]: string };
// My files
import tableUtilities from './table';

// Global value
let myColor: Colors = Colors.Black;

// HTML ELEMENTS
const color_buttons = <NodeListOf<Element>>document.querySelectorAll("input[class^='color-']");

// Buttons
const clear_table = <HTMLElement>document.getElementById("clear_table");
const draw_face = <HTMLElement>document.getElementById("draw_face");
const start = <HTMLElement>document.getElementById("start");
let time_counter = <HTMLInputElement>document.getElementById("time-counter");

// Game State
let game_start: boolean = false;
let game_win: boolean = false;


// 2d array save color information about table
const row: number = 8;
const column: number = 7;
let board: Colors[][] = [];

for (let row_i = 0; row_i < row; row_i++) {
    board[row_i] = [];
    for (let col_i = 0; col_i < column; col_i++) {
        board[row_i][col_i] = Colors.White;
    }
}

// Connecting HTML table with JS
const table: any = [];
for (let row_i = 0; row_i < row; row_i++) {
    table[row_i] = [];
    for (let col_i = 0; col_i < column; col_i++) {
        table[row_i][col_i] = <HTMLElement>document.getElementsByClassName("column_" + col_i)[row_i];
        table[row_i][col_i].addEventListener('click', () => {
            table[row_i][col_i].style.backgroundColor = myColor;
            board[row_i][col_i] = myColor;
            // Exercise 3
            if (game_start) {
                if (tableUtilities.checkWith(board, face)) {
                    alert("Congratulations! You Win!!!");
                    location.reload();
                }
            }
        });
    }
}

tableUtilities.clearTable(table, Colors.White);
clear_table.addEventListener("click", () => {
    tableUtilities.clearTable(table, Colors.White);
});

// Exercise 1
draw_face.addEventListener("click", () => {
    game_start = false;
    tableUtilities.drawTable(table, face);
});

// Exercise 2
color_buttons.forEach(button => {
    button.addEventListener('click', () => {
        let color: ColorMap = button.className.split('-')[1];
        myColor = Colors[color];
        // console.log(Colors[color]);
    })
});

// Exercise 3
start.addEventListener('click', () => {
    tableUtilities.clearTable(table, Colors.White);
    game_start = true;
    game_win = false;

    tableUtilities.countdown(10, (sec:number) => {
        time_couxnter.value = String(sec);
    }, function () {
        alert("You lose! Try again!");
        location.reload();
    });
});