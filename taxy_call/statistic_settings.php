<style>
  #settings {
    background:yellow;
    height: 38px;
  }
  #settings :first-child  {
    margin-left:30%;
  }
  .set_style {
    height: 30px;
    margin-top:4px;
  }
</style>
<div id="settings">
  
  <label for="date">Select date</label>
  <input type="date" id="date" class="set_style"/>
  <label for="chart_select">Select company</label>
  <select id="chart_select" class="set_style">
    <option value="all_cmp">All taxi companies</option>
    <option value="city">City Taxi</option>
    <option value="hello">Hello Taxi</option>
    <option value="fulger">Fulger Taxi</option>
    <option value="start">Start Taxi</option>
  </select>
  
</div>