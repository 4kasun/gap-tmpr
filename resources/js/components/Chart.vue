<template>
  <div class="app">
    <apexcharts
      width="550"
      type="line"
      :options="chartOptions"
      :series="series"
    ></apexcharts>
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
          type: "area",
          stacked: false,
          height: 350,
          stroke: {
            curve: "smooth",
          },
          zoom: {
            type: "x",
            enabled: true,
            autoScaleYaxis: true,
          },
          toolbar: {
            autoSelected: "zoom",
          },
        },
        title: {
          text: "WEEKLY RETENTION CURVES - MIXPANEL DATA",
          align: "left",
        },
        xaxis: {
          categories: [],
          labels: {
            formatter: function (value) {
              return value + " weeks later";
            },
          },
        },
        legend: {
          labels: {
            formatter: function (value) {
              return value + " weeks later";
            },
          },
        },
        yaxis: {
          min: 0,
          max: 100,
        },
      },
      series: [],
    };
  },
  created: function () {
    // `this` points to the vm instance
    this.updateChart();
  },
  methods: {
    updateChart() {
      axios
        .get(`/chart-data-week`)
        .then((data) => {
          console.log("response", data.data.data);
          let response = data.data.data;
          this.series = response[0];
          console.log("series", this.series);
          console.log("categories", response[1]);
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

