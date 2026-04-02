  <!-- header--------------------------------------------------------------------------------->

  <div class="container">
    <div class="bg-white mb-1 sticky-top container">
      <div class="row border border-black align-items-center">
        <div class=" col-auto text-center p-0 m-1"> <img src="/logo.png" alt=""> </div>

        <div class="col d-flex justify-content-center p-0">
          <div class=" col text-center d-none d-md-flex">
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
          <div class="dropdown d-flex d-md-none ">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              Izvēlne
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="/home">Uz sākumu</a></li>
              <li><a class="dropdown-item" href="/about">Par mums</a></li>
              <li><a class="dropdown-item" href="/more">aaa</a></li>
            </ul>
          </div>
        </div>
        <?php
        $session = session();
        if ($session->get('logged_in') == "1") {
          echo '<a href="/account" style="text-decoration:none; color:black;"class=" col-auto mx-1 p-0">
              <div style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;max-width:100px"> 
              <img class="" style="height:40px" src="' . base_url('uploads/avatar/' . $session->get('pfp')) . '">
              ' . $session->get('username') . '
              </div>
              </a>';
        } else {
          echo '<a href="/login" class=" col-1">
              <div> 
              <div>not logged in <br/>' . $session->get('account_id') . '
              </div>
              </div>
              </a>';
        }

        ?>
      </div>
    </div>

    <!-- header--------------------------------------------------------------------------------->