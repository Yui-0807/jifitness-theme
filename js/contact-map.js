function initMap() {
  const map = new google.maps.Map(document.getElementById("map"), {
    zoom: 16,
    center: { lat: 24.160173, lng: 120.655360 },
  });

  const bounds = new google.maps.LatLngBounds();

  const locations = [
    { title: "JI健身工作室", lat: 24.160268, lng: 120.655293 },
    { title: "長沅復健科診所", lat: 24.159966, lng: 120.656168 },
    { title: "大利市停車場", lat: 24.159371, lng: 120.656219 },
    { title: "何厝停車場", lat: 24.162521, lng: 120.653380 },
    { title: "仁愛停車場", lat: 24.162450, lng: 120.650633 },
  ];

  const jiIcon = {
    url: typeof contactMapData !== "undefined" && contactMapData.jiLogoUrl ? contactMapData.jiLogoUrl : "",
    scaledSize: new google.maps.Size(40, 40)
  };

  const clinicIcon = {
    url: 'data:image/svg+xml;base64,' + btoa(`
      <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40">
        <circle cx="20" cy="20" r="20" fill="#D32F2F"/>
        <rect x="17" y="10" width="6" height="20" fill="white"/>
        <rect x="10" y="17" width="20" height="6" fill="white"/>
      </svg>
    `),
    scaledSize: new google.maps.Size(32, 32)
  };

  const parkingIcon = {
    url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(`
      <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40">
        <circle cx="20" cy="20" r="20" fill="#FFDE00"/>
        <text x="20" y="26" font-size="20" font-family="Arial" font-weight="bold" fill="#404040" text-anchor="middle">P</text>
      </svg>
    `),
    scaledSize: new google.maps.Size(32, 32)
  };

  const activeInfoWindow = { instance: null };

  locations.forEach(loc => {
    const position = { lat: loc.lat, lng: loc.lng };
    bounds.extend(position);

    let markerOptions = {
      position,
      map,
      title: loc.title,
      zIndex: loc.title === "JI健身工作室" ? 999 : 1
    };

    // 套用不同 icon
    if (loc.title === "JI健身工作室" && jiIcon.url) {
      markerOptions.icon = jiIcon;
    } else if (loc.title.includes("診所")) {
      markerOptions.icon = clinicIcon;
    } else if (loc.title.includes("停車場")) {
      markerOptions.icon = parkingIcon;
    }

    const marker = new google.maps.Marker(markerOptions);

    const infoWindow = new google.maps.InfoWindow({
      content: `
        <div style="
          font-family: 'Arial', sans-serif;
          font-size: 14px;
          border-radius: 8px;
          padding: 10px 14px;
          max-width: 220px;
          box-shadow: 0 4px 12px rgba(0,0,0,0.2);
          border: 1px solid #ddd;
        ">
          <div style="font-weight: bold; font-size: 16px; margin-bottom: 6px;">
            ${loc.title}
          </div>
          <a href="https://www.google.com/maps/search/?api=1&query=${loc.lat},${loc.lng}" 
             target="_blank" 
             style="display: inline-block; padding: 6px 10px; background-color: #07699E; color: white; text-decoration: none; border-radius: 4px; font-size: 13px;">
            導航 / 查看地圖
          </a>
        </div>
      `
    });

    marker.addListener("click", () => {
      if (activeInfoWindow.instance) {
        activeInfoWindow.instance.close();
      }
      infoWindow.open(map, marker);
      activeInfoWindow.instance = infoWindow;
    });

    console.log("已建立 marker：", loc.title);
  });

  map.fitBounds(bounds, { padding: 80 });

  google.maps.event.addListenerOnce(map, "bounds_changed", () => {
    if (map.getZoom() > 17) {
      map.setZoom(17);
    }
  });
}

// 等 Google Maps 載入後執行
if (typeof google !== "undefined") {
  initMap();
} else {
  window.addEventListener("load", () => {
    if (typeof google !== "undefined") {
      initMap();
    }
  });
}
