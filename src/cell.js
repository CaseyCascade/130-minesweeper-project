const DEBUG_MODE = true;
export class Cell {
    constructor(row, col) {
        this.row = row;
        this.col = col;
        this.isMine = false;
        this.isRevealed = false;
        this.isFlagged = false;
        this.adjacentMines = 0;
        this.element = this.createElement();
    }

    createElement() {
        const cellElement = document.createElement('div');
        cellElement.className = 'cell';
    
        // Show mines in debug mode
        if (DEBUG_MODE && this.isMine) {
            cellElement.classList.add('debug-mine');
        }
    
        cellElement.addEventListener('click', () => this.reveal());
        cellElement.addEventListener('contextmenu', (e) => {
            e.preventDefault();
            this.toggleFlag();
        });
    
        return cellElement;
    }
    

    reveal() {
        if (this.isRevealed || this.isFlagged) return;

        this.isRevealed = true;
        this.element.classList.add('revealed');

        if (this.isMine) {
            this.element.classList.add('mine');
            alert("Game Over!"); //TODO Post game results and add option to restart
        } else if (this.adjacentMines > 0) {
            this.element.textContent = this.adjacentMines;
        } else {
            this.element.textContent = '';
        }
    }

    toggleFlag() {
        if (this.isRevealed) return;

        this.isFlagged = !this.isFlagged;
        this.element.classList.toggle('flag', this.isFlagged);
    }

    setMine() {
        this.isMine = true; 
        if (DEBUG_MODE) {
            this.element.classList.add('debug-mine');
        }
    }
    

    incrementAdjacentMines() {
        this.adjacentMines++;
    }
}
