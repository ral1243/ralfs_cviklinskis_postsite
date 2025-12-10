  <!-- header--------------------------------------------------------------------------------->
  <? $session = session(); ?>

  <div class="container-fluid">
    <div class="bg-white sticky-top">
      <div class="row border border-black align-items-center">
        <div class="border border-black col-2 text-center"> logologologologologo </div>

        <div class="border border-black col ">
          <div class="row text-center">
            <div class="col">
              <a href="/home"><button class="btn btn-primary text-center">Uz sākumu</button></a>
            </div>
            <div class="col">
              <a href="/about"><button class="btn btn-primary text-center">Par mums</button></a>
            </div>
            <div class="col">
              <a href="/more"><button class="btn btn-primary text-center">aaa</button></a>
            </div>
          </div>
        </div>
        <a href="/login" class="border border-black col-1">
          <div>
            <?php
            if ($session->get('logged_in') == "1") {
              echo "<div>logged in</div>";
            } else {
              echo "<div>not logged in</div>";
            }
            ?>
          </div>
        </a>
      </div>
    </div>
    <!-- header--------------------------------------------------------------------------------->