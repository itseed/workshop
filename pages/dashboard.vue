<template>
  <b-container class="pt-3">
    <h3>Dashboard</h3>
    <b-row class="pt-3">
      <b-col class="p-3">
        <b-card sub-title="Total Follower">
          <p class="h2 mb-2"><b-icon icon="people"></b-icon> 10,000</p>
          <b-card-text>Today</b-card-text>
        </b-card>
      </b-col>
      <b-col class="p-3">
        <b-card sub-title="Total Customer">
          <p class="h2 mb-2"><b-icon icon="person-check"></b-icon> 10,000</p>
          <b-card-text>Today</b-card-text>
        </b-card>
      </b-col>
      <b-col class="p-3">
        <b-card sub-title="Total Block">
          <p class="h2 mb-2"><b-icon icon="person-x"></b-icon> 10,000</p>
          <b-card-text>Today</b-card-text>
        </b-card>
      </b-col>
      <b-col class="p-3">
        <b-card sub-title="Total New Customer">
          <p class="h2 mb-2"><b-icon icon="person-plus"></b-icon> 10,000</p>
          <b-card-text>Today</b-card-text>
        </b-card>
      </b-col>
    </b-row>
    <b-row class="pt-3">
      <b-col>
        <h3>Customer</h3>
      </b-col>
    </b-row>
    <b-row class="pt-3">
      <b-col>
        <bar-chart :data="barChartData" :options="barChartOptions" :height="200" />
      </b-col>
    </b-row>
    <b-row class="pt-3">
      <b-col>
        <h3>Last 50 Customers</h3>
      </b-col>
    </b-row>
    <b-row class="pt-3">
      <b-col>
        <b-table striped bordered borderless hover :items="items" :fields="fields"></b-table>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
import BarChart from '~/components/BarChart'

const chartColors = {
  red: 'rgb(255, 99, 132)',
  orange: 'rgb(255, 159, 64)',
  yellow: 'rgb(255, 205, 86)',
  green: 'rgb(75, 192, 192)',
  blue: 'rgb(54, 162, 235)',
  purple: 'rgb(153, 102, 255)',
  grey: 'rgb(201, 203, 207)'
};

export default {
  layout: 'backend',
  components: {
    BarChart
  },
  data() {
    return {
      // Note 'isActive' is left out and will not appear in the rendered table
      fields: [
        {
          key: 'last_name',
          sortable: true
        },
        {
          key: 'first_name',
          sortable: false
        },
        {
          key: 'age',
          label: 'Person age',
          sortable: true,
          // Variant applies to the whole column, including the header and footer
        }
      ],
      items: [
        { isActive: true, age: 40, first_name: 'Dickerson', last_name: 'Macdonald' },
        { isActive: false, age: 21, first_name: 'Larsen', last_name: 'Shaw' },
        { isActive: false, age: 89, first_name: 'Geneva', last_name: 'Wilson' },
        { isActive: true, age: 38, first_name: 'Jami', last_name: 'Carney' }
      ],
      barChartData: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [
          {
            label: 'Block',
            backgroundColor: chartColors.red,
            // backgroundColor: ["red", "orange", "yellow"],
            // backgroundColor: [chartColors.red, chartColors.green],
            data: [10, 15, 20,10, 15, 20,10, 15, 20,10, 15, 20]
          },
          {
            label: 'Unblock',
            backgroundColor: chartColors.green,
            // backgroundColor: ["red", "orange", "yellow"],
            // backgroundColor: [chartColors.red, chartColors.green],
            data: [10, 15, 20,10, 15, 20,10, 15, 20,10, 15, 20]
          }
        ]
      },
      barChartOptions: {
        responsive: true,
        legend: {
          position: 'top',
        },
        title: {
          display: true,
          text: 'Total Customer'
        },
        scales: {
          yAxes: [
            {
              ticks: {
                beginAtZero: true
              }
            }
          ]
        }
      }
    }
  }
}
</script>