<script setup>

import LoadingSpinner from './LoadingSpinner.vue';
import TicketRow from './TicketRow.vue';

defineProps({

    tickets: {
        type: Array,
        required: true,
    },

    loading: {
        type: Boolean,
        default: false,
    },

    processingTicketId: {
        type: Number,
        default: null,
    },

});

defineEmits([
    'escalate'
]);

</script>

<template>

<LoadingSpinner v-if="loading" />

<div
    v-else
    class="overflow-x-auto bg-white rounded-lg shadow"
>

<table class="min-w-full border-collapse">

    <thead class="bg-gray-100">

        <tr>

            <th class="px-4 py-3 border text-left">

                ID

            </th>

            <th class="px-4 py-3 border text-left">

                Subject

            </th>

            <th class="px-4 py-3 border text-left">

                Priority

            </th>

            <th class="px-4 py-3 border text-left">

                Status

            </th>

            <th class="px-4 py-3 border text-left">

                Escalation Date

            </th>

            <th class="px-4 py-3 border text-center">

                Action

            </th>

        </tr>

    </thead>

    <tbody>

        <TicketRow
            v-for="ticket in tickets"
            :key="ticket.id"
            :ticket="ticket"
            :processing="processingTicketId === ticket.id"
            @escalate="$emit('escalate', $event)"
        />

        <tr v-if="tickets.length === 0">

            <td
                colspan="6"
                class="text-center py-10 text-gray-500"
            >

                No tickets found.

            </td>

        </tr>

    </tbody>

</table>

</div>

</template>