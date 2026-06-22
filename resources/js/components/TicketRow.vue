<script setup>

defineProps({

    ticket: {
        type: Object,
        required: true,
    },

    processing: {
        type: Boolean,
        default: false,
    },

});

defineEmits([
    'escalate',
]);

const priorityClasses = {

    Low: 'bg-gray-100 text-gray-700',

    Medium: 'bg-blue-100 text-blue-700',

    High: 'bg-orange-100 text-orange-700',

    Urgent: 'bg-red-100 text-red-700',

};

const statusClasses = {

    Open: 'bg-green-100 text-green-700',

    'In Progress': 'bg-yellow-100 text-yellow-700',

    Resolved: 'bg-blue-100 text-blue-700',

    Closed: 'bg-gray-200 text-gray-700',

    Escalated: 'bg-red-100 text-red-700',

};

</script>

<template>

<tr class="hover:bg-gray-50 transition">

    <td class="border px-4 py-3">

        {{ ticket.id }}

    </td>

    <td class="border px-4 py-3">

        {{ ticket.subject }}

    </td>

    <td class="border px-4 py-3">

        <span
            class="px-2 py-1 rounded text-sm font-medium"
            :class="priorityClasses[ticket.priority]"
        >
            {{ ticket.priority }}
        </span>

    </td>

    <td class="border px-4 py-3">

        <span
            class="px-2 py-1 rounded text-sm font-medium"
            :class="statusClasses[ticket.status]"
        >
            {{ ticket.status }}
        </span>

    </td>

    <td class="border px-4 py-3">

        {{ ticket.escalated_at ?? '-' }}

    </td>

    <td class="border px-4 py-3 text-center">

        <button
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition disabled:bg-gray-400 disabled:cursor-not-allowed"
            :disabled="processing || ticket.status === 'Escalated'"
            @click="$emit('escalate', ticket)"
        >

            {{ processing ? 'Escalating...' : 'Escalate' }}

        </button>

    </td>

</tr>

</template>