<template>
  <ul class="menu-nav">
    <li class="menu-item" aria-haspopup="true">
      <router-link :to="{ name: 'dashboard' }" class="menu-link">
        <i class="menu-icon flaticon-home"></i>
        <span class="menu-text">Anasayfa</span>
      </router-link>
    </li>
    <li class="menu-section">
      <h4 class="menu-text">General</h4>
      <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
    </li>
    <li
      class="menu-item menu-item-submenu"
      :class="[
        routerName === 'bots' || routerName === 'bot-maker'
          ? 'menu-item-open'
          : null
      ]"
      aria-haspopup="true"
      data-menu-toggle="hover"
    >
      <a href="javascript:;" class="menu-link menu-toggle">
        <span class="svg-icon menu-icon">
          <!--begin::Svg Icon | path:assets/media/svg/icons/Shopping/Box2.svg-->
          <svg
            xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink"
            width="24px"
            height="24px"
            viewBox="0 0 24 24"
            version="1.1"
          >
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
              <rect x="0" y="0" width="24" height="24" />
              <path
                d="M4,9.67471899 L10.880262,13.6470401 C10.9543486,13.689814 11.0320333,13.7207107 11.1111111,13.740321 L11.1111111,21.4444444 L4.49070127,17.526473 C4.18655139,17.3464765 4,17.0193034 4,16.6658832 L4,9.67471899 Z M20,9.56911707 L20,16.6658832 C20,17.0193034 19.8134486,17.3464765 19.5092987,17.526473 L12.8888889,21.4444444 L12.8888889,13.6728275 C12.9050191,13.6647696 12.9210067,13.6561758 12.9368301,13.6470401 L20,9.56911707 Z"
                fill="#000000"
              />
              <path
                d="M4.21611835,7.74669402 C4.30015839,7.64056877 4.40623188,7.55087574 4.5299008,7.48500698 L11.5299008,3.75665466 C11.8237589,3.60013944 12.1762411,3.60013944 12.4700992,3.75665466 L19.4700992,7.48500698 C19.5654307,7.53578262 19.6503066,7.60071528 19.7226939,7.67641889 L12.0479413,12.1074394 C11.9974761,12.1365754 11.9509488,12.1699127 11.9085461,12.2067543 C11.8661433,12.1699127 11.819616,12.1365754 11.7691509,12.1074394 L4.21611835,7.74669402 Z"
                fill="#000000"
                opacity="0.3"
              />
            </g>
          </svg>
          <!--end::Svg Icon-->
        </span>
        <span class="menu-text">Bot Maker</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="menu-submenu">
        <i class="menu-arrow"></i>
        <ul class="menu-subnav">
          <li
            class="menu-item"
            :class="[routerName === 'bots' ? 'menu-item-active' : null]"
            aria-haspopup="true"
          >
            <router-link
              :to="{ name: 'bots' }"
              @click.native="routeActive()"
              class="menu-link"
            >
              <i class="menu-bullet menu-bullet-dot">
                <span></span>
              </i>
              <span class="menu-text">Bot Lists</span>
            </router-link>
          </li>
          <li
            class="menu-item"
            :class="[routerName === 'bot-maker' ? 'menu-item-active' : null]"
            aria-haspopup="true"
          >
            <router-link
              :to="{ name: 'bot-maker' }"
              @click.native="routeActive()"
              class="menu-link"
            >
              <i class="menu-bullet menu-bullet-dot">
                <span></span>
              </i>
              <span class="menu-text">Bot Maker</span>
            </router-link>
          </li>
        </ul>
      </div>
    </li>
    <li class="menu-section">
      <h4 class="menu-text">General Settings</h4>
      <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
    </li>
  </ul>
</template>

<script>
export default {
  data() {
    return {
      routerName: "dashboard"
    };
  },
  methods: {
    routeActive() {
      this.routerName = this.$route.name;
    }
  },
  mounted() {
    this.routerName = this.$route.name;
  }
};
</script>
