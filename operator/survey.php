<!DOCTYPE html>
<?php
session_start();
if ($_SESSION['islogin'] != true) {
  header('location:../index');
}
if ($_SESSION['role'] == 'operator') {
  $counter = '1';
} else {
  header('location:../db/logout.php');
}
include "../db/bridge.php";

?>

<html id="fullscreen">

<head>
  <meta charset="utf-8">
  <title>Survey Kepuasan</title>
  <link href="../css/style.css" type="text/css" rel="stylesheet" />
  <link rel="icon" type="image/gif" href="../images/favicon.png" />

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">

  <link rel="stylesheet" href="../css/animate.css">
  <link rel="stylesheet" href="../css/survey.css">

  <link rel="stylesheet" href="../css/keyboard.css">

</head>

<body>
  <!-- <button class="nav-item cta"><a href="../db/logout.php"
      class="nav-link" data-target="#modalRequest"><span>logout</span></a></button>-->

  <div id="header">
    <button onclick="openFullscreen();" style="background-color:transparent;border-style:none"><img class="images" src="../images/logo.png"></button>
    <div class="tittle-header">
      <a class="title">CV. BINTANG SEMBILAN</a>
      <a class="title">Perum Gunungsari Indah 36</a>
      <a class="title">SURABAYA</a>
    </div>
  </div>

  <div id="content">
    <section>
      <div class="title-fieldset">SURVEY KEPUASAN MASYARAKAT</div>
      <form action="../db/input.php?id=<?php echo $counter ?>" method="post">
        <div class="container">
          <!-- Steps -->
          <div class="form-step form-step-active">
            <h2>
              <?php
              $sql = "SELECT * from question where id_text='$counter+a'";
              $query = mysqli_query($con, $sql);
              $show = mysqli_fetch_array($query);
              echo $show['text']; ?>
            </h2>

            <fieldset id="group1">
              <label>
                <input type="radio" name="q1" value="tidak puas" required=required
                  class="btn btn-next width-50 ml-auto">
                <img src="../images/Emot4/sgt-tdk-puas.gif" width="160px" height="160px">
                <!-- <br/> <p>tidak puas</p> -->
              </label>
              <label>
                <input type="radio" name="q1" value="kurang puas" required=required
                  class="btn btn-next width-50 ml-auto">
                <img src="../images/Emot4/tidak-puas.gif" width="160px" height="160px">
                <!-- <br/> <p>kurang puas</p> -->
              </label>
              <label>
                <input type="radio" name="q1" value="puas" required=required class="btn btn-next width-50 ml-auto">
                <img src="../images/Emot4/puas.gif" width="160px" height="160px">
                <!-- <br/> <p>puas</p> -->
              </label>
              <label>
                <input type="radio" name="q1" value="sangat puas" required=required
                  class="btn btn-next width-50 ml-auto">
                <img src="../images/Emot4/sangat-puas.gif" width="160px" height="160px">
                <!-- <br/> <p>sangat puas</p> -->
              </label>
            </fieldset>
          </div>

          <div class="form-step">
            <h2>
              <?php
              $sql = "SELECT * from question where id_text='$counter+b'";
              $query = mysqli_query($con, $sql);
              $show = mysqli_fetch_array($query);
              echo $show['text']; ?>
            </h2>

            <fieldset id="group2">
              <label>
                <input type="radio" name="q2" value="tidak puas" required=required
                  class="btn btn-next width-50 ml-auto">
                <img src="../images/Emot4/sgt-tdk-puas.gif" width="160px" height="160px">
                <!-- <br/> <p>tidak puas</p> -->
              </label>
              <label>
                <input type="radio" name="q2" value="kurang puas" required=required
                  class="btn btn-next width-50 ml-auto">
                <img src="../images/Emot4/tidak-puas.gif" width="160px" height="160px">
                <!-- <br/> <p>kurang puas</p> -->
              </label>
              <label>
                <input type="radio" name="q2" value="puas" required=required class="btn btn-next width-50 ml-auto">
                <img src="../images/Emot4/puas.gif" width="160px" height="160px">
                <!-- <br/> <p>puas</p> -->
              </label>
              <label>
                <input type="radio" name="q2" value="sangat puas" required=required
                  class="btn btn-next width-50 ml-auto">
                <img src="../images/Emot4/sangat-puas.gif" width="160px" height="160px">
                <!-- <br/> <p>sangat puas</p> -->
              </label>
            </fieldset>
          </div>

          <div class="form-step">
            <h2>
              <?php
              $sql = "SELECT * from question where id_text='$counter+c'";
              $query = mysqli_query($con, $sql);
              $show = mysqli_fetch_array($query);
              echo $show['text']; ?>
            </h2>

            <fieldset id="group3">
              <label>
                <input type="radio" name="q3" value="tidak puas" required=required
                  class="btn btn-next width-50 ml-auto">
                <img src="../images/Emot4/sgt-tdk-puas.gif" width="160px" height="160px">
                <!-- <br/> <p>tidak puas</p> -->
              </label>
              <label>
                <input type="radio" name="q3" value="kurang puas" required=required
                  class="btn btn-next width-50 ml-auto">
                <img src="../images/Emot4/tidak-puas.gif" width="160px" height="160px">
                <!-- <br/> <p>kurang puas</p> -->
              </label>
              <label>
                <input type="radio" name="q3" value="puas" required=required class="btn btn-next width-50 ml-auto">
                <img src="../images/Emot4/puas.gif" width="160px" height="160px">
                <!-- <br/> <p>puas</p> -->
              </label>
              <label>
                <input type="radio" name="q3" value="sangat puas" required=required
                  class="btn btn-next width-50 ml-auto">
                <img src="../images/Emot4/sangat-puas.gif" width="160px" height="160px">
                <!-- <br/> <p>sangat puas</p> -->
              </label>
            </fieldset>
          </div>

          <div class="form-step">
            <h2>
              <?php
              $sql = "SELECT * from question where id_text='$counter+d'";
              $query = mysqli_query($con, $sql);
              $show = mysqli_fetch_array($query);
              echo $show['text']; ?>
            </h2>

            <fieldset id="group4">
              <label>
                <input type="radio" name="q4" value="tidak puas" required=required
                  class="btn btn-next width-50 ml-auto">
                <img src="../images/Emot4/sgt-tdk-puas.gif" width="160px" height="160px">
                <!-- <br/> <p>tidak puas</p> -->
              </label>
              <label>
                <input type="radio" name="q4" value="kurang puas" required=required
                  class="btn btn-next width-50 ml-auto">
                <img src="../images/Emot4/tidak-puas.gif" width="160px" height="160px">
                <!-- <br/> <p>kurang puas</p> -->
              </label>
              <label>
                <input type="radio" name="q4" value="puas" required=required class="btn btn-next width-50 ml-auto">
                <img src="../images/Emot4/puas.gif" width="160px" height="160px">
                <!-- <br/> <p>puas</p> -->
              </label>
              <label>
                <input type="radio" name="q4" value="sangat puas" required=required
                  class="btn btn-next width-50 ml-auto">
                <img src="../images/Emot4/sangat-puas.gif" width="160px" height="160px">
                <!-- <br/> <p>sangat puas</p> -->
              </label>
            </fieldset>
          </div>

          <div class="form-step">
            <h2>
              <?php
              $sql = "SELECT * from question where id_text='$counter+e'";
              $query = mysqli_query($con, $sql);
              $show = mysqli_fetch_array($query);
              echo $show['text']; ?>
            </h2>

            <fieldset id="group5">
              <label>
                <input type="radio" name="q5" value="tidak puas" required=required
                  class="btn btn-next width-50 ml-auto">
                <img src="../images/Emot4/sgt-tdk-puas.gif" width="160px" height="160px">
                <!-- <br/> <p>tidak puas</p> -->
              </label>
              <label>
                <input type="radio" name="q5" value="kurang puas" required=required
                  class="btn btn-next width-50 ml-auto">
                <img src="../images/Emot4/tidak-puas.gif" width="160px" height="160px">
                <!-- <br/> <p>kurang puas</p> -->
              </label>
              <label>
                <input type="radio" name="q5" value="puas" required=required class="btn btn-next width-50 ml-auto">
                <img src="../images/Emot4/puas.gif" width="160px" height="160px">
                <!-- <br/> <p>puas</p> -->
              </label>
              <label>
                <input type="radio" name="q5" value="sangat puas" required=required
                  class="btn btn-next width-50 ml-auto">
                <img src="../images/Emot4/sangat-puas.gif" width="160px" height="160px">
                <!-- <br/> <p>sangat puas</p> -->
              </label>
            </fieldset>
          </div>

          <div class="form-step">
            <h2>
              <?php
              $sql = "SELECT * from question where id_text='$counter+f'";
              $query = mysqli_query($con, $sql);
              $show = mysqli_fetch_array($query);
              echo $show['text']; ?>
            </h2>

            <fieldset id="group6">
              <label>
                <input type="radio" name="q6" value="tidak puas" required=required
                  class="btn btn-next width-50 ml-auto">
                <img src="../images/Emot4/sgt-tdk-puas.gif" width="160px" height="160px">
                <!-- <br/> <p>tidak puas</p> -->
              </label>
              <label>
                <input type="radio" name="q6" value="kurang puas" required=required
                  class="btn btn-next width-50 ml-auto">
                <img src="../images/Emot4/tidak-puas.gif" width="160px" height="160px">
                <!-- <br/> <p>kurang puas</p> -->
              </label>
              <label>
                <input type="radio" name="q6" value="puas" required=required class="btn btn-next width-50 ml-auto">
                <img src="../images/Emot4/puas.gif" width="160px" height="160px">
                <!-- <br/> <p>puas</p> -->
              </label>
              <label>
                <input type="radio" name="q6" value="sangat puas" required=required
                  class="btn btn-next width-50 ml-auto">
                <img src="../images/Emot4/sangat-puas.gif" width="160px" height="160px">
                <!-- <br/> <p>sangat puas</p> -->
              </label>
            </fieldset>
          </div>

          <div class="form-step">
            <h2>
              <?php
              $sql = "SELECT * from question where id_text='$counter+g'";
              $query = mysqli_query($con, $sql);
              $show = mysqli_fetch_array($query);
              echo $show['text']; ?>
            </h2>

            <fieldset id="group7">
              <label>
                <input type="radio" name="q7" value="tidak puas" required=required
                  class="btn btn-next width-50 ml-auto">
                <img src="../images/Emot4/sgt-tdk-puas.gif" width="160px" height="160px">
                <!-- <br/> <p>tidak puas</p> -->
              </label>
              <label>
                <input type="radio" name="q7" value="kurang puas" required=required
                  class="btn btn-next width-50 ml-auto">
                <img src="../images/Emot4/tidak-puas.gif" width="160px" height="160px">
                <!-- <br/> <p>kurang puas</p> -->
              </label>
              <label>
                <input type="radio" name="q7" value="puas" required=required class="btn btn-next width-50 ml-auto">
                <img src="../images/Emot4/puas.gif" width="160px" height="160px">
                <!-- <br/> <p>puas</p> -->
              </label>
              <label>
                <input type="radio" name="q7" value="sangat puas" required=required
                  class="btn btn-next width-50 ml-auto">
                <img src="../images/Emot4/sangat-puas.gif" width="160px" height="160px">
                <!-- <br/> <p>sangat puas</p> -->
              </label>
            </fieldset>
          </div>

          <div class="form-step">
            <h2>
              <?php
              $sql = "SELECT * from question where id_text='$counter+h'";
              $query = mysqli_query($con, $sql);
              $show = mysqli_fetch_array($query);
              echo $show['text']; ?>
            </h2>

            <fieldset id="group8">
              <label>
                <input type="radio" name="q8" value="tidak puas" required=required
                  class="btn btn-next width-50 ml-auto">
                <img src="../images/Emot4/sgt-tdk-puas.gif" width="160px" height="160px">
                <!-- <br/> <p>tidak puas</p> -->
              </label>
              <label>
                <input type="radio" name="q8" value="kurang puas" required=required
                  class="btn btn-next width-50 ml-auto">
                <img src="../images/Emot4/tidak-puas.gif" width="160px" height="160px">
                <!-- <br/> <p>kurang puas</p> -->
              </label>
              <label>
                <input type="radio" name="q8" value="puas" required=required class="btn btn-next width-50 ml-auto">
                <img src="../images/Emot4/puas.gif" width="160px" height="160px">
                <!-- <br/> <p>puas</p> -->
              </label>
              <label>
                <input type="radio" name="q8" value="sangat puas" required=required
                  class="btn btn-next width-50 ml-auto">
                <img src="../images/Emot4/sangat-puas.gif" width="160px" height="160px">
                <!-- <br/> <p>sangat puas</p> -->
              </label>
            </fieldset>
          </div>

          <div class="form-step">
            <h2>
              <?php
              $sql = "SELECT * from question where id_text='$counter+i'";
              $query = mysqli_query($con, $sql);
              $show = mysqli_fetch_array($query);
              echo $show['text']; ?>
            </h2>

            <fieldset id="group9">
              <label>
                <input type="radio" name="q9" value="tidak puas" required=required
                  class="btn btn-next width-50 ml-auto">
                <img src="../images/Emot4/sgt-tdk-puas.gif" width="160px" height="160px">
                <!-- <br/> <p>tidak puas</p> -->
              </label>
              <label>
                <input type="radio" name="q9" value="kurang puas" required=required
                  class="btn btn-next width-50 ml-auto">
                <img src="../images/Emot4/tidak-puas.gif" width="160px" height="160px">
                <!-- <br/> <p>kurang puas</p> -->
              </label>
              <label>
                <input type="radio" name="q9" value="puas" required=required class="btn btn-next width-50 ml-auto">
                <img src="../images/Emot4/puas.gif" width="160px" height="160px">
                <!-- <br/> <p>puas</p> -->
              </label>
              <label>
                <input type="radio" name="q9" value="sangat puas" required=required
                  class="btn btn-next width-50 ml-auto">
                <img src="../images/Emot4/sangat-puas.gif" width="160px" height="160px">
                <!-- <br/> <p>sangat puas</p> -->
              </label>
            </fieldset>
          </div>

          <div class="form-step">
            <h2>Kritik dan saran</h2>
            <input type="text" name="suggestion" class="form-control" placeholder="Tulis pesan anda disini"
              aria-label="Username">
            <br></br>
            <center>
              <input type="submit" name="submit" value="Submit" onclick="play()">
              <audio id="audio" src="../operator/thankyou.mp3"></audio>
            </center>
          </div>
        </div>
      </form>
    </section>
  </div>

  <div id="footer">
    <marquee>
      <span>Terima kasih atas saran dan masukan anda, bagi kami.</span>
    </marquee>
  </div>

  <script>
    var audio = document.getElementById('audio');

    setTimeout(function () {
      audio.play(); // play it through JavaScript after 3 seconds
    }, 1000);
  </script>

  <script src="../js/script.multiform.js"></script>
  <script src="../js/jquery.min.js"></script>
  <script src="../js/jquery-migrate-3.0.1.min.js"></script>
  <script src="../js/jquery.waypoints.min.js"></script>
  <script src="../js/jquery.stellar.min.js"></script>
  <script src="../js/owl.carousel.min.js"></script>
  <script src="../js/aos.js"></script>
  <script src="../js/scrollax.min.js"></script>
  <script src="../js/mainoperator.js"></script>

  <!--fullscreen-->
  <script src="../js/fullscreen.js"></script>
  <!--keyboard virtual -->
  <script src="../js/onscreen-keyboard.js"></script>

</body>

</html>