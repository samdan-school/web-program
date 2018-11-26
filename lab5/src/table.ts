import {Colors, face} from './def';

const tableUtilities = {
    clearTable: function (table: any[][], color: Colors): any {
        for (let row_i = 0; row_i < table.length; row_i++) {
            for (let col_i = 0; col_i < table[0].length; col_i++) {
                table[row_i][col_i].style.backgroundColor = color;
            }
        }
    },
    drawTable: function (table: any[][], picture: Colors[][]): any {
        for (let row_i = 0; row_i < table.length; row_i++) {
            for (let col_i = 0; col_i < table[0].length; col_i++) {
                table[row_i][col_i].style.backgroundColor = picture[row_i][col_i];
            }
        }
    },
    checkWith: function (board: Colors[][], check: Colors[][]): boolean {
        for (let row_i = 0; row_i < board.length; row_i++) {
            for (let col_i = 0; col_i < board[0].length; col_i++) {
                if (board[row_i][col_i] != check[row_i][col_i]) {
                    return false;
                }
            }
        }
        return true;
    },
    countdown: function(sec: number, tick: Function, done: Function) {
        var interval = setInterval(function(){
            if(sec <= 0) {
                clearInterval(interval);
                done();
            } else {
                tick(sec);
                sec--;
            }
        }, 1000)
    },
};

export default tableUtilities;