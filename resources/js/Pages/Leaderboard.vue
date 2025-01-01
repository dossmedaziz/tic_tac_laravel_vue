<template>
    <Head title="Leaderboard" />
    <div class="container mx-auto p-6">
        <button
            @click="gotToNewGame"
            class="fixed top-4 left-4 px-4 py-2 bg-blue-500 text-white font-semibold rounded hover:bg-blue-600"
        >
            New Game
        </button>
        <h2 class="text-3xl font-bold text-center mb-6 text-gray-700">Leaderboard</h2>

        <div class="mb-6 flex justify-center">
            <input
                v-model="searchQuery"
                type="text"
                class="px-4 py-2 w-1/3 border rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Search by Player Name or Ref ID..."
            />

            <button
                @click="searchScores"
                class="px-4 py-2 ml-4 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-600 focus:outline-none"
            >
                Search
            </button>
        </div>

        <table class="min-w-full bg-white border border-gray-300 shadow-md rounded-lg overflow-hidden">
            <thead class="bg-blue-600 text-white">
            <tr>
                <th class="px-6 py-3 text-left">Rank</th>
                <th class="px-6 py-3 text-left">X Player</th>
                <th class="px-6 py-3 text-left">O Player</th>
                <th class="px-6 py-3 text-left">Winner</th>
                <th class="px-6 py-3 text-left">Tie</th>
            </tr>
            </thead>
            <tbody>
            <tr
                v-for="(score, index) in filteredScores"
                :key="score.id"
                class="hover:bg-gray-100 cursor-pointer transition-colors"
            >
                <td class="px-6 py-4">
                    <span class="font-bold">#{{ score.id }}</span>
                </td>
                <td class="px-6 py-4">{{ score.x_player_name }}</td>
                <td class="px-6 py-4">{{ score.o_player_name }}</td>
                <td class="px-6 py-4">{{ score.winner_player_name || '-' }}</td>
                <td class="px-6 py-4">
            <span :class="score.is_a_tie ? 'text-red-500 font-semibold' : 'text-green-500 font-semibold'">
              {{ score.is_a_tie ? 'Yes' : 'No' }}
            </span>
                </td>
            </tr>
            </tbody>
        </table>

        <div class="mt-4 flex justify-between items-center">
            <button
                v-if="scores.prev_page_url"
                @click="changePage(scores.current_page - 1)"
                class="px-6 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 focus:outline-none"
            >
                Previous
            </button>
            <span class="px-4 py-2 text-gray-600">Page {{ scores.current_page }} of {{ scores.last_page }}</span>
            <button
                v-if="scores.next_page_url"
                @click="changePage(scores.current_page + 1)"
                class="px-6 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 focus:outline-none"
            >
                Next
            </button>
        </div>
    </div>
</template>

<script setup>
import {ref} from "vue";
import {Head, router} from "@inertiajs/vue3";

const props = defineProps({
    scores: {
        type: Object,
    },
    searchKey: {
        type: String,
        default: '',
    },

})
const searchQuery = ref(props.searchKey);
const filteredScores = ref(props.scores.data);
const changePage = (page) => {
    let url = route('leaderboard', {page: page});
    url += searchQuery.value ? `&search_key=${searchQuery.value}` : '';
    router.visit(url);
}

const searchScores = () => {
    const query = searchQuery.value.toLowerCase();
    let url = route('leaderboard');
    url += query ? `?search_key=${query}` : '';
    router.visit(url);
}

const gotToNewGame = () => {
   router.visit(route('home'));
}
</script>

<style scoped>
</style>
