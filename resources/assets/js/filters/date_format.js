module.exports = function(utc) {
    return require('./utc_to_local.js')(utc, 'MMM D, YYYY');
}