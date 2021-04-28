<?php
function session_close() {
  session_unset();
  session_destroy();
}
