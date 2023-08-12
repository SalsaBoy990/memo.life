import axios from "axios";
import {REST_URL} from "../constants/constants.js";

// Add a request interceptor
axios.interceptors.request.use(function (config) {
    config.baseURL = REST_URL;
    config.headers['Accept'] = 'application/json';
    config.headers['Content-Type'] = 'application/json';

    return config;
});

axios.interceptors.response.use(
    function(response) {
        // Call was successful, don't do anything special.
        return response;
    },
    function (error) {
        switch (error.response.status) {
            case 401: // Not logged in
            case 419: // Session expired
            case 503: // Down for maintenance
                // Bounce the user to the login screen with a redirect back
                window.location.reload();
                break;
            case 500:
                console.error('Oops, something went wrong! The team have been notified.');
                break;
            default:
                // Allow individual requests to handle other errors
                return Promise.reject(error);
        }
    });


export default axios;
