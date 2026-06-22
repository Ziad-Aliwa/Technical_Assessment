<script setup>
import { onMounted, ref } from 'vue';

import TicketApi from '../api/ticket';

import TicketTable from '../components/TicketTable.vue';
import Toast from '../components/Toast.vue';
import ConfirmModal from '../components/ConfirmModal.vue';

const tickets = ref([]);
const loading = ref(false);

const processingTicketId = ref(null);

const toast = ref({
    show: false,
    message: '',
    type: 'success',
});

const showConfirm = ref(false);
const selectedTicket = ref(null);

const loadTickets = async () => {

    loading.value = true;

    try {

        const response = await TicketApi.getTickets();

        tickets.value = response.data.data;

    } catch (error) {

        showToast(
            error.response?.data?.message ??
            'Failed to load tickets.',
            'error'
        );

    } finally {

        loading.value = false;

    }

};

onMounted(loadTickets);

const showToast = (message, type = 'success') => {

    toast.value = {
        show: true,
        message,
        type,
    };

    setTimeout(() => {

        toast.value.show = false;

    }, 3000);

};

const escalate = (ticket) => {

    selectedTicket.value = ticket;

    showConfirm.value = true;

};

const confirmEscalation = async () => {

    if (!selectedTicket.value) {
        return;
    }

    processingTicketId.value = selectedTicket.value.id;

    try {

        const response = await TicketApi.escalate(selectedTicket.value.id);

        /*
        |--------------------------------------------------------------------------
        | Update ticket locally (بدل إعادة تحميل الجدول كله)
        |--------------------------------------------------------------------------
        */

        const updatedTicket = response.data.data;

        const index = tickets.value.findIndex(
            ticket => ticket.id === updatedTicket.id
        );

        if (index !== -1) {

            tickets.value[index] = updatedTicket;

        }

        showToast(
            'Ticket escalated successfully.',
            'success'
        );

    } catch (error) {

        showToast(
            error.response?.data?.message ??
            'Something went wrong.',
            'error'
        );

    } finally {

        processingTicketId.value = null;

        showConfirm.value = false;

        selectedTicket.value = null;

    }

};
</script>

<template>

<div class="max-w-6xl mx-auto py-10 px-5">

    <h1 class="text-3xl font-bold mb-8">

        Help Desk Tickets

    </h1>

    <TicketTable
        :tickets="tickets"
        :loading="loading"
        :processing-ticket-id="processingTicketId"
        @escalate="escalate"
    />

    <Toast
        :show="toast.show"
        :message="toast.message"
        :type="toast.type"
    />

    <ConfirmModal
        :show="showConfirm"
        title="Escalate Ticket"
        :message="`Are you sure you want to escalate ticket #${selectedTicket?.id ?? ''}?`"
        @confirm="confirmEscalation"
        @cancel="showConfirm = false"
    />

</div>

</template>