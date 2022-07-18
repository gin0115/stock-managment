const config = require('./js/balm-config/balmrc');
const api = require('./js/balm-config/balm.api');

module.exports = () => {
    return {
        config,
        api
    };
};