<!-- Sidebar navigation -->
<style>
.left-sidebar {
  position: absolute;
  width: 260px;
  height: 100%;
  top: 0;
  z-index: 10;
  background: 0 0;
  box-shadow: 0 3px 9px 0 rgba(169, 184, 200, 0.15);
  -webkit-box-shadow: 0 3px 9px 0 rgba(169, 184, 200, 0.15);
  -moz-box-shadow: 0 3px 9px 0 rgba(169, 184, 200, 0.15);
}

.scroll-sidebar {
  height: 100%;
  position: relative;
}

.sidebar-shadow {
  box-shadow: 0 3px 9px 0 rgba(162, 176, 190, 0.15);
  -webkit-box-shadow: 0 3px 9px 0 rgba(162, 176, 190, 0.15);
  -moz-box-shadow: 0 3px 9px 0 rgba(162, 176, 190, 0.15);
}

.sidebar-nav {
  padding-top: 30px;
}

.sidebar-nav #sidebarnav .list-divider {
  height: 1px;
  background: #254366ff;
  display: block;
  margin: 10px 0 20px 30px;
  opacity: 0.1;
}

.sidebar-nav #sidebarnav .sidebar-item .sidebar-link {
  color: #F4F7FC;
  font-size: 16px;
  padding: 12px 30px;
  display: flex;
  white-space: nowrap;
  align-items: center;
  line-height: 27px;
  opacity: 0.7;
  margin-right: 17px;
  text-decoration: none;
}

.sidebar-nav #sidebarnav .sidebar-item .sidebar-link .feather-icon,
.sidebar-nav #sidebarnav .sidebar-item .sidebar-link i {
  font-style: normal;
  height: 20px;
  width: 20px;
  color: #F4F7FC;
  display: inline-block;
  text-align: center;
  margin-right: 8px;
}

.sidebar-nav #sidebarnav .sidebar-item.selected > .sidebar-link {
  border-radius: 0 60px 60px 0;
  color: #F4F7FC !important;
  background: linear-gradient(
    to right,
    #0056b3,
    #0056b3
  );
  box-shadow: 0 7px 12px 0 rgba(95, 118, 232, 0.21);
  opacity: 1;
}

.sidebar-nav #sidebarnav .sidebar-item .first-level {
  padding: 0 0 10px;
}

.sidebar-nav #sidebarnav .nav-small-cap {
  font-size: 12px;
  padding: 0 30px;
  white-space: nowrap;
  display: flex;
  align-items: center;
  line-height: 30px;
  color: #F4F7FC;
  opacity: 1;
  margin-bottom: 5px;
  text-transform: uppercase;
  font-weight: 500;
}

.sidebar-nav .has-arrow::after {
  position: absolute;
  content: "";
  width: 7px;
  height: 7px;
  border-width: 1px 0 0 1px;
  border-style: solid;
  border-color: #F4F7FC;
  margin-left: 10px;
  transform: rotate(223deg) translate(0, -50%);
  transform-origin: top;
  top: 27px;
  right: 15px;
  transition: 0.3s ease-out;
}

.sidebar-nav .has-arrow[aria-expanded="true"]::after,
.sidebar-nav li.active > .has-arrow::after,
.sidebar-nav li > .has-arrow.active::after {
  transform: rotate(44deg) translate(0, -50%);
}
</style>

<nav class="sidebar-nav">
  <ul id="sidebarnav">
    <li class="sidebar-item">
      <a class="sidebar-link" href="dashboard.php" aria-expanded="false">
        <i data-feather="home" class="feather-icon"></i>
        <span class="hide-menu">Dashboard</span>
      </a>
    </li>

    <li class="list-divider"></li>

    <li class="nav-small-cap">
      <span class="hide-menu">Features</span>
    </li>

    <li class="sidebar-item">
      <a class="sidebar-link" href="book-hostel.php" aria-expanded="false">
        <i class="fas fa-h-square"></i>
        <span class="hide-menu">Book Hostel</span>
      </a>
    </li>

    <li class="sidebar-item">
      <a class="sidebar-link" href="room-details.php" aria-expanded="false">
        <i class="fas fa-bed"></i>
        <span class="hide-menu">My Room Details</span>
      </a>
    </li>

    <li class="sidebar-item">
      <a class="sidebar-link" href="inquire.php" aria-expanded="false">
        <i class="fas fa-exclamation-triangle"></i>
        <span class="hide-menu">Inquire</span>
      </a>
    </li>
  </ul>
</nav>
