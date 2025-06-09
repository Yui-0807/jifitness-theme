function initMap() {
  const center = { lat: 24.1653, lng: 120.6394 };

  const map = new google.maps.Map(document.getElementById("map"), {
    zoom: 16,
    center: center,
  });

  const locations = [
    { title: "健身工作室", lat: 24.1653, lng: 120.6394 },
    { title: "長沅復健科診所", lat: 24.1648, lng: 120.6407 },
    { title: "長榮桂冠酒店", lat: 24.1662, lng: 120.6369 },
    { title: "大力市停車場", lat: 24.1639, lng: 120.6405 },
    { title: "何厝停車場", lat: 24.1665, lng: 120.6382 },
    { title: "仁愛停車場", lat: 24.1672, lng: 120.6391 },
  ];

  locations.forEach(loc => {
    new google.maps.Marker({
      position: { lat: loc.lat, lng: loc.lng },
      map: map,
      title: loc.title,
    });
  });
}

// 手動等 google 載入後呼叫 initMap
if (typeof google !== 'undefined') {
  initMap();
} else {
  window.addEventListener('load', () => {
    if (typeof google !== 'undefined') {
      initMap();
    }
  });
}
