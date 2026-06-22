import axios from 'axios';

const api = axios.create({

    baseURL: '/api',

    headers: {

        Accept: 'application/json',

    },

});

export default {

    getTickets() {

        return api.get('/tickets');

    },

    getTicket(id) {

        return api.get(`/tickets/${id}`);

    },

    escalate(id) {

        return api.post(`/tickets/${id}/escalate`);

    },

};