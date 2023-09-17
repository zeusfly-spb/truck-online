<template>
  <div id="map"></div>
  <!-- <div v-if="!distanceStore.distance">
    Выберете маршрут для определения дистанции
  </div>
  <div v-else>Дистанция: {{ distanceStore.distance }} метров</div> -->
</template>
<script>
import { load } from "@2gis/mapgl";
import { useDistanceStore } from "~/store/distance";
const markerLabels = [
  "Точка отправления",
  "Точка доставки",
  "Точка возврата контейнера",
];

export default {
  props: {
    selectedCoordinates: {
      type: Array,
      required: true,
      default: () => [],
    },
  },
  setup(props) {
    const map = ref(null);
    const markers = ref([]);
    const distanceStore = useDistanceStore();

    const createMarker = (coord, labelText) => {
      if (map.value && coord) {
        const newMarker = new mapgl.Marker(map.value, {
          coordinates: coord,
          label: {
            text: labelText,
          },
        });
        markers.value.push(newMarker);
      }
    };

    const updateMapCenter = (coord) => {
      if (map.value && coord) {
        map.value.setCenter(coord);
      }
    };

    watch(
      () => props.selectedCoordinates[0],
      (newFrom) => {
        updateMapCenter(newFrom);
      },
    );

    watch(
      () => props.selectedCoordinates[1],
      (newTo) => {
        updateMapCenter(newTo);
      },
    );

    watch(
      () => props.selectedCoordinates[2],
      (newReturn) => {
        updateMapCenter(newReturn);
      },
    );

    watch(
      () => props.selectedCoordinates,
      async (newCoordinates, oldCoordinates) => {
        if (!map.value) {
          return;
        }

        // await distanceStore.calculateDistance(
        //   props.selectedCoordinates[0],
        //   props.selectedCoordinates[1],
        // );

        newCoordinates.forEach((coord, index) => {
          if (markers.value[index]) {
            markers.value[index].setCoordinates(coord);
            markers.value[index].setLabel({
              text: markerLabels[index],
            });
          } else {
            createMarker(coord, markerLabels[index]);
          }
        });

        const diffLength = oldCoordinates.length - newCoordinates.length;

        if (diffLength > 0) {
          markers.value.splice(newCoordinates.length);
        }

        if (newCoordinates.length > 0) {
          map.value.setCenter(newCoordinates[0]);
        }
      },
      { deep: true },
    );
    const createMap = async () => {
      const defaultCenter =
        props.selectedCoordinates.length === 3
          ? props.selectedCoordinates[2]
          : [37.61556, 55.75222];

      const mapglAPI = await load();
      map.value = new mapglAPI.Map("map", {
        center: defaultCenter,
        zoom: 11,
        zoomControl: false,
        key: "cb315652-4a77-4656-b55c-2485e210e675",
      });

      map.value.on("load", () => {
        props.selectedCoordinates.forEach((coord, index) => {
          if (coord) {
            createMarker(coord, markerLabels[index]);
          }
        });
      });
    };

    onMounted(createMap);
    const removeMarkers = () => {
      markers.value.forEach((marker) => {
        marker.destroy();
      });
      markers.value = [];
    };

    return {
      map,
      markers,
      distanceStore,
      removeMarkers,
    };
  },
};
</script>
<style scoped>
@media (min-width: 1400px) {
  #map {
    width: 50%;
  }
}
@media (max-width: 1400px) {
  #map {
    width: 100%;
  }
}
</style>
