const { getGeolocation, API_KEY } = require('./hereAPI');

let globalData = undefined;

describe('HERE Maps API and Geolocation tests', () => {
  const TEST_ADDRESS = '1108 ROSS CLARK CIRCLE DOTHAN AL 36301'
  // const TEST_ADDRESS_FALSE = '380 Ohio St. Victoria, TX 77904'
  const TEST_LATLONG = {
    Latitude: 31.21561,
    Longitude: -85.36139
  };

  beforeAll(async () => {
    globalData = await getGeolocation(TEST_ADDRESS, API_KEY);
  });

  it('should get a response', async () => {
    expect(globalData).toBeDefined();
  })
  it('should have a valid API key', () => {
    expect(globalData.error).toBeUndefined();
  })

  it('should get valid geolocation back', () => {
    expect(globalData.Response).toBeDefined();
    expect(globalData.Response.View[0].Result[0].Location.NavigationPosition[0]).toEqual(TEST_LATLONG);
  });
});