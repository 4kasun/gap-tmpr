<template>
  <div class="app">
    <apexcharts
      width="550"
      type="line"
      :options="chartOptions"
      :series="series"
    ></apexcharts>
    <div>
      <button @click="updateChart">Update!</button>
    </div>
  </div>
</template>

<script>
import VueApexCharts from "vue-apexcharts";

export default {
  name: "Chart",
  components: {
    apexcharts: VueApexCharts,
  },
  data: function () {
    return {
      chartOptions: {
        chart: {
          id: "mixpanel-data",
        },
        xaxis: {
          categories: [1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998],
        },
      },
      series: [
        {
          name: "series-1",
          data: [30, 40, 45, 50, 49, 60, 70, 81],
        },
      ],
    };
  },
  methods: {
    updateChart() {
      axios
        .get(`/chart-data-week`)
        .then((data) => {
          console.log(data.data.data);
          let response = data.data.data;
          this.series = response[0];
          this.chartOptions.xaxis.categories = response[1];
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>
<style scoped>
button {
  background: #26e6a4;
  border: 0;
  font-size: 16px;
  color: "#fff";
  padding: 10px;
  margin-left: 28px;
}
</style>

