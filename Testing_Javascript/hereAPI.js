const fetch = require('node-fetch');

// this call lets us know
// whether API key is still valid
// and whether geolocation data is correct.
const getGeolocation = async (address, API_KEY) => {
  const res = await fetch(`https://geocoder.ls.hereapi.com/6.2/geocode.json?apiKey=${API_KEY}&searchtext=${encodeURI(address)}`);
  const resJSON = await res.json();
  return resJSON;
}

const API_KEY = 'iYvMpF1KOQJ89K6boSx23q7-l9Xtv4Jz3a5fun9MS1w'

module.exports = { getGeolocation, API_KEY };