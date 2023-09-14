import { defineStore } from "pinia";
import axios from "axios";

export const useDistanceStore = defineStore("distanceStore", {
  state: () => ({
    distance: 0,
  }),
  actions: {
    async calculateDistance(startCoord, endCoord) {
      if (startCoord.length !== 2 || endCoord.length !== 2) {
        return;
      }

      const headers = {
        Accept: "application/json",
      };

      const requestBody = {
        points: [
          {
            type: "stop",
            lon: startCoord[0],
            lat: startCoord[1],
          },
          {
            type: "stop",
            lon: endCoord[0],
            lat: endCoord[1],
          },
        ],
        transport: "truck",
        route_mode: "fastest",
        traffic_mode: "jam",
      };

      try {
        const response = await axios.post(
          "https://routing.api.2gis.com/routing/7.0.0/global?key=cb315652-4a77-4656-b55c-2485e210e675",
          requestBody,
          { headers: headers },
        );

        this.distance = response.data.result[0].total_distance;
      } catch (error) {
        console.error(error);
      }
    },
  },
  getters: {},
});
