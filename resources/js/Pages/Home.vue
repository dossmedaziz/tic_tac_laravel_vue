<template>
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100">
        <button
            @click="goToLeaderBoard"
            class="fixed top-4 left-4 px-4 py-2 bg-blue-500 text-white font-semibold rounded hover:bg-blue-600"
        >
            Leaderboard
        </button>

        <div v-if="!gameStarted" class="mb-6 text-2xl font-semibold text-center">
            <p>Welcome to the Tic-Tac-Toe Game!</p>
        </div>

        <div v-if="gameStarted" class="mb-4 text-lg font-semibold text-center">
            <p>{{ players[0] }} (X)</p>
            <p>{{ players[1] }} (O)</p>
        </div>

        <div
            class="board grid grid-cols-3 gap-4 bg-white p-6 rounded-lg shadow-md"
            :class="{ 'opacity-50 pointer-events-none': !gameStarted }"
        >
            <div
                v-for="(cell, index) in board"
                :key="index"
                @click="makeMove(index)"
                class="cell w-20 h-20 flex items-center justify-center bg-gray-200 border-2 border-gray-300 cursor-pointer text-2xl font-bold"
            >
                {{ cell }}
            </div>
        </div>

        <div v-if="gameStarted && !winner && !isTie" class="mt-6 text-xl font-semibold text-blue-500">
            <p>{{ currentPlayer === "X" ? players[0] : players[1] }}, it's your turn!</p>
        </div>

        <div v-if="winner || isTie" class="mt-6 text-xl font-semibold">
            <p v-if="winner" class="text-green-500">{{ winner }} wins the game!</p>
            <p v-else class="text-gray-500">It's a tie!</p>
        </div>

        <div class="mt-6 flex gap-4">
            <button
                v-if="!gameStarted"
                @click="showPlayerModal"
                class="px-4 py-2 bg-blue-500 text-white font-semibold rounded hover:bg-blue-600"
            >
                Start Game
            </button>
            <button
                v-if="winner || isTie"
                @click="restartGame"
                class="px-4 py-2 bg-green-500 text-white font-semibold rounded hover:bg-green-600"
            >
                Restart Game
            </button>
            <button
                v-if="winner || isTie"
                @click="saveScore"
                class="px-4 py-2 bg-blue-500 text-white font-semibold rounded hover:bg-blue-600"
            >
                Save Score
            </button>
        </div>

        <div v-if="showModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white p-6 rounded-lg shadow-md w-80">
                <h3 class="text-lg font-bold mb-4 text-center">Enter Player Names</h3>
                <div class="mb-4">
                    <input
                        v-model="players[0]"
                        type="text"
                        placeholder="Player 1 (X)"
                        class="w-full px-4 py-2 border rounded"
                    />
                </div>
                <div class="mb-4">
                    <input
                        v-model="players[1]"
                        type="text"
                        placeholder="Player 2 (O)"
                        class="w-full px-4 py-2 border rounded"
                    />
                </div>
                <div class="flex justify-end">
                    <button
                        @click="startGame"
                        class="px-4 py-2 bg-blue-500 text-white font-semibold rounded hover:bg-blue-600"
                    >
                        Start
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import {router} from "@inertiajs/vue3";

export default {
    name: "Home",
    data() {
        return {
            board: Array(9).fill(null),
            currentPlayer: "X",
            players: ["", ""],
            showModal: false,
            gameStarted: false,
            winner: null,
            isTie: false,
        };
    },
    methods: {
        showPlayerModal() {
            this.showModal = true;
        },
        startGame() {
            if (this.players[0] && this.players[1]) {
                this.showModal = false;
                this.gameStarted = true;
            } else {
                alert("Please enter both player names!");
            }
        },
        makeMove(index) {
            if (!this.board[index] && !this.winner && this.gameStarted) {
                this.board[index] = this.currentPlayer;
                if (this.checkWinner()) {
                    this.winner = this.currentPlayer === "X" ? this.players[0] : this.players[1];
                } else if (this.board.every(cell => cell)) {
                    this.isTie = true;
                } else {
                    this.currentPlayer = this.currentPlayer === "X" ? "O" : "X";
                }
            }
        },
        checkWinner() {
            const winPatterns = [
                [0, 1, 2], [3, 4, 5], [6, 7, 8],
                [0, 3, 6], [1, 4, 7], [2, 5, 8],
                [0, 4, 8], [2, 4, 6],
            ];
            return winPatterns.some(pattern => {
                const [a, b, c] = pattern;
                return this.board[a] && this.board[a] === this.board[b] && this.board[a] === this.board[c];
            });
        },
        restartGame() {
            this.board = Array(9).fill(null);
            this.currentPlayer = "X";
            this.winner = null;
            this.isTie = false;
            this.gameStarted = false;
        },
        saveScore() {
            const data = {
                x_player_name: this.players[0],
                o_player_name: this.players[1],
                winner_player_name: this.winner,
                is_a_tie: this.isTie,
            };

            // get the scores.store route
            let url = route('scores.store');
            axios
                .post(url, data)
                .then(response => {
                    // display a modal to show the score has been saved
                    alert("Score saved successfully!");
                    document.location.reload();
                })
                .catch(error => {
                    console.error("Error saving score:", error);
                    alert("Failed to save score.");
                });
        },
        goToLeaderBoard() {
            // Navigate to the leaderboard
            let leaderboardUrl = route('leaderboard');
            router.get(leaderboardUrl);
        }
    },
};
</script>

<style scoped>
.board {
    width: 320px;
    height: 320px;
}

.cell {
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
