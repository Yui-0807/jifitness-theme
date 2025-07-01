function initMap() {
  const center = { lat: 24.160173, lng: 120.655360 };

  const map = new google.maps.Map(document.getElementById("map"), {
    zoom: 16,
    center: center,
  });

const locations = [
  { title: "JI健身工作室",   lat: 24.16044634131968, lng: 120.65527750293968 },
  { title: "長沅復健科診所",  lat: 24.160191826525544, lng: 120.65621091171748 },
  { title: "長榮桂冠酒店",   lat: 24.159029159331137, lng: 120.65759098744665 },
  { title: "大利市停車場",   lat: 24.159528403955026, lng: 120.6562069675348 },
  { title: "何厝停車場",     lat: 24.162667011241805, lng: 120.65341178288104 },
  { title: "仁愛停車場",     lat: 24.162656244429282, lng: 120.650980 },
];

  const jiIcon = {
    url: contactMapData.jiLogoUrl, 
    scaledSize: new google.maps.Size(40, 40)
  };

  const parkingIcon = {
    url: "https://maps.gstatic.com/mapfiles/ms2/micons/parkinglot.png",
    scaledSize: new google.maps.Size(32, 32)
  };

  const clinicIcon = {
    url: "https://maps.gstatic.com/mapfiles/ms2/micons/hospitals.png",
    scaledSize: new google.maps.Size(32, 32)
  };

  locations.forEach(loc => {
    let customIcon = null;

    if (loc.title === "JI健身工作室") {
      customIcon = jiIcon;
    } else if (loc.title.includes("停車場")) {
      customIcon = parkingIcon;
    } else if (loc.title.includes("診所")) {
      customIcon = clinicIcon;
    }

    new google.maps.Marker({
      position: { lat: loc.lat, lng: loc.lng },
      map: map,
      title: loc.title,
      icon: customIcon
    });
  });
}

// 等 Google Maps 載入後執行
if (typeof google !== 'undefined') {
  initMap();
} else {
  window.addEventListener('load', () => {
    if (typeof google !== 'undefined') {
      initMap();
    }
  });
}
