require('./mapsjs-core');
require('./mapService');

let platform, map, defaultLayers;
window.URL.createObjectURL = function () { };

describe('HERE Maps tests', () => {
  document.body.innerHTML = `
    <div>
      <div style="width: 640px; height: 480px" id="mapContainer">
      </div>
    </div>
  `;

  it('should have the library installed.', () => {
    expect(H).toBeDefined();
  });

  it('should be able to initialize Platform', () => {
    platform = new H.service.Platform({
      apikey: 'iYvMpF1KOQJ89K6boSx23q7-l9Xtv4Jz3a5fun9MS1w'
    });
    expect(platform).toBeDefined();
  })

  it('should be able to create default layers', () => {
    defaultLayers = platform.createDefaultLayers();
    expect(defaultLayers).toBeDefined();
  })

  // NEEDS WEBGL - CAN'T TEST
  // it('should be able to initialize Map', () => {
  //   map = new H.Map(
  //     document.getElementById('mapContainer'),
  //     defaultLayers.vector.normal.map, {
  //     zoom: 4,
  //     center: {
  //       lng: -95,
  //       lat: 37
  //     }
  //   });
  //   expect(map).toBeDefined();
  // });
});